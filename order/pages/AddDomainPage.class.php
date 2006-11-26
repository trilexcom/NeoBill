<?php
/**
 * AddDomainPage.class.php
 *
 * This file contains the definition for the AddDomainPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * AddDomainPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddDomainPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "domainoption":
	if( isset( $this->post['cancel'] ) )
	  {
	    $this->cancel();
	  }
	else
	  {
	    switch( $this->post['domainaction'] )
	      {
	      case "Register Domain": $this->whois(); break;
	      case "Transfer Domain": $this->transfer(); break;
	      case "Existing Domain": $this->process_existing(); break;
	      }
	  }
	break;

      case "registerdomain":
	if( isset( $this->post['cancel'] ) )
	  {
	    $this->cancel();
	  }
	elseif( isset( $this->post['back'] ) )
	  {
	    $this->setTemplate( "default" );
	  }
	elseif( isset( $this->post['continue'] ) ||
		isset( $this->post['another'] ))
	  {
	    $this->process_registration();
	  }
	break;

      case "transferdomain":
	if( isset( $this->post['cancel'] ) )
	  {
	    $this->cancel();
	  }
	elseif( isset( $this->post['back'] ) )
	  {
	    $this->setTemplate( "default" );
	  }
	elseif( isset( $this->post['continue'] ) ||
		isset( $this->post['another'] ) )
	  {
	    $this->process_transfer();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goto( "cart" );
  }

  /**
   * Done Processing Domain Name
   */
  function done()
  {
    if( $_SESSION['order']->skipHosting() || 
	$_SESSION['order']->getHostingItems() != null )
      {
	$this->goto( "cart" );
      }

    $this->goto( "addhosting" );
  }

  /**
   * Init
   *
   * Populates the combo boxes with a list of tld's offered by the provider
   */
  function init()
  {
    if( load_array_DomainServiceDBO() == null )
      {
	// No domains to add
	$this->done();
      }

    if( !isset( $_SESSION['order'] ) )
      {
	// Start a new order
	$_SESSION['order'] = new OrderDBO();
      }

    // Get name servers
    $this->smarty->assign( "nameservers", $this->conf['dns']['nameservers'] );

    $this->smarty->assign( "show_cancel", 
			   $this->getLastPage() == "cart" && !$_SESSION['order']->isEmpty() );
  }

  /**
   * Process an existing domain - no purchase
   */
  function process_existing()
  {
    if( empty( $this->post['existingdomainname'] ) )
      {
	$this->setError( array( "type" => "FIELD_MISSING",
				"args" => array( "Domain Name" ) ) );
	$this->reload();
      }

    // Create a Domain Order Item
    $dbo = new OrderDomainDBO();
    $dbo->setType( "Existing" );
    $dbo->setDomainName( $this->post['existingdomainname'] );

    // Add domain to the order
    $_SESSION['order']->addExistingDomain( $dbo );

    $this->done();
  }

  /**
   * Process a domain registration
   */
  function process_registration()
  {
    // Create a Domain Order Item
    $dbo = new OrderDomainDBO();
    $dbo->setType( "New" );
    $dbo->setPurchasable( $this->session['domainoption']['registerdomaintld'] );
    $dbo->setDomainName( $this->session['domainoption']['registerdomainname'] );
    $dbo->setTerm( $this->post['period']->getTermLength() );

    // Add the item to the order
    $_SESSION['order']->addItem( $dbo );

    if( isset( $this->post['another'] ) )
      {
	// Add Another Domain
	unset( $this->session['domainoption'] );
	$this->setTemplate( "default" );
      }
    else
      {
	// Continue
	$this->done();
      }
  }

  /**
   * Process a domain transfer
   */
  function process_transfer()
  {
    // Create a Domain Order Item
    $dbo = new OrderDomainDBO();
    $dbo->setType( "Transfer" );
    $dbo->setPurchasable( $this->session['domainoption']['transferdomaintld'] );
    $dbo->setDomainName( $this->session['domainoption']['transferdomainname'] );
    $dbo->setTransferSecret( $this->post['secret'] );
    $dbo->setTerm( $this->post['period']->getTermLength() );

    // Add the item to the order
    $_SESSION['order']->addItem( $dbo );

    if( isset( $this->post['another'] ) )
      {
	// Add Another Domain
	unset( $this->session['domainoption'] );
	$this->setTemplate( "default" );
      }
    else
      {
	// Continue
	$this->done();
      }
  }

  /**
   * Transfer a Domain
   */
  function transfer()
  {
    $domain_name = $this->post['transferdomainname'];
    $tld = $this->post['transferdomaintld']->getTLD();
    $fqdn = $domain_name . "." . $tld;

    if( empty( $domain_name ) || empty( $tld ) )
      {
	$this->setError( array( "type" => "FIELD_MISSING",
				"args" => array( "Domain Name" ) ) );
	$this->reload();
      }

    // Access the Registrar module
    $registry = ModuleRegistry::getModuleRegistry();
    $module = $registry( $this->post['transferdomaintld']->getModuleName() );

    // Check transfer eligibility
    if( !$module->isTransferable( $fqdn ) )
      {
	// Domain must be registered
	$this->setError( array( "type" => "ERROR_DOMAIN_TRANSFER_NO_DOMAIN",
				"args" => array( $fqdn ) ) );
	$this->reload();
      }

    // and show the transfer page
    $termWidget = $this->forms['transferdomain']->getField( "period" )->getWidget();
    $termWidget->setPurchasable( $this->post['registerdomaintld'] );
    $this->smarty->assign( "domain_name", $domain_name );
    $this->smarty->assign( "domain_tld", $tld );
    $this->setTemplate( "transfer" );
  }

  /**
   * Perform a WHOIS for a new domain registration
   */
  function whois()
  {
    $domain_name = $this->post['registerdomainname'];
    $tld = $this->post['registerdomaintld']->getTLD();
    $fqdn = $domain_name . "." . $tld;

    if( empty( $domain_name ) || empty( $tld ) )
      {
	$this->setError( array( "type" => "FIELD_MISSING",
				"args" => array( "Domain Name" ) ) );
	$this->reload();
      }

    // Access the Registrar module
    $registry = ModuleRegistry::getModuleRegistry();
    $module = $registry->getModule( $this->post['registerdomaintld']->getModuleName() );

    // Check WHOIS
    if( !$module->checkAvailability( $fqdn ) )
      {
	// Domain is NOT available
	$this->setError( array( "type" => "ERROR_DOMAIN_NOT_AVAILABLE" ) );
	$this->reload();
      }

    // Place domain in the session
    $this->session['registerdomain']['domainname'] = $domain_name;
    $this->session['registerdomain']['tld'] = $tld;

    // and show the registration page
    $termWidget = $this->forms['registerdomain']->getField( "period" )->getWidget();
    $termWidget->setPurchasable( $this->post['registerdomaintld'] );
    $this->smarty->assign( "domain_name", $domain_name );
    $this->smarty->assign( "domain_tld", $tld );
    $this->setTemplate( "register_new_domain" );
  }
}

?>