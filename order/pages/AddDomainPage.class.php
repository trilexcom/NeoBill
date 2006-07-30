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
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/DomainServiceDBO.class.php";
require_once $base_path . "DBO/OrderDBO.class.php";

/**
 * AddDomainPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddDomainPage extends Page
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
	if( isset( $this->session['domainoption']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	else
	  {
	    switch( $this->session['domainoption']['domainaction'] )
	      {
	      case "Register Domain": $this->whois(); break;
	      case "Transfer Domain": $this->transfer(); break;
	      case "Existing Domain": $this->process_existing(); break;
	      }
	  }
	break;

      case "registerdomain":
	if( isset( $this->session['registerdomain']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	elseif( isset( $this->session['registerdomain']['back'] ) )
	  {
	    $this->setTemplate( "default" );
	  }
	elseif( isset( $this->session['registerdomain']['continue'] ) ||
		isset( $this->session['registerdomain']['another'] ))
	  {
	    $this->process_registration();
	  }
	break;

      case "transferdomain":
	if( isset( $this->session['transferdomain']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	elseif( isset( $this->session['transferdomain']['back'] ) )
	  {
	    $this->setTemplate( "default" );
	  }
	elseif( isset( $this->session['transferdomain']['continue'] ) ||
		isset( $this->session['transferdomain']['another'] ) )
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
   * Populate the TLD drop-down menus
   *
   * @return array TLDs
   */
  function populateTLDs()
  {
    // Get all public DomainServiceDBO's
    $domainservices = load_array_DomainServiceDBO();

    // Populate the drop-downs
    $tlds = array();
    foreach( $domainservices as $domainservice )
      {
	$tlds[$domainservice->getTLD()] = $domainservice->getTLD();
      }

    return $tlds;
  }

  /**
   * Process an existing domain - no purchase
   */
  function process_existing()
  {
    // Create a Domain Order Item
    $dbo = new OrderDomainDBO();
    $dbo->setType( "Existing" );
    $dbo->setDomainName( $this->session['domainoption']['existingdomainname'] );

    // Add domain to the order
    $_SESSION['order']->addExistingDomain( $dbo );

    $this->done();
  }

  /**
   * Process a domain registration
   */
  function process_registration()
  {
    $servicedbo = 
      load_DomainServiceDBO( $this->session['domainoption']['registerdomaintld'] );

    // Create a Domain Order Item
    $dbo = new OrderDomainDBO();
    $dbo->setType( "New" );
    $dbo->setService( $servicedbo );
    $dbo->setDomainName( $this->session['domainoption']['registerdomainname'] );
    $dbo->setTerm( $this->session['registerdomain']['period'] );

    // Add the item to the order
    $_SESSION['order']->addItem( $dbo );

    if( isset( $this->session['registerdomain']['another'] ) )
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
    $servicedbo = 
      load_DomainServiceDBO( $this->session['domainoption']['transferdomaintld'] );
    
    // Create a Domain Order Item
    $dbo = new OrderDomainDBO();
    $dbo->setType( "Transfer" );
    $dbo->setService( $servicedbo );
    $dbo->setDomainName( $this->session['domainoption']['transferdomainname'] );
    $dbo->setTransferSecret( $this->session['transferdomain']['secret'] );
    $dbo->setTerm( $this->session['transferdomain']['period'] );

    // Add the item to the order
    $_SESSION['order']->addItem( $dbo );

    if( isset( $this->session['transferdomain']['another'] ) )
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
   * Generate a list of Registration Periods and pricing for a drop-down menu
   *
   * @param string $tld TLD
   */
  function registration_periods( $tld )
  {
    // Generate the list of periods and their pricing
    $ds_dbo = load_DomainServiceDBO( $tld );

    unset( $this->session['periods'] );
    $cs = $this->conf['locale']['currency_symbol'];
    $this->session['periods']['1 year'] = "[1_YEAR] - " . $cs . $ds_dbo->getPrice1yr();
    $this->session['periods']['2 year'] = "[2_YEARS] - " . $cs . $ds_dbo->getPrice2yr();
    $this->session['periods']['3 year'] = "[3_YEARS] - " . $cs . $ds_dbo->getPrice3yr();
    $this->session['periods']['4 year'] = "[4_YEARS] - " . $cs . $ds_dbo->getPrice4yr();
    $this->session['periods']['5 year'] = "[5_YEARS] - " . $cs . $ds_dbo->getPrice5yr();
    $this->session['periods']['6 year'] = "[6_YEARS] - " . $cs . $ds_dbo->getPrice6yr();
    $this->session['periods']['7 year'] = "[7_YEARS] - " . $cs . $ds_dbo->getPrice7yr();
    $this->session['periods']['8 year'] = "[8_YEARS] - " . $cs . $ds_dbo->getPrice8yr();
    $this->session['periods']['9 year'] = "[9_YEARS] - " . $cs . $ds_dbo->getPrice9yr();
    $this->session['periods']['10 year'] = "[10_YEARS] - " . $cs . $ds_dbo->getPrice10yr();
  }

  /**
   * Transfer a Domain
   */
  function transfer()
  {
    $domain_name = $this->session['domainoption']['transferdomainname'];
    $tld = $this->session['domainoption']['transferdomaintld'];
    $fqdn = $domain_name . "." . $tld;

    // Access the Registrar module
    $serviceDBO = load_DomainServiceDBO( $tld );
    $module = $this->conf['modules'][$serviceDBO->getModuleName()];

    // Check transfer eligibility
    if( !$module->isTransferable( $fqdn ) )
      {
	// Domain must be registered
	$this->setError( array( "type" => "ERROR_DOMAIN_TRANSFER_NO_DOMAIN",
				"args" => array( $fqdn ) ) );
	$this->goback( 1 );
      }

    // Populate the registration period drop-down menu
    $this->registration_periods( $tld );

    // and show the transfer page
    $this->smarty->assign( "domain_name", $domain_name );
    $this->smarty->assign( "domain_tld", $tld );
    $this->setTemplate( "transfer" );
  }

  /**
   * Perform a WHOIS for a new domain registration
   */
  function whois()
  {
    $domain_name = $this->session['domainoption']['registerdomainname'];
    $tld = $this->session['domainoption']['registerdomaintld'];
    $fqdn = $domain_name . "." . $tld;

    // Access the Registrar module
    $serviceDBO = load_DomainServiceDBO( $tld );
    $module = $this->conf['modules'][$serviceDBO->getModuleName()];

    // Check WHOIS
    if( !$module->checkAvailability( $fqdn ) )
      {
	// Domain is NOT available
	$this->setError( array( "type" => "ERROR_DOMAIN_NOT_AVAILABLE" ) );
	$this->goback( 1 );
      }

    // Place domain in the session
    $this->session['registerdomain']['domainname'] = $domain_name;
    $this->session['registerdomain']['tld'] = $tld;

    // Populate the registration period drop-down menu
    $this->registration_periods( $tld );

    // and show the registration page
    $this->smarty->assign( "domain_name", $domain_name );
    $this->smarty->assign( "domain_tld", $tld );
    $this->setTemplate( "register_new_domain" );
  }
}

?>