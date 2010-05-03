<?php
/**
 * AccountDBO.class.php
 *
 * This file contains the definition of the AccountDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @author Yves Kreis <yves@hosting-skills.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @copyright Yves Kreis <yves@hosting-skills.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * AccountDBO
 *
 * Represents a customer Account.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @author Yves Kreis <yves@hosting-skills.org>
 */

require_once dirname(__FILE__).'/../solidworks/DBO.class.php';
require_once dirname(__FILE__).'/../DBO/UserDBO.class.php';

class AccountDBO extends DBO {
	/**
	 * @var integer Account ID
	 */
	var $id;

	/**
	 * @var string Account Type (Business Account/Non-Profit Account/Individual Account)
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
	 * @var string Business Name (if type = "Business Account" || type = "Non-Profit Account")
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
	 * @var UserDBO The account's primary user object
	 */
	protected $userDBO = null;

	/**
	 * Initialize Class
	 *
	 * @param integer $id New Account ID
	 */
	function AccountDBO( ) {
		$this->userDBO = new UserDBO();
	}


	/**
	 * Set Account ID
	 *
	 * @param integer $id New Account ID
	 */
	function setID( $id ) {
		$this->id = $id;
	}

	/**
	 * Get Account ID
	 *
	 * return integer Account ID
	 */
	function getID() {
		return $this->id;
	}

	/**
	 * Convert to a String
	 *
	 * @return string The account ID
	 */
	function __toString() {
		return $this->getID();
	}

	/**
	 * Set Username
	 *
	 * @param string $username User ID
	 */
	public function setUsername( $username ) {
		$this->userDBO->setusername ($username);
	}

	/**
	 * Get Username
	 *
	 * @return string Username
	 */
	public function getUsername() {
		return $this->userDBO->getUsername();
	}

	/**
	 * Get UserDBO
	 *
	 * @return UserDBO The account's primary user
	 */
	public function getUserDBO() {
		return $this->userDBO;
	}

