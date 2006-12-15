<?php
/**
 * ResellerClub.class.php
 *
 * This file contains the definition of the ResellerClub class.
 *
 * @package resellerclub
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "modules/RegistrarModule.class.php";

/**
 * ResellerClub
 *
 * Provides a wrapper for the Reseller Club API library.
 *
 * @package resellerclub
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ResellerClub extends RegistrarModule
{
  /**
   * @var string Configuration page
   */
  var $configPage = "rcm_config";

  /**
   * @var Customer Reseller Club API Customer object
   */
  var $customer = null;

  /**
   * @var boolean Debug flag
   */
  var $debug = false;

  /**
   * @var string Default customer password
   */
  var $defaultCustomerPassword = "defaultpw";

  /**
   * @var DomContact Reseller Club API Domain Contact object
   */
  var $domContact = null;

  /**
   * @var DomOrder Reseller Club API Order object
   */
  var $domOrder = null;

  /**
   * @var string Module name
   */
  var $name = "resellerclub";

  /**
   * @var string Reseller Club language preference
   */
  var $langpref = "en";

  /**
   * @var string Long description
   */
  var $description = "Reseller Club Domain Registrar Module";

  /**
   * @var integer Parent ID
   */
  var $parentID = 999999998;

  /**
   * @var string Reseller Club password
   */
  var $password = "password";

  /**
   * @var integer Reseller ID
   */
  var $resellerID = 1;

  /**
   * @var string Reseller Club Role
   */
  var $role = "reseller";

  /**
   * @var string Short Description
   */
  var $sDescription = "Reseller Club";

  /**
   * @var string Service URL
   */
  var $serviceURL = "http://demo.myorderbox.com/anacreon/servlet/rpcrouter";

  /**
   * @var string Reseller Club Username
   */
  var $username = "user@email.com";

  /**
   * @var integer Version
   */
  var $version = 1;

  /**
   * Add a Customer
   *
   * Create a new customer at Reseller Club
   *
   * @param string $username Directi Username (an email address)
   * @param string $password Password
   * @param string $name Customer's name
   * @param string $company Customer's company
   * @param string $address1 Address line 1
   * @param string $address2 Address line 2
   * @param string $address3 Address line 3
   * @param string $city City
   * @param string $state State
   * @param string $contry Contry code
   * @param string $zip Postal code
   * @param string $telephone1 Customer's telephone (1-xxxxxxxxxx format)
   * @param string $telephone2 Customer's mobile phone (1-xxxxxxxxxx format)
   * @param string $fax Customer's fax number (1-xxxxxxxxxx format)
   * @return integer Customer ID
   */
  function addCustomer( $username,
			$password,
			$name,
			$company,
			$address1,
			$address2,
			$address3,
			$city,
			$state,
			$country,
			$zip,
			$telephone1,
			$telephone2,
			$fax )
  {
    // Massage the data as needed
    if( empty( $company ) )
      {
	// Company can not be null
	$company = $name;
      }

    // Add a customer at Directi
    $telephone1 = $this->parse_phone_number( $telephone1 );
    $telephone2 = $this->parse_phone_number( $telephone2 );
    $result = $this->customer->addCustomer( $this->getUsername(),
					    $this->getPassword(),
					    $this->getRole(),
					    $this->getLangPref(),
					    $this->getParentID(),
					    $username,
					    $password,
					    $name,
					    $company,
					    $address1,
					    $address2,
					    $address3,
					    $city,
					    $state,
					    $country,
					    $zip,
					    $telephone1['cc'],
					    $telephone1['number'],
					    $telephone2['cc'],
					    $telephone2['number'],
					    "",
					    "",
					    "en" );
    
    if( !is_numeric( $result ) )
      {
	// Error when adding customer
	return false;
      }

    // Customer added
    return true;
  }
  
  /**
   * Add or Edit a Reseller Club Contact Record
   *
   * Add a new contact record at Reseller Club, or if it already exists, update it.
   *
   * @param integer $customer_id The customer who this contact belongs to
   * @param ContactDBO $contactDBO Contact DBO
   * @return integer Directi Contact ID
   */
  function addOrEditContact( $customerID, $contactDBO )
  {
    if( empty( $contactDBO->getBusinessName ) )
      {
	// If no company is provided, set company field to contact name
	$contactDBO->setBusinessName( $contactDBO->getName() );
      }

    // Find out if this contact already exists
    $contactID = -1;
    $contacts = $this->domContact->listNames( $this->getUsername(),
					      $this->getPassword(),
					      $this->getRole(),
					      $this->getLangPref(),
					      $this->getParentID(),
					      $customerID );
    if( $contacts != null )
      {
	foreach( $contacts as $key => $data )
	  {
	    if( is_numeric( $key ) )
	      {
		if( $data['company'] == $contactDBO->getBusinessName() && 
		    $data['name'] == $contactDBO->getName() )
		  {
		    // Contact already exists
		    $contactID = $data['contactid'];
		    break;
		  }
	      }
	  }
      }

    if( $contactID > 0 )
      {
	// Update contact
	$phone = $this->parse_phone_number( $contactDBO->getPhone() );
	$fax = $this->parse_phone_number( $contactDBO->getFax() );
	$result = $this->domContact->mod( $this->getUsername(),
					  $this->getPassword(),
					  $this->getRole(),
					  $this->getLangPref(),
					  $this->getParentID(),
					  $contactID,
					  $contactDBO->getName(),
					  $contactDBO->getBusinessName(),
					  $contactDBO->getEmail(),
					  $contactDBO->getAddress1(),
					  $contactDBO->getAddress2(),
					  $contactDBO->getAddress3(),
					  $contactDBO->getCity(),
					  $contactDBO->getState(),
					  $contactDBO->getCountry(),
					  $contactDBO->getPostalCode(),
					  $phone['cc'],
					  $phone['number'],
					  $fax['cc'],
					  $fax['number'] );
	if( $result['status'] != "Success" )
	  {
	    print_r( $result );
	    fatal_error( "ResellerClub::addOrEditContact()", 
			 "could not modify contact for domain registration at Reseller Club!" );
	  }
      }
    else
      {
	// Add contact
	$phone = $this->parse_phone_number( $contactDBO->getPhone() );
	$fax = $this->parse_phone_number( $contactDBO->getFax() );
	$contact_id = 
	  $this->domContact->addContact( $this->getUsername(),
					 $this->getPassword(),
					 $this->getRole(),
					 $this->getLangPref(),
					 $this->getParentID(),
					 $contactDBO->getName(),
					 $contactDBO->getBusinessName(),
					 $contactDBO->getEmail(),
					 $contactDBO->getAddress1(),
					 $contactDBO->getAddress2(),
					 $contactDBO->getAddress3(),
					 $contactDBO->getCity(),
					 $contactDBO->getState(),
					 $contactDBO->getCountry(),
					 $contactDBO->getPostalCode(),
					 $phone['cc'],
					 $phone['number'],
					 $fax['cc'],
					 $fax['number'],
					 $customerID );
	if( !is_numeric( $contactID ) )
	  {
	    fatal_error( "RegistrarDirecti::add_edit_contact()", 
			 "could not add contact for domain registration at Directi!" );
	  }
      }

    return $contactID;
  }

  /**
   * Check Domain Availability
   *
   * @return boolean True if the domain is available to be registered
   */
  function checkAvailability( $fqdn )
  {
    $this->checkEnabled();

    // Check domain name availability
    $result = $this->domOrder->checkAvailability( $this->getUsername(),
						  $this->getPassword(),
						  $this->getRole(),
						  $this->getLangPref(),
						  $this->getParentID(),
						  $fqdn,
						  false );

    if( !isset( $result[$fqdn] ) )
      {
	throw new RegistrarException( "[RESELLER_CLUB_NO_DATA_RETURNED]." );
      }

    return $result[$fqdn]['status'] == "available";
  }

  /**
   * Get Debug Flag
   *
   * @return boolean Debug flag
   */
  function getDebug() { return $this->debug; }

  /**
   * Get Default Customer Password
   *
   * @return string Default customer password
   */
  function getDefaultCustomerPassword() { return $this->defaultCustomerPassword; }

  /**
   * Get Language Preference
   *
   * @return string Language preference
   */
  function getLangPref() { return $this->langpref; }

  /**
   * Get Parent ID
   *
   * @return integer Parent ID
   */
  function getParentID() { return $this->parentID; }

  /**
   * Get Password
   *
   * @return string Password
   */
  function getPassword() { return $this->password; }

  /**
   * Get Reseller ID
   *
   * @return integer Reseller ID
   */
  function getResellerID() { return $this->resellerID; }

  /**
   * Get Role
   *
   * @return string Role
   */
  function getRole() { return $this->role; }

  /**
   * Get Service URL
   *
   * @return string Service URL
   */
  function getServiceURL() { return $this->serviceURL; }

  /**
   * Get Username
   *
   * @return string Username
   */
  function getUsername() { return $this->username; }

  /**
   * Initialize Reseller Club Module
   *
   * Invoked when the module is loaded.  Call the parent method first, then
   * load settings.
   */
  function init()
  {
    parent::init();

    // Load settings
    $this->setDebug( $this->moduleDBO->loadSetting( "debug" ) );
    $this->setLangPref( $this->moduleDBO->loadSetting( "langpref" ) );
    $this->setParentID( $this->moduleDBO->loadSetting( "parentid" ) );
    $this->setUsername( $this->moduleDBO->loadSetting( "username" ) );
    $this->setPassword( $this->moduleDBO->loadSetting( "password" ) );
    $this->setResellerID( $this->moduleDBO->loadSetting( "resellerid" ) );
    $this->setRole( $this->moduleDBO->loadSetting( "role" ) );
    $this->setServiceURL( $this->moduleDBO->loadSetting( "serviceurl" ) );
	
    if( $this->isEnabled() )
      {
	// Reseller Club API
	require BASE_PATH . "modules/resellerclub/lib/domorder.class.php";
	require BASE_PATH . "modules/resellerclub/lib/customer.class.php";
	require BASE_PATH . "modules/resellerclub/lib/domcontact.class.php";

	// Create Reseller Club objects
	$this->domOrder = 
	  new DomOrder( BASE_PATH . "modules/resellerclub/lib/wsdl/domain.wsdl" );
	$this->customer = 
	  new Customer( BASE_PATH . "modules/resellerclub/lib/wsdl/customer.wsdl" );
	$this->domContact = 
	  new DomContact( BASE_PATH . "modules/resellerclub/lib/wsdl/domaincontact.wsdl" );
      }
  }

  /**
   * Install Reseller Club Module
   *
   * Invoked when the module is installed.  Calls the parent first, which does
   * most of the work, then saves the default settings to the DB.
   */
  function install()
  {
    parent::install();
    $this->saveSettings();
  }

  /**
   * Verify Domain is Transfer Eligible
   *
   * @param string $fqdn Domain name
   * @return boolean True if the domain is transfer eligible
   */
  function isTransferable( $fqdn )
  {
    $this->checkEnabled();

    // Check domain name availability
    $result = $this->domOrder->checkAvailability( $this->getUsername(),
						  $this->getPassword(),
						  $this->getRole(),
						  $this->getLangPref(),
						  $this->getParentID(),
						  $fqdn,
						  false );

    if( !isset( $result[$fqdn] ) )
      {
	throw new RegistrarException( "[RESELLER_CLUB_NO_DATA_RETURNED]." );
      }

    // Transferable rules:
    //  * The domain must not be available
    //  * The domain must not be registered through us
    return !($result[$fqdn]['status'] == "available" ||
	     $result[$fqdn]['status'] == "regthroughus");
  }

  /**
   * Parse Phone Number
   *
   * Parse a SolidWorks phone number for use with Reseller Club
   *
   * @param string $phoneNumber A solidstate phone number (+x-xxxxxxxxxx)
   * @return array Phone number components ('CC' and 'number')
   */
  protected function parse_phone_number( $phoneNumber )
  {
    $components = explode( "-", $phoneNumber );
    $result['cc'] = intval( $components[0] );
    $result['number'] = $components[1];

    return $result;
  }

  /**
   * Prepare Customer and Contacts
   *
   * Queries the customer ID, or creates a new customer if necessary.  Then adds
   * or edits the contacts as necessary.
   *
   * @param array $contacts An array of ContactDBO's
   * @param AccountDBO $accountDBO The account DBO
   * @return array ID's in an associative array with keys: customerid, adminid, techid, billingid
   */
  function prepareCustomerContacts( $contacts, $accountDBO )
  {
    // Reseller Club uses e-mail addresses as customer usernames
    $customer = $accountDBO->getContactEmail();

    // Query the customer's ID
    if( !( $customerID = $this->queryCustomerID( $customer ) ) )
      {
	// Add a new customer
	if( !($customerID = $this->addCustomer( $accountDBO->getContactEmail(),
						$this->getDefaultCustomerPassword(),
						$accountDBO->getContactName(),
						$accountDBO->getBusinessName(),
						$accountDBO->getAddress1(),
						$accountDBO->getAddress2(),
						null,
						$accountDBO->getCity(),
						$accountDBO->getState(),
						$accountDBO->getCountry(),
						$accountDBO->getPostalCode(),
						$accountDBO->getPhone(),
						$accountDBO->getMobilePhone(),
						$accountDBO->getFax() ) ) )
	  {
	    fatal_error( "ResellerClub::registerNewDomain()",
			 "There was an error when trying to add a new Reseller Club customer" );
	  }
      }

    // Enter Admin contact
    $adminID = $this->addOrEditContact( $customerID, $contacts['admin'] );
    if( !is_numeric( $adminID ) || $adminID < 0 )
      {
	fatal_error( "ResellerClub::registerDomain", 
		     "could not add Admin contact for domain registration at Reseller Club!" );
      }

    // Enter Technical contact
    $techID = $this->addOrEditContact( $customerID, $contacts['tech'] );
    if( !is_numeric( $techID ) || $techID < 0 )
      {
	fatal_error( "ResellerClub::registerDomain",
		     "could not add Tech contact for domain registration at Reseller Club!" );
      }

    // Enter Billing contact
    $billingID = $this->addOrEditContact( $customerID, $contacts['billing'] );
    if( !is_numeric( $billingID )  || $billingID < 0 )
      {
	fatal_error( "ResellerClub::registerDomain",
		     "could not add Billing contact for domain registration at Reseller Club!" );
      }

    return array( "customerid" => $customerID,
		  "adminid" => $adminID,
		  "techid" => $techID,
		  "billingid" => $billingID );
  }

  /**
   * Register a New Domain
   *
   * Registers a new domain name without requiring any Reseller Club specific
   * information.
   *
   * @param string $domainName Domain name to be registered (without TLD)
   * @param string $TLD Domain TLD to register
   * @param integer $term Number of years to register the domain for
   * @param array $contacts Admin, billing, and technical contact DBOs
   * @param AccountDBO $accountDBO The account that is registering this domain
   */
  function registerNewDomain( $domainName, $TLD, $term, $contacts, $accountDBO )
  {
    global $conf;

    // Make sure this module is enabled
    $this->checkEnabled();

    // Prepare customer and contacts, get IDs
    $ids = $this->prepareCustomerContacts( $contacts, $accountDBO );

    // Register Domain
    $fqdn = sprintf( "%s.%s", $domainName, $TLD );
    $results = $this->domOrder->registerDomain( $this->getUsername(),
						$this->getPassword(),
						$this->getRole(),
						$this->getLangPref(),
						$this->getParentID(),
						array( $fqdn => "{$term}" ),
						$conf['dns']['nameservers'],
						$ids['adminid'],
						$ids['adminid'],
						$ids['techid'],
						$ids['billingid'],
						$ids['customerid'],
						"NoInvoice" );

    if( $results[$fqdn]['status'] != "Success" )
      {
	// Error
	throw new RegistrarException( "[RESELLER_CLUB_FAILED_TO_REGISTER]: " . 
				      var_export( $results ) );
      }
  }

  /**
   * Renew a Domain
   *
   * @param DomainServicePurchaseDBO $purchseDBO The domain to be renewed
   * @param integer $renewTerms Number of years to renew for
   */
  function renewDomain( $purchaseDBO, $renewTerms )
  {
    $this->checkEnabled();
    $fqdn = $purchaseDBO->getFullDomainName();

    // Query the Reseller Club domain record
    if( !($domainRecord = $this->queryDomainRecord( $fqdn )) )
      {
	// Domain record not found at Reseller Club
	return false;
      }

    // Renew the domain (note: noofyears must be passed as a string)
    $request = array( $fqdn => array( "entityid" => $domainRecord['entity.entityid'],
				      "noofyears" => sprintf( "%d", $renewTerms ),
				      "expirydate" => $domainRecord['orders.endtime'] ) );
    if( !($result = $this->domOrder->renewDomain( $this->getUsername(),
						  $this->getPassword(),
						  $this->getRole(),
						  $this->getLangPref(),
						  $this->getParentID(),
						  $request,
						  "NoInvoice" ) ) )
      {
	throw new RegistrarException( "Unexpected return value from DomOrder::renewDomain()!" );
      }
    if( !$result[$fqdn]['actionstatus'] == "Success" )
      {
	// Error
	throw new RegistrarException( "[RESELLER_CLUB_FAILED_TO_RENEW]: " . 
				      $result['actionstatusdesc'] );
      }
  }

  /**
   * Query Reseller Club Customer ID
   *
   * Given the customer's username (an e-mail address), query the customer's ID
   * from Reseller Club
   *
   * @param string $username Customer's username (an e-mail address)
   * @return integer Customer ID, or null
   */
  function queryCustomerID( $username )
  {
    $result = $this->customer->listOrder( $this->getUsername(),
					  $this->getPassword(),
					  $this->getRole(),
					  $this->getLangPref(),
					  $this->getParentID(),
					  null,
					  $this->getResellerID(),
					  $username,
					  null,
					  null,
					  null,
					  null,
					  null,
					  null,
					  null,
					  null,
					  null,
					  10,
					  1,
					  null );
    
    if( $result['recsindb'] > 1 )
      {
	fatal_error( "ResellerClub::queryCustomerID()",
		     "Customer::list() returned unexpected results" );
      }

    return $result[1]["customer.customerid"];
  }

  /**
   * Query Reseller Club Domain Record
   *
   * Given a domain name, query the order record stored at Reseller Club
   *
   * @param string $fqdn Domain name
   * @return array Reseller Club's domain record
   */
  function queryDomainRecord( $fqdn )
  {
    // Query the domain
    $result = $this->domOrder->listOrder( $this->getUsername(),
					  $this->getPassword(),
					  $this->getRole(),
					  $this->getLangPref(),
					  $this->getParentID(),
					  null,
					  $this->getResellerID(),
					  null,
					  true,
					  null,
					  null,
					  null,
					  null,
					  null,
					  null,
					  null,
					  100,
					  1,
					  null );
    if( !is_array( $result ) )
      {
	fatal_error( "ResellerClub::queryDomainRecord()",
		     "Unexpected result from domOrder::listOrder()!" );
      }
					  
    // Search the list for the domain name
    foreach( $result as $key => $domainData )
      {
	if( is_array( $domainData ) && $domainData['entity.description'] == $fqdn )
	  {
	    // Domain record found
	    return $domainData;
	  }
      }

    // Could not find domain record
    return false;
  }

  /**
   * Save Reseller Club Settings
   */
  function saveSettings()
  {
    // Save default settings
    $this->moduleDBO->saveSetting( "debug", 
				   $this->getDebug() == null ? 0 : $this->getDebug() );
    $this->moduleDBO->saveSetting( "defaultcustomerpassword", $this->getDefaultCustomerPassword() );
    $this->moduleDBO->saveSetting( "langpref", $this->getLangPref() );
    $this->moduleDBO->saveSetting( "parentid", $this->getParentID() );
    $this->moduleDBO->saveSetting( "username", $this->getUsername() );
    $this->moduleDBO->saveSetting( "password", $this->getPassword() );
    $this->moduleDBO->saveSetting( "resellerid", $this->getResellerID() );
    $this->moduleDBO->saveSetting( "role", $this->getRole() );
    $this->moduleDBO->saveSetting( "serviceurl", $this->getServiceURL() );
  }

  /**
   * Set Debug Flag
   *
   * @param boolean $debug Debug flag
   */
  function setDebug( $debug ) 
  { 
    global $debugfunction;

    $this->debug = $debug; 

    // Reseller Club API Global var
    $debugfunction = ($debug == true);
  }

  /**
   * Set Default Customer Password
   *
   * @param string $password Default customer password
   */
  function setDefaultCustomerPassword( $password )
  {
    $this->defaultCustomerPassword = $password;
  }

  /**
   * Set Language Preference
   *
   * @param string $langpref Language preference
   */
  function setLangPref( $langpref ) { $this->langpref = $langpref; }

  /**
   * Set Parent ID
   *
   * @param integer $parentid Parent ID
   */
  function setParentID( $parentID ) { $this->parentID = $parentID; }

  /**
   * Set Password
   *
   * @param string $password Password
   */
  function setPassword( $password ) { $this->password = $password; }

  /**
   * Set Reseller ID
   *
   * @return integer $resellerID Reseller ID
   */
  function setResellerID( $resellerID ) { $this->resellerID = $resellerID; }

  /**
   * Set Role
   *
   * @param string $role Role
   */
  function setRole( $role ) { $this->role = $role; }

  /**
   * Set Service URL
   *
   * @param string $serviceURL Service URL
   */
  function setServiceURL( $serviceURL ) 
  { 
    global $serviceurl;

    $this->serviceURL = $serviceURL; 

    // Reseller Club API Global variable
    $serviceurl = $serviceURL;
  }

  /**
   * Set Username
   *
   * @param string $username Username
   */
  function setUsername( $username ) { $this->username = $username; }

  /**
   * Transfer a Domain
   *
   * @param string $domainName Domain name to be transferred (without TLD)
   * @param string $TLD Domain TLD
   * @param integer $term Number of years to renew domain for
   * @param string $secret The domain secret
   * @param array An associative array of ContactDBO's (admin, billing, and tech)
   * @param AccountDBO $accountDBO The account that is transferring this domain
   * @return boolean True for success
   */
  function transferDomain( $domainName, $TLD, $term, $secret, $contacts, $accountDBO )
  {
    global $conf;

    // Make sure this module is enabled
    $this->checkEnabled();

    // Prepare customer and contacts, get IDs
    $ids = $this->prepareCustomerContacts( $contacts, $accountDBO );

    // Send transfer request to Reseller Club
    $fqdn = sprintf( "%s.%s", $domainName, $TLD );
    $result = $this->domOrder->transferDomain( $this->getUsername(),
					       $this->getPassword(),
					       $this->getRole(),
					       $this->getLangPref(),
					       $this->getParentID(),
					       array( $fqdn => $secret ),
					       $ids['adminid'],
					       $ids['adminid'],
					       $ids['techid'],
					       $ids['billingid'],
					       $ids['customerid'],
					       "NoInvoice" );
    if( $result[$fqdn]['status'] != "Success" )
      {
	// Error
	throw new RegistrarException( "[RESELLER_CLUB_FAILED_TO_TRANSFER]: " . 
				      $result[$fqdn]['actionstatusdesc'] );
      }
  }
}
?>