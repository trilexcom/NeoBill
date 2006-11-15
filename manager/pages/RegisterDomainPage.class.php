<?php
/**
 * RegisterDomainPage.class.php
 *
 * This file contains the definition of the RegisterDomainPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

// Include DBO's
require_once BASE_PATH . "DBO/AccountDBO.class.php";
require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";
require_once BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";
require_once BASE_PATH . "DBO/ContactDBO.class.php";

/**
 * RegisterDomainPage
 *
 * This Page registers a domain name through the default Registrar module and places
 * an entry into the DomainServicePurchase table.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RegisterDomainPage extends SolidStatePage
{
  /**
   * @var AccountDBO Account this domain will be registered for
   */
  var $accountDBO = null;

  /**
   * @var DomainServicePurchaseDBO The domain service purchase being built for this registration
   */
  var $purchaseDBO = null;

  /**
   * Action
   *
   * Actions handled by this page:
   *   register_domain (form)
   *   register_domain_service (form)
   *   register_domain_customer_select (form)
   *   register_domain_customer_new (form)
   *   register_domain_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "register_domain":
	if( isset( $this->post['continue'] ) )
	  {
	    $this->checkAvailability();
	  }
	break;

      case "register_domain_service":
	if( isset( $this->post['continue'] ) )
	  {
	    // Proceed to confirm the domain registration
	    $this->confirm();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;

      case "register_domain_confirm":
	if( isset( $this->post['continue'] ) )
	  {
	    // Execute registration
	    $this->executeRegistration();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;

      default:

	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Cancel the Domain Registration process
   *
   * Called whenever a user clicks a "cancel" button.  Returns the user to the
   * first template.
   */
  function cancel()
  {
    $this->goto( "domains_register",
		 null,
		 null );
  }

  /**
   * Check Domain's Availability
   */
  function checkAvailability()
  {
    $registry = ModuleRegistry::getModuleRegistry();
    $module = $registry->getModule( $this->post['servicetld']->getModuleName() );

    $fqdn = sprintf( "%s.%s", 
		     $this->post['domainname'], 
		     $this->post['servicetld']->getTLD() );
    if( !$module->checkAvailability( $fqdn ) )
      {
	// Domain is NOT available
	$this->setError( array( "type" => "DOMAIN_NOT_AVAILABLE",
				"args" => array( $fqdn ) ) );
	$this->reload();
      }

    // Domain is avaialble
    $termField = $this->forms['register_domain_service']->getField( "term" );
    $termField->getWidget()->setDomainService( $this->post['servicetld'] );

    $this->purchaseDBO = new DomainServicePurchaseDBO();
    $this->purchaseDBO->setTLD( $this->post['servicetld']->getTLD() );
    $this->purchaseDBO->setDomainName( $this->post['domainname'] );

    $this->setMessage( array( "type" => "DOMAIN_IS_AVAILABLE",
			      "args" => array( $fqdn ) ) );
    $this->setTemplate( "whois_results" );
  }

  /**
   * Confirm Domain Registration
   */
  function confirm()
  {
    // Fill in the purchase DBO with the account id and purchase terms
    $this->accountDBO = $this->post['account'];
    $this->purchaseDBO->setAccountID( $this->accountDBO->getID() );
    $this->purchaseDBO->setTerm( $this->post['term'] );

    // Provide the template with the name servers
    $this->smarty->assign( "nameservers", $this->conf['dns']['nameservers'] );

    // Display the confirmation template
    $this->setTemplate( "confirm" );
  }

  /**
   * Execute Registration
   */
  function executeRegistration()
  {
    // Load the registrar module and verify that it is enabled
    $this->serviceDBO = load_DomainServiceDBO( $this->purchaseDBO->getTLD() );

    $registry = ModuleRegistry::getModuleRegistry();
    $module = $registry->getModule( $this->purchaseDBO->getModuleName() );

    // Set the time of purchase
    $this->purchaseDBO->setDate( $this->DB->format_datetime( time() ) );

    // Prepare contact info
    $contacts['admin'] = new ContactDBO( $this->accountDBO->getContactName(),
					 $this->accountDBO->getBusinessName(),
					 $this->accountDBO->getContactEmail(),
					 $this->accountDBO->getAddress1(),
					 $this->accountDBO->getAddress2(),
					 null,
					 $this->accountDBO->getCity(),
					 $this->accountDBO->getState(),
					 $this->accountDBO->getPostalCode(),
					 $this->accountDBO->getCountry(),
					 $this->accountDBO->getPhone(),
					 null,
					 $this->accountDBO->getFax() );
    $contacts['tech'] = $contacts['admin'];
    $contacts['billing'] = $contacts['admin'];

    // Execute the registration at the Registrar
    if( !$module->registerNewDomain( $this->purchaseDBO->getDomainName(),
				     $this->purchaseDBO->getTLD(),
				     $this->purchaseDBO->getTermInt(),
				     $contacts,
				     $this->accountDBO ) )
      {
	$this->setError( array( "type" => "DOMAIN_REGISTER_FAILED_REGISTRAR" ) );
	$this->cancel();
      }
    
    // Store the purchase in database
    if( !add_DomainServicePurchaseDBO( $this->purchaseDBO ) )
      {
	$this->setError( array( "type" => "DOMAIN_REGISTER_FAILED_DB" ) );
	$this->cancel();
      }

    // Registration complete
    $this->setMessage( array( "type" => "DOMAIN_REGISTERED",
			      "args" => array( $this->purchaseDBO->getFullDomainName() ) ) );
    $this->goto( "domains_browse", null, null );
  }

  /**
   * Initialize the Page
   *
   * If an account ID is provided via GET parameters, load the AccountDBO and place
   * it in the session.
   */
  function init()
  {
    parent::init();

    $this->purchaseDBO =& $this->session['dspdbo'];
    $this->accountDBO =& $this->session['accountdbo'];
  }
}

?>