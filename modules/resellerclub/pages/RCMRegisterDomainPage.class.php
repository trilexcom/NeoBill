<?php
/**
 * RCMRegisterDomainPage.class.php
 *
 * This file contains the definition of the RCMRegisterDomainPage class.
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
 * RCMRegisterDomainPage
 *
 * This Page registers a domain name through the default Registrar module and places
 * an entry into the DomainServicePurchase table.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RCMRegisterDomainPage extends Page
{
  /**
   * @var ResellerClub Reseller Club Module
   */
  var $rcModule = null;

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
      case "rcm_customer":
	if( isset( $this->session['rcm_customer']['continue'] ) )
	  {
	    // Proceed to confirmation
	    $this->processNewDomain();
	  }
	elseif( isset( $this->session['rcm_customer']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;
	
      case "rcm_customer_new":
	if( isset( $this->session['rcm_customer_new']['continue'] ) )
	  {
	    // Add Reseller Club customer
	    $this->addRCCustomer();
	  }
	elseif( isset( $this->session['register_domain_customer_new']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;

      case "rcm_register_confirm":
	if( isset( $this->session['rcm_register_confirm']['continue'] ) )
	  {
	    // Execute registration
	    $this->executeRegistration();
	  }
	elseif( isset( $this->session['rcm_register_confirm']['cancel'] ) )
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
   * Add Reseller Club Customer
   */
  function addRCCustomer()
  {
    // Add a Reseller Club customer
    $data = $this->session['rcm_customer_new'];
    if( !$this->rcModule->addCustomer( $data['username'],
				       $data['password'],
				       $data['contactname'],
				       $data['businessname'],
				       $data['address1'],
				       $data['address2'],
				       "",
				       $data['city'],
				       $data['state'],
				       $data['country'],
				       $data['postalcode'],
				       $data['phone'],
				       $data['mobilephone'],
				       $data['fax'] ) )
      {
	// Error adding customer
	fatal_error( "RCMRegisterDomaiPage::addRCCustomer()",
		     "An error occured when trying to add a Reseller Club customer.  Turn on debugging for more information" );
      }

    // Proceed to confirmation
    $this->processNewDomain();
  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goto( "domains_register" );
  }

  /**
   * Execute Registration
   */
  function executeRegistration()
  {
    // Set the time of purchase
    $this->session['dspdbo']->setDate( $this->DB->format_datetime( time() ) );

    // Prepare contact info
    $contacts['admin']['name'] = $this->session['accountdbo']->getContactName();
    $contacts['admin']['company'] = $this->session['accountdbo']->getBusinessName();
    $contacts['admin']['email'] = $this->session['accountdbo']->getContactEmail();
    $contacts['admin']['address1'] = $this->session['accountdbo']->getAddress1();
    $contacts['admin']['address2'] = $this->session['accountdbo']->getAddress2();
    $contacts['admin']['address3'] = "";
    $contacts['admin']['city'] = $this->session['accountdbo']->getCity();
    $contacts['admin']['state'] = $this->session['accountdbo']->getState();
    $contacts['admin']['country'] = $this->session['accountdbo']->getCountry();
    $contacts['admin']['zip'] = $this->session['accountdbo']->getPostalCode();
    $contacts['admin']['phone'] = $this->session['accountdbo']->getPhone();
    $contacts['admin']['fax'] = $this->session['accountdbo']->getFax();
    $contacts['tech'] = $contacts['admin'];
    $contacts['billing'] = $contacts['admin'];

    // Execute the registration at the Registrar
    if( !$this->rcModule->registerDomain( $this->session['dspdbo']->getFullDomainName(),
					  $this->session['dspdbo']->getTermInt(),
					  $contacts,
					  $this->session['customer'] ) )
      {
	$this->setError( array( "type" => "DOMAIN_REGISTER_FAILED_REGISTRAR" ) );
	$this->cancel();
      }

    // Store the purchase in database
    if( !add_DomainServicePurchaseDBO( $this->session['dspdbo'] ) )
      {
	$this->setError( array( "type" => "DOMAIN_REGISTER_FAILED_DB" ) );
	$this->cancel();
      }

    // Registration complete
    $this->setMessage( array( "type" => "DOMAIN_REGISTERED",
			      "args" => array( $this->session['dspdbo']->getFullDomainName() ) ) );
    $this->goto( "domains_browse", null, null );
  }

  /**
   * Initialize the Page
   */
  function init()
  {
    if( isset( $_SESSION['dspdbo'] ) )
      {
	// Move the Domain Service Purchase (passed from the Register Domain page) 
	// to the local session
	$this->session['dspdbo'] = $_SESSION['dspdbo'];
	unset( $_SESSION['dspdbo'] );
      }

    if( !isset( $this->session['dspdbo'] ) )
      {
	fatal_error( "RCMRegisterDomainPage::init()",
		     "No Domain Service Purchase found!" );
      }

    $this->rcModule = $this->conf['modules']['resellerclub'];
    $this->rcModule->checkEnabled();
  }

  /**
   * Populate the Reseller Club Customer Drop-down
   *
   * @return array Username => 'Custer Name (Username)'
   */
  function populateCustomerField()
  {
    // Get customer list from Reseller Club
    $customers_raw = $this->rcModule->getCustomers();

    // Customer data must be returned as a customer username => customer name hash
    $customers = array();
    foreach( $customers_raw as $key => $data )
      {
	if( is_numeric( $key ) )
	  {
	    // This item is a customer
	    $customers[$data['customer.username']] = 
	      $data['customer.name'] . 
	      " (" . $data['customer.username'] . ")";
	  }
      }
    
    return $customers;
  }

  /**
   * Process New Domain
   */
  function processNewDomain()
  {
    // A customer selected from the drop-down takes precedence over a value in
    // the username box
    if( isset( $this->session['rcm_customer']['customer'] ) )
      {
	$rcCustomer = $this->session['rcm_customer']['customer'];
      }
    elseif( isset( $this->session['rcm_customer']['username'] ) )
      {
	$rcCustomer = $this->session['rcm_customer']['username'];
      }
    elseif( isset( $this->session['rcm_new_customer']['username'] ) )
      {
	$rcCustomer = $this->session['rcm_new_customer']['username'];
      }
    else
      {
	fatal_error( "RCMRegisterDomainPage::processNewDomain()",
		     "No Reseller Club customer was provided!" );
      }

    $this->session['customer'] = $rcCustomer;

    // Display confirmation
    $this->session['accountdbo'] = 
      load_AccountDBO( $this->session['dspdbo']->getAccountID() );
    $this->smarty->assign( "registrar_username", $rcCustomer );
    $this->smarty->assign( "nameservers", $this->conf['dns']['nameservers'] );
    $this->setTemplate( "confirm" );
  }
}
?>
