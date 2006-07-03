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
require_once $base_path . "solidworks/Page.class.php";

// Include DBO's
require_once $base_path . "DBO/AccountDBO.class.php";
require_once $base_path . "DBO/DomainServiceDBO.class.php";
require_once $base_path . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * RegisterDomainPage
 *
 * This Page registers a domain name through the default Registrar module and places
 * an entry into the DomainServicePurchase table.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RegisterDomainPage extends Page
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
	if( isset( $this->session['register_domain']['continue'] ) )
	  {
	    $this->checkAvailability();
	  }
	break;

      case "register_domain_service":
	if( isset( $this->session['register_domain_service']['continue'] ) )
	  {
	    // Proceed to confirm the domain registration
	    $this->confirm();
	  }
	elseif( isset( $this->session['register_domain_service']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;

      case "register_domain_confirm":
	if( isset( $this->session['register_domain_confirm']['continue'] ) )
	  {
	    // Execute registration
	    $this->executeRegistration();
	  }
	elseif( isset( $this->session['register_domain_confirm']['cancel'] ) )
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
    $serviceDBO = 
      load_DomainServiceDBO( $this->session['register_domain']['servicetld'] );
    $module = $this->conf['modules'][$serviceDBO->getModuleName()];

    $fqdn = sprintf( "%s.%s",
		     $this->session['register_domain']['domainname'],
		     $this->session['register_domain']['servicetld'] );
    if( !$module->checkAvailability( $fqdn ) )
      {
	// Domain is NOT available
	$this->setError( array( "type" => "DOMAIN_NOT_AVAILABLE",
				"args" => array( $fqdn ) ) );
	$this->goback( 1 );
      }

    // Domain is avaialble
    $this->purchaseDBO = new DomainServicePurchaseDBO();
    $this->purchaseDBO->setTLD( $this->session['register_domain']['servicetld'] );
    $this->purchaseDBO->setDomainName( $this->session['register_domain']['domainname'] );
    $this->setMessage( array( "type" => "DOMAIN_IS_AVAILABLE",
			      "args" => array( $fqdn ) ) );
    $this->setTemplate( "whois_results" );
  }

  /**
   * Confirm Domain Registration
   */
  function confirm()
  {
    // Load the account DBO
    if( !($this->accountDBO = load_AccountDBO( $this->session['register_domain_service']['accountid'] )) )
      {
	fatal_error( "RegisterDomainPage::confirm()","Failed to load Account!" );
      }

    // Fill in the purchase DBO with the account id and purchase terms
    $this->purchaseDBO->setAccountID( $this->accountDBO->getID() );
    $this->purchaseDBO->setTerm( $this->session['register_domain_service']['term'] );

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
    $serviceDBO = load_DomainServiceDBO( $this->purchaseDBO->getTLD() );
    $module = $this->conf['modules'][$serviceDBO->getModuleName()];
    $module->checkEnabled();

    // Set the time of purchase
    $this->purchaseDBO->setDate( $this->DB->format_datetime( time() ) );

    // Prepare contact info
    $contacts['admin']['name'] = $this->accountDBO->getContactName();
    $contacts['admin']['company'] = $this->accountDBO->getBusinessName();
    $contacts['admin']['email'] = $this->accountDBO->getContactEmail();
    $contacts['admin']['address1'] = $this->accountDBO->getAddress1();
    $contacts['admin']['address2'] = $this->accountDBO->getAddress2();
    $contacts['admin']['address3'] = "";
    $contacts['admin']['city'] = $this->accountDBO->getCity();
    $contacts['admin']['state'] = $this->accountDBO->getState();
    $contacts['admin']['country'] = $this->accountDBO->getCountry();
    $contacts['admin']['zip'] = $this->accountDBO->getPostalCode();
    $contacts['admin']['phone'] = $this->accountDBO->getPhone();
    $contacts['admin']['fax'] = $this->accountDBO->getFax();
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
    $id = $_GET['id'];
    $this->purchaseDBO =& $this->session['dspdbo'];
    $this->accountDBO =& $this->session['accountdbo'];

    if( isset( $id ) )
      {
	// Retrieve the Account from the database
	if( !($this->accountDBO = load_AccountDBO( intval( $id ) )) )
	  {
	    fatal_error( "RegisterDomainPage::init()", "Could not load account." );
	  }
      }
  }

  /**
   * Populate the Registration Term drop-down menu
   *
   * @return array Term => Description + price
   */
  function populateTermField()
  {
    global $cs;

    $cs = $this->conf['locale']['currency_symbol'];
    $dsDBO = load_DomainServiceDBO( $this->session['dspdbo']->getTLD() );
    $return['1 year'] = "[1_YEAR] - " . $cs . $dsDBO->getPrice1yr();
    $return['2 year'] = "[2_YEARS] - " . $cs . $dsDBO->getPrice2yr();
    $return['3 year'] = "[3_YEARS] - " . $cs . $dsDBO->getPrice3yr();
    $return['4 year'] = "[4_YEARS] - " . $cs . $dsDBO->getPrice4yr();
    $return['5 year'] = "[5_YEARS] - " . $cs . $dsDBO->getPrice5yr();
    $return['6 year'] = "[6_YEARS] - " . $cs . $dsDBO->getPrice6yr();
    $return['7 year'] = "[7_YEARS] - " . $cs . $dsDBO->getPrice7yr();
    $return['8 year'] = "[8_YEARS] - " . $cs . $dsDBO->getPrice8yr();
    $return['9 year'] = "[9_YEARS] - " . $cs . $dsDBO->getPrice9yr();
    $return['10 year'] = "[10_YEARS] - " . $cs . $dsDBO->getPrice10yr();
    return $return;
  }

}

?>