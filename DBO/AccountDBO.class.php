<?php
/**
 * AccountDBO.class.php
 *
 * This file contains the definition of the AccountDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once BASE_PATH . "solidworks/DBO.class.php";

require_once BASE_PATH . "DBO/HostingServicePurchaseDBO.class.php";
require_once BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";
require_once BASE_PATH . "DBO/ProductPurchaseDBO.class.php";
require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * AccountDBO
 *
 * Represents a customer Account.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AccountDBO extends DBO
{
  /**
   * @var integer Account ID
   */
  var $id;

  /**
   * @var string Account Type (Business Account/Individual Account)
   */
  var $type;

  /**
   * @var string Account Status (Active/Inactive/Pending)
   */
  var $status;

  /**
   * @var string Billing Status (Bill/Do Not Bill)
   */
  var $billingstatus;

  /**
   * @var integer Billing Day (of the month)
   */
  var $billingday;

  /**
   * @var string Business Name (if type = "Business Account")
   */
  var $businessname;

  /**
   * @var string Contact's Name
   */
  var $contactname;

  /**
   * @var string Contact's Email address
   */
  var $contactemail;

  /**
   * @var string Contact's Address line 1
   */
  var $address1;

  /**
   * @var string Contact's Address line 2
   */
  var $address2;

  /**
   * @var string Contact's City
   */
  var $city;

  /**
   * @var string Contact's State
   */
  var $state;

  /**
   * @var string Contact's 2-digit Country code
   */
  var $country;

  /**
   * @var string Contact's Zip / Postal code
   */
  var $postalcode;

  /**
   * @var string Contact's Phone
   */
  var $phone;

  /**
   * @var string Contact's Mobile phone
   */
  var $mobilephone;

  /**
   * @var string Contact's Fax
   */
  var $fax;

  /**
   * Set Account ID
   *
   * @param integer $id New Account ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Account ID
   *
   * return integer Account ID
   */
  function getID() { return $this->id; }

  /**
   * Set Account Type
   *
   * @param string $type New Account Type
   */
  function setType( $type ) 
  { 
    if( !( $type == "Individual Account" || $type == "Business Account" ) )
      {
	// Bad value
	fatal_error( "AccountDBO::setType()", "bad value supplied for setType: " . $type );
      }
    $this->type = $type; 
  }

  /**
   * Get Account Type
   *
   * @param string Account Type
   */
  function getType() { return $this->type; }

  /**
   * Set Account Status
   *
   * @param string $status New Account Status
   */
  function setStatus( $status )
  {
    if( !( $status == "Active" || $status == "Inactive" || $status == "Pending" ) )
      {
	// Bad value
	fatal_error( "AccountDBO::setStatus()", 
		     "bad value supplied for setStatus: " . $status );
      }
    $this->status = $status;
  }

  /**
   * Get Account Status
   *
   * @return string Account Status
   */
  function getStatus() { return $this->status; }

  /**
   * Set Billing Status
   *
   * @param string $status New Billing Status
   */
  function setBillingStatus( $status )
  {
    if( !( $status == "Bill" || $status == "Do Not Bill" ) )
      {
	// Bad value
	fatal_error( "AccountDBO::BillingStatus()", 
		     "bad value supplied for setStatus: " . $status );
      }
    $this->billingstatus = $status;
  }

  /**
   * Get Billing Status
   *
   * @return string Billing Status
   */
  function getBillingStatus() { return $this->billingstatus; }

  /**
   * Set Billing Day
   *
   * @param integer $day Billing Day (of the month)
   */
  function setBillingDay( $day ) { $this->billingday = $day; }

  /**
   * Get Billing Day
   *
   * @return integer Billing Day (of the month)
   */
  function getBillingDay() { return $this->billingday; }

  /**
   * Set Business Name
   *
   * @param string $name New Business Name
   */
  function setBusinessName( $name ) { $this->businessname = $name; }

  /**
   * Get Business Name
   *
   * return string Business Name
   */
  function getBusinessName() { return $this->businessname; }

  /**
   * Set Contact's Name
   *
   * @param string $name New Contact Name
   */
  function setContactName( $name ) { $this->contactname = $name; }

  /**
   * Get Contact's Name
   *
   * @return string Contact's name
   */
  function getContactName() { return $this->contactname; }

  /**
   * Set Contact's Email Address
   *
   * @param string $email New contact email address
   */
  function setContactEmail( $email ) { $this->contactemail = $email; }

  /**
   * Get Contact's Email Address
   *
   * @return string Contact's email address
   */
  function getContactEmail() { return $this->contactemail; }

  /**
   * Set Contact's Address (line 1)
   *
   * @param string $address Contact's first address line
   */
  function setAddress1( $address ) { $this->address1 = $address; }

  /**
   * Get Contact's Address (line 1)
   *
   * return string Contact's first address line
   */
  function getAddress1() { return $this->address1; }

  /**
   * Set Contact's Address (line 2)
   *
   * @param string $address Contact's address line 2
   */
  function setAddress2( $address ) { $this->address2 = $address; }

  /**
   * Get Contac'ts Address (line 2)
   *
   * return string Contact's address line 2
   */
  function getAddress2() { return $this->address2; }

  /**
   * Set Contact's City
   *
   * @param string $city Contact's city
   */
  function setCity( $city ) { $this->city = $city; }

  /**
   * Get Contact's City
   *
   * return $string Contact's City
   */
  function getCity() { return $this->city; }

  /**
   * Set Contact's State
   *
   * @param string $state Contact's State
   */
  function setState( $state ) { $this->state = $state; }

  /**
   * Get Contact's State
   *
   * @return string Contact's State
   */
  function getState() { return $this->state; }

  /**
   * Set Contact's Country
   *
   * @param string $country Contact's country code
   */
  function setCountry( $country ) { $this->country = $country; }

  /**
   * Get Contact's Country
   *
   * @return string Contac'ts 2-digit country code
   */
  function getCountry() { return $this->country; }

  /**
   * Set Contact's Postal Code
   *
   * @param string $zip Contact's postal code
   */
  function setPostalCode( $zip ) { $this->postalcode = $zip; }

  /**
   * Get Contact's Postal Code
   *
   * @return string Contac'ts postal code
   */
  function getPostalCode() { return $this->postalcode; }

  /**
   * Set Contact's Phone Number
   *
   * @param string $phone Contact's phone number
   */
  function setPhone( $phone ) { $this->phone = $phone; }

  /**
   * Get Contact's Phone Number
   *
   * @return string Contact's phone number
   */
  function getPhone() { return $this->phone; }

  /**
   * Set Contact's Mobile Phone Number
   *
   * @param string $phone Contact's mobile phone number
   */
  function setMobilePhone( $phone ) { $this->mobilephone = $phone; }

  /**
   * Get Contact's Mobile Phone Number
   *
   * @return string Contact's mobile phone number
   */
  function getMobilePhone() { return $this->mobilephone; }

  /**
   * Set Contact's Fax Number
   *
   * @param string $fax Contact's fax number
   */
  function setFax( $fax ) { $this->fax = $fax; }

  /**
   * Get Contact's Fax Number
   *
   * @return string Contact's fax number
   */
  function getFax() { return $this->fax; }

  /**
   * Get Account Balance
   *
   * @return double Account balance
   */
  function getBalance() 
  { 
    // Sum up invoice balances
    $balance = 0;
    if( ($invoices = load_array_InvoiceDBO( "accountid=" . $this->getID() )) != null )
      {
	foreach( $invoices as $invoice_dbo )
	  {
	    $balance += $invoice_dbo->getBalance();
	  }
      }
    return $balance;
  }

  /**
   * Get Account Name
   *
   * If the Account Type is set to "Individual Account" this function
   * will return the Contact Name.  Alternately, for a "Business Account", this
   * function will return the "Business Name".
   *
   * @return string Account Name
   */
  function getAccountName()
  {
    if( $this->getType() == "Individual Account" )
      {
	return $this->getContactName();
      }

    return $this->getBusinessName();
  }

  /**
   * Get Hosting Service Purchases for this Account
   *
   * return array Array of HostingServicePurchaseDBO's for this account
   */
  function getHostingServices()
  {
    return load_array_HostingServicePurchaseDBO( "accountid=" . intval( $this->getID() ) );
  }

  /**
   * Get Domain Service Purchases for this Account
   *
   * return array Array of DomainServicePurchaseDBO's for this account
   */
  function getDomainServices()
  {
    return load_array_DomainServicePurchaseDBO( "accountid=" . intval( $this->getID() ) );
  }

  /**
   * Get Product Purchases for this Account
   *
   * return array Array of ProductPurchaseDBO's for this account
   */
  function getProducts()
  {
    return load_array_ProductPurchaseDBO( "accountid=" . intval( $this->getID() ) );
  }

  /**
   * Get All Purchases for this Account
   *
   * return array Arroy of PurchaseDBO's for this account
   */
  function getPurchases()
  {
    $hosting = $this->getHostingServices();
    $domain = $this->getDomainServices();
    $product = $this->getProducts();
    return array_merge( array(), 
			$hosting == null ? array() : $hosting,
			$domain == null ? array() : $domain,
			$product == null ? array() : $product );
  }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setType( $data['type'] );
    $this->setStatus( $data['status'] );
    $this->setBillingStatus( $data['billingstatus'] );
    $this->setBillingDay( $data['billingday'] );
    $this->setBusinessName( $data['businessname'] );
    $this->setContactName( $data['contactname'] );
    $this->setContactEmail( $data['contactemail'] );
    $this->setAddress1( $data['address1'] );
    $this->setAddress2( $data['address2'] );
    $this->setCity( $data['city'] );
    $this->setState( $data['state'] );
    $this->setCountry( $data['country'] );
    $this->setPostalCode( $data['postalcode'] );
    $this->setPhone( $data['phone'] );
    $this->setMobilePhone( $data['mobilephone'] );
    $this->setFax( $data['fax'] );
  }
}