	/**
	 * Set Account Type
	 *
	 * @param string $type New Account Type
	 */
	function setType( $type ) {
		if ( !( $type == "Individual Account" || $type == "Non-Profit Account" || $type == "Business Account" ) ) {
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
	function getType() {
		return $this->type;
	}

	/**
	 * Set Account Status
	 *
	 * @param string $status New Account Status
	 */
	function setStatus( $status ) {
		if ( !( $status == "Active" || $status == "Inactive" || $status == "Pending" ) ) {
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
	function getStatus() {
		return $this->status;
	}

	/**
	 * Set Billing Status
	 *
	 * @param string $status New Billing Status
	 */
	function setBillingStatus( $status ) {
		if ( !( $status == "Bill" || $status == "Do Not Bill" ) ) {
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
	function getBillingStatus() {
		return $this->billingstatus;
	}

	/**
	 * Set Billing Day
	 *
	 * @param integer $day Billing Day (of the month)
	 */
	function setBillingDay( $day ) {
		$this->billingday = $day;
	}

	/**
	 * Get Billing Day
	 *
	 * @return integer Billing Day (of the month)
	 */
	function getBillingDay() {
		return $this->billingday;
	}

	/**
	 * Set Business Name
	 *
	 * @param string $name New Business Name
	 */
	function setBusinessName( $name ) {
		$this->businessname = $name;
	}

	/**
	 * Get Business Name
	 *
	 * return string Business Name
	 */
	function getBusinessName() {
		return $this->businessname;
	}

	/**
	 * Set Contact's Name
	 *
	 * @param string $name New Contact Name
	 */
	function setContactName( $name ) {
		$this->contactname = $name;
	}

	/**
	 * Get Contact's Name
	 *
	 * @return string Contact's name
	 */
	function getContactName() {
		return $this->contactname;
	}

	/**
	 * Set Contact's Email Address
	 *
	 * @param string $email New contact email address
	 */
	function setContactEmail( $email ) {
		$this->contactemail = $email;
	}

	/**
	 * Get Contact's Email Address
	 *
	 * @return string Contact's email address
	 */
	function getContactEmail() {
		return $this->contactemail;
	}

	/**
	 * Set Contact's Address (line 1)
	 *
	 * @param string $address Contact's first address line
	 */
	function setAddress1( $address ) {
		$this->address1 = $address;
	}

	/**
	 * Get Contact's Address (line 1)
	 *
	 * return string Contact's first address line
	 */
	function getAddress1() {
		return $this->address1;
	}

	/**
	 * Set Contact's Address (line 2)
	 *
	 * @param string $address Contact's address line 2
	 */
	function setAddress2( $address ) {
		$this->address2 = $address;
	}

	/**
	 * Get Contac'ts Address (line 2)
	 *
	 * return string Contact's address line 2
	 */
	function getAddress2() {
		return $this->address2;
	}

	/**
	 * Set Contact's City
	 *
	 * @param string $city Contact's city
	 */
	function setCity( $city ) {
		$this->city = $city;
	}

	/**
	 * Get Contact's City
	 *
	 * return $string Contact's City
	 */
	function getCity() {
		return $this->city;
	}

	/**
	 * Set Contact's State
	 *
	 * @param string $state Contact's State
	 */
	function setState( $state ) {
		$this->state = $state;
	}

	/**
	 * Get Contact's State
	 *
	 * @return string Contact's State
	 */
	function getState() {
		return $this->state;
	}

	/**
	 * Set Contact's Country
	 *
	 * @param string $country Contact's country code
	 */
	function setCountry( $country ) {
		$this->country = $country;
	}

	/**
	 * Get Contact's Country
	 *
	 * @return string Contac'ts 2-digit country code
	 */
	function getCountry() {
		return $this->country;
	}

	/**
	 * Set Contact's Postal Code
	 *
	 * @param string $zip Contact's postal code
	 */
	function setPostalCode( $zip ) {
		$this->postalcode = $zip;
	}

	/**
	 * Get Contact's Postal Code
	 *
	 * @return string Contac'ts postal code
	 */
	function getPostalCode() {
		return $this->postalcode;
	}

	/**
	 * Set Contact's Phone Number
	 *
	 * @param string $phone Contact's phone number
	 */
	function setPhone( $phone ) {
		$this->phone = $phone;
	}

	/**
	 * Get Contact's Phone Number
	 *
	 * @return string Contact's phone number
	 */
	function getPhone() {
		return $this->phone;
	}

	/**
	 * Set Contact's Mobile Phone Number
	 *
	 * @param string $phone Contact's mobile phone number
	 */
	function setMobilePhone( $phone ) {
		$this->mobilephone = $phone;
	}

	/**
	 * Get Contact's Mobile Phone Number
	 *
	 * @return string Contact's mobile phone number
	 */
	function getMobilePhone() {
		return $this->mobilephone;
	}

	/**
	 * Set Contact's Fax Number
	 *
	 * @param string $fax Contact's fax number
	 */
	function setFax( $fax ) {
		$this->fax = $fax;
	}

	/**
	 * Get Contact's Fax Number
	 *
	 * @return string Contact's fax number
	 */
	function getFax() {
		return $this->fax;
	}

	/**
	 * Get Account Balance
	 *
	 * @return double Account balance
	 */
	function getBalance() {
		// Sum up invoice balances
		$balance = 0;
		try {
			$invoices = load_array_InvoiceDBO( "accountid=" . $this->getID() );
			foreach( $invoices as $invoice_dbo ) {
				$balance += $invoice_dbo->getBalance();
			}
		}
		catch( DBNoRowsFoundException $e ) {

		}
		return $balance;
	}

	/**
	 * Get Account Name
	 *
	 * If the Account Type is set to "Individual Account" this function
	 * will return the Contact Name.  Alternately, for a "Business Account" or a
	 * "Non-Profit Account", this function will return the "Business Name".
	 *
	 * @return string Account Name
	 */
	function getAccountName() {
		if ( $this->getType() == "Individual Account" ) {
			return $this->getContactName();
		}

		return $this->getBusinessName();
	}

	/**
	 * Get Hosting Service Purchases for this Account
	 *
	 * return array Array of HostingServicePurchaseDBO's for this account
	 */
	function getHostingServices() {
		try {
			return load_array_HostingServicePurchaseDBO( "accountid=" . intval( $this->getID() ) );
		}
		catch( DBNoRowsFoundException $e ) {
			return array();
		}
	}

	/**
	 * Get Domain Service Purchases for this Account
	 *
	 * return array Array of DomainServicePurchaseDBO's for this account
	 */
	function getDomainServices() {
		try {
			return load_array_DomainServicePurchaseDBO( "accountid=" . intval( $this->getID() ) );
		}
		catch( DBNoRowsFoundException $e ) {
			return array();
		}
	}

	/**
	 * Get Product Purchases for this Account
	 *
	 * return array Array of ProductPurchaseDBO's for this account
	 */
	function getProducts() {
		try {
			return load_array_ProductPurchaseDBO( "accountid=" . intval( $this->getID() ) );
		}
		catch( DBNoRowsFoundException $e ) {
			return array();
		}
	}

	/**
	 * Get All Purchases for this Account
	 *
	 * return array Arroy of PurchaseDBO's for this account
	 */
	public function getPurchases() {
		$hosting = $this->getHostingServices();
		$domain = $this->getDomainServices();
		$product = $this->getProducts();
		return array_merge( array(),
				$hosting == null ? array() : $hosting,
				$domain == null ? array() : $domain,
				$product == null ? array() : $product );
	}
}

/**
 * Insert AccountDBO into database
 *
 * @param AccountDBO &$dbo AccountDBO to add
 */
function add_AccountDBO( &$dbo ) {
	$DB = DBConnection::getDBConnection();

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
			"fax" => $dbo->getFax(),
			"username" => $dbo->getUsername() ) );

	// Run query
	if ( !mysql_query( $sql, $DB->handle() ) ) {
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	// Get auto-increment ID
	$id = mysql_insert_id( $DB->handle() );

	// Validate ID
	if ( $id === false ) {
		// DB error
		throw new DBException( "Could not retrieve ID from previous INSERT!" );
	}
	if ( $id == 0 ) {
		// No ID?
		throw new DBException( "Previous INSERT did not generate an ID" );
	}

	// Store ID in DBO
	$dbo->setID( $id );
}

/**
 * Update AccountDBO in database
 *
 * @param AccountDBO &$dbo Account DBO to update
 * @return boolean True on success
 */
function update_AccountDBO( &$dbo ) {
	$DB = DBConnection::getDBConnection();

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
			"fax" => $dbo->getFax(),
			"username" => $dbo->getUsername() ) );

	// Run query
	if ( !mysql_query( $sql, $DB->handle() ) ) {
		throw new DBException( mysql_error( $DB->handle() ) );
	}
}

/**
 * Delete AccountDBO from database
 *
 * @param AccountDBO &$dbo Account DBO to delete
 * @return boolean True on success
 */
function delete_AccountDBO( &$dbo ) {
	$DB = DBConnection::getDBConnection();

	$id = intval( $dbo->getID() );

	// Delete any HostingSericePurchases assigned to this account
	try {
		$hosting_array = load_array_HostingServicePurchaseDBO( "accountid=" . $id );
		foreach( $hosting_array as $hosting_dbo ) {
			delete_HostingServicePurchaseDBO( $hosting_dbo );
		}
	}
	catch( DBNoRowsFoundException $e ) {

	}

	// Delete any DomainSericePurchases assigned to this account
	try {
		$domain_array = load_array_DomainServicePurchaseDBO( "accountid=" . $id );
		foreach( $domain_array as $domain_dbo ) {
			delete_DomainServicePurchaseDBO( $domain_dbo );
		}
	}
	catch( DBNoRowsFoundException $e ) {

	}

	// Delete any ProductPurchases assigned to this account
	try {
		$product_array = load_array_ProductPurchaseDBO( "accountid=" . $id );
		foreach( $product_array as $product_dbo ) {
			delete_ProductPurchaseDBO( $product_dbo );
		}
	}
	catch( DBNoRowsFoundException $e ) {

	}

	// Delete any Invoices assigned to this account
	try {
		$invoice_array = load_array_InvoiceDBO( "accountid=" . $id );
		foreach( $invoice_array as $invoice_dbo ) {
			delete_InvoiceDBO( $invoice_dbo );
		}
	}
	catch( DBNoRowsFoundException $e ) {

	}

	// Delete any Orders assigned to this account
	try {
		$orders = load_array_OrderDBO( "accountid=" . $id );
		foreach( $orders as $orderDBO ) {
			delete_OrderDBO( $orderDBO );
		}
	}
	catch( DBNoRowsFoundException $e ) {

	}

	// Delete the account's user
	delete_UserDBO( $dbo->getUserDBO() );

	// Build SQL
	$sql = $DB->build_delete_sql( "account",
			"id = " . $id );
	// Delete the AccountDBO
	if ( !mysql_query( $sql, $DB->handle() ) ) {
		throw new DBException( mysql_error( $DB->handle() ) );
	}
}

/**
 * Load an AccountDBO from the database
 *
 * @param integer $id ID of Account DBO to retrieve
 * @return AccountDBO Account DBO
 */
function load_AccountDBO( $id ) {
	$DB = DBConnection::getDBConnection();

	// Build query
	$sql = $DB->build_select_sql( "account",
			"*",
			"id = " . intval( $id ),
			null,
			null,
			null,
			null );

	// Run query
	if ( !($result = @mysql_query( $sql, $DB->handle() ) ) ) {
		// Query error
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	if ( mysql_num_rows( $result ) == 0 ) {
		// No rows found
		throw new DBNoRowsFoundException( "Unable to find account with ID = " . $id );
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
		$start = null ) {
	$DB = DBConnection::getDBConnection();

	// Build query
	$sql = $DB->build_select_sql( "account",
			"*",
			$filter,
			$sortby,
			$sortdir,
			$limit,
			$start );

	// Run query
	if ( !( $result = @mysql_query( $sql, $DB->handle() ) ) ) {
		// Query error
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	if ( mysql_num_rows( $result ) == 0 ) {
		// No rows found
		throw new DBNoRowsFoundException();
	}

	// Build an array of DBOs from the result set
	$dbo_array = array();
	while( $data = mysql_fetch_array( $result ) ) {
		// Create and initialize a new DBO with the data from the DB
		$dbo = new AccountDBO();
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
function count_all_AccountDBO( $filter = null ) {
	$DB = DBConnection::getDBConnection();

	// Build query
	$sql = $DB->build_select_sql( "account",
			"COUNT(*)",
			$filter,
			null,
			null,
			null,
			null );

	// Run query
	if ( !( $result = @mysql_query( $sql, $DB->handle() ) ) ) {
		// SQL error
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	// Make sure the number of rows returned is exactly 1
	if ( mysql_num_rows( $result ) != 1 ) {
		// This must return 1 row
		throw new DBNoRowsFoundException();
	}

	$data = mysql_fetch_array( $result );
	return $data[0];
}

?>