/**
 * Insert AccountDBO into database
 *
 * @param AccountDBO &$dbo AccountDBO to add
 * @return boolean True on success
 */
function add_AccountDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "account",
				array( "type" => $dbo->getType(),
				       "status" => $dbo->getStatus(),
				       "billingstatus" => $dbo->getBillingStatus(),
				       "billingday" => $dbo->getBillingDay(),
				       "businessname" => $dbo->getBusinessName(),
				       "contactname" => $dbo->getContactName(),
				       "contactemail" => $dbo->getContactEmail(),
				       "address1" => $dbo->getAddress1(),
				       "address2" => $dbo->getAddress2(),
				       "city" => $dbo->getCity(),
				       "state" => $dbo->getState(),
				       "country" => $dbo->getCountry(),
				       "postalcode" => $dbo->getPostalCode(),
				       "phone" => $dbo->getPhone(),
				       "mobilephone" => $dbo->getMobilePhone(),
				       "fax" => $dbo->getFax() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      return false;
    }

  // Get auto-increment ID
  $id = mysql_insert_id( $DB->handle() );

  // Validate ID
  if( $id == false )
    {
      // DB error
      fatal_error( "add_AccountDBO()", 
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_AccountDBO()", "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update AccountDBO in database
 *
 * @param AccountDBO &$dbo Account DBO to update
 * @return boolean True on success
 */
function update_AccountDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "account",
				"id = " . intval( $dbo->getID() ),
				array( "type" => $dbo->getType(),
				       "status" => $dbo->getStatus(),
				       "billingstatus" => $dbo->getBillingStatus(),
				       "billingday" => $dbo->getBillingDay(),
				       "businessname" => $dbo->getBusinessName(),
				       "contactname" => $dbo->getContactName(),
				       "contactemail" => $dbo->getContactEmail(),
				       "address1" => $dbo->getAddress1(),
				       "address2" => $dbo->getAddress2(),
				       "city" => $dbo->getCity(),
				       "state" => $dbo->getState(),
				       "country" => $dbo->getCountry(),
				       "postalcode" => $dbo->getPostalCode(),
				       "phone" => $dbo->getPhone(),
				       "mobilephone" => $dbo->getMobilePhone(),
				       "fax" => $dbo->getFax() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete AccountDBO from database
 *
 * @param AccountDBO &$dbo Account DBO to delete
 * @return boolean True on success
 */
function delete_AccountDBO( &$dbo )
{
  global $DB;

  $id = intval( $dbo->getID() );

  // Delete any HostingSericePurchases assigned to this account
  $hosting_array = load_array_HostingServicePurchaseDBO( "accountid=" . $id );
  if( isset( $hosting_array ) )
    {
      foreach( $hosting_array as $hosting_dbo )
	{
	  if( !delete_HostingServicePurchaseDBO( $hosting_dbo ) )
	    {
	      fatal_error( "delete_AccountDBO()", 
			   "error, could not delete HostingServicePurchase" );
	    }
	}
    }

  // Delete any DomainSericePurchases assigned to this account
  $domain_array = load_array_DomainServicePurchaseDBO( "accountid=" . $id );
  if( isset( $domain_array ) )
    {
      foreach( $domain_array as $domain_dbo )
	{
	  if( !delete_DomainServicePurchaseDBO( $domain_dbo ) )
	    {
	      fatal_error( "delete_AccountDBO", 
			   "error, could not delete DomainServicePurchase" );
	    }
	}
    }

  // Delete any ProductPurchases assigned to this account
  $product_array = load_array_ProductPurchaseDBO( "accountid=" . $id );
  if( isset( $product_array ) )
    {
      foreach( $product_array as $product_dbo )
	{
	  if( !delete_ProductPurchaseDBO( $product_dbo ) )
	    {
	      fatal_error( "delete_AccountDBO", 
			   "error, could not delete ProductPurchase" );
	    }
	}
    }

  // Delete any Invoices assigned to this account
  $invoice_array = load_array_InvoiceDBO( "accountid=" . $id );
  if( isset( $invoice_array ) )
    {
      foreach( $invoice_array as $invoice_dbo )
	{
	  if( !delete_InvoiceDBO( $invoice_dbo ) )
	    {
	      fatal_error( "AccountDBO.class.php", "Could not delete Invoice" );
	    }
	}
    }

  // Build SQL
  $sql = $DB->build_delete_sql( "account",
				"id = " . $id );
  // Delete the AccountDBO
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load an AccountDBO from the database
 *
 * @param integer $id ID of Account DBO to retrieve
 * @return AccountDBO Account DBO, null if not found
 */
function load_AccountDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "account",
				"*",
				"id = " . intval( $id ),
				null,
				null,
				null,
				null );

  // Run query
  if( !($result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatal_error( "load_AccountDBO()", "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }
  
  // Load a new AccountDBO
  $dbo = new AccountDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new AccountDBO
  return $dbo;
}

/**
 * Load multiple Account DBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param integer $limit Limit the number of results
 * @param integer $start Record number to start the results at
 * @return array Array of AccountDBO's
 */
function &load_array_AccountDBO( $filter = null,
				 $sortby = null,
				 $sortdir = null,
				 $limit = null,
				 $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "account",
				"*",
				$filter,
				$sortby,
				$sortdir,
				$limit,
				$start );

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatal_error( "load_array_AccountDBO", "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Build an array of DBOs from the result set
  $dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DBO with the data from the DB
      $dbo =& new AccountDBO();
      $dbo->load( $data );

      // Add DomainServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Same as load_array_AccountDBO, except this function just COUNTs the number
 * of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param integer $limit Limit the number of results
 * @param integer $start Record number to start the results at
 * @return integer Number of AccountDBOs in database matching the criteria
 */
function count_all_AccountDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "account",
				"COUNT(*)",
				$filter,
				null,
				null,
				null,
				null );

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "AccountDBO.class.php", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_AccountDBO()", 
		   "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>