<?php
/**
 * OrderDBO.class.php
 *
 * This file contains the definition for the OrderDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "solidworks/Email.class.php";

// Exceptions
class OrderFailedException extends SWUserException
{
  public function __construct( $message = "unkown" )
  {
    $this->message = sprintf( "[FAILED_TO_COMPLETE_ORDER]: %s.", $message );
  }
}

/**
 * OrderDBO
 *
 * Represent an Order.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderDBO extends DBO
{
  /**
   * @var integer Order ID
   */
  protected $id;

  /**
   * @var string Date order was created
   */
  protected $datecreated;

  /**
   * @var string Date order was completed
   */
  protected $datecompleted;

  /**
   * @var string Date order was fulfilled
   */
  protected $datefulfilled;

  /**
   * @var integer Remote IP address that submitted this order
   */
  protected $remoteip;

  /**
   * @var string Business Name
   */
  protected $businessname;

  /**
   * @var string Contact Name
   */
  protected $contactname;

  /**
   * @var string Contact Email
   */
  protected $contactemail;

  /**
   * @var string Address line 1
   */
  protected $address1;

  /**
   * @var string Address line 2
   */
  protected $address2;

  /**
   * @var string City
   */
  protected $city;

  /**
   * @var string State
   */
  protected $state;

  /**
   * @var string Country code
   */
  protected $country;

  /**
   * @var string Postal / Zip code
   */
  protected $postalcode;

  /**
   * @var string Phone number
   */
  protected $phone;

  /**
   * @var string Mobile Phone number
   */
  protected $mobilephone;

  /**
   * @var string Fax number
   */
  protected $fax;

  /**
   * @var string Username
   */
  protected $username;

  /**
   * @var string Password
   */
  protected $password;

  /**
   * @var string Customer's note
   */
  protected $note = null;

  /**
   * @var string Order status (Incomplete, Pending, or Fulfilled)
   */
  protected $status = "Incomplete";

  /**
   * @var string TOS Accepted (Yes or No)
   */
  protected $acceptedTOS = "No";

  /**
   * @var integer Account ID
   */
  protected $accountid;

  /**
   * @var integer The next order item ID
   */
  protected $orderitemid = 0;

  /**
   * @var array Array of order items (OrderItemDBO's) for this order
   */
  protected $orderitems = array();

  /**
   * Convert to a String
   *
   * @return string Order ID
   */
  public function __toString() { return $this->getOrderID(); }

  /**
   * Set TOS Accepted
   *
   * @param string TOS Accepted flag (Yes or No)
   */
  public function setAcceptedTOS( $acceptedTOS )
  {
    if( !($acceptedTOS == "Yes" || $acceptedTOS == "No") )
      {
	throw new SWException( "Invalid value for AcceptedTOS: " . $acceptedTOS );
      }
    $this->acceptedTOS = $acceptedTOS;
  }

  /**
   * Get TOS Accepteded
   *
   * @param return TOS Accepteded flag (Yes or No)
   */
  public function getAcceptedTOS() { return $this->acceptedTOS; }

  /**
   * Set Order ID
   *
   * @param integer $id New Order ID
   */
  public function setID( $id ) { $this->id = $id; }

  /**
   * Get Order ID
   *
   * return integer Order ID
   */
  public function getID() { return $this->id; }

  /**
   * Set Account ID
   *
   * @param integer $accountid Account ID
   */
  public function setAccountID( $accountid ) { $this->accountid = $accountid; }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  public function getAccountID() { return $this->accountid; }

  /**
   * Get Account DBO
   *
   * @return AccountDBO Account DBO
   */
  public function getAccount() 
  { 
    try{ return load_AccountDBO( $this->getAccountID() ); }
    catch( DBNoRowsFoundException $e ) { return null; }
  }

  /**
   * Get Account Name
   *
   * Returns the account name, or null if the account does not exist
   *
   * @return string Account name
   */
  public function getAccountName()
  {
    if( !($accountDBO = $this->getAccount()) )
      {
	return null;
      }
    return $accountDBO->getAccountName();
  }

  /**
   * Set Date Created
   *
   * @param string $date Date and time when the order was created (MySQL DATETIME)
   */
  public function setDateCreated( $date ) { $this->datecreated = $date; }

  /**
   * Get Date Created
   *
   * @return string Date and time when the order was created (MySQL DATETIME)
   */
  public function getDateCreated() { return $this->datecreated; }

  /**
   * Set Date Completed
   *
   * @param string $date Date and time when the order was completed (MySQL DATETIME)
   */
  public function setDateCompleted( $date ) { $this->datecompleted = $date; }

  /**
   * Get Date Completed
   *
   * @return string Date and time when the order was completed (MySQL DATETIME)
   */
  public function getDateCompleted() { return $this->datecompleted; }

  /**
   * Set Date Fulfilled
   *
   * @param string $date Date and time when the order was fulfilled (MySQL DATETIME)
   */
  public function setDateFulfilled( $date ) { $this->datefulfilled = $date; }

  /**
   * Get Date Fulfilled
   *
   * @return string Date and time when the order was fulfilled (MySQL DATETIME)
   */
  public function getDateFulfilled() { return $this->datefulfilled; }

  /**
   * Set Remote IP
   *
   * @param integer $ip Remote IP address in long-word form
   */
  public function setRemoteIP( $ip ) { $this->remoteip = $ip; }

  /**
   * Get Remote IP
   *
   * @return integer Remote IP address in long-word form
   */
  public function getRemoteIP() { return $this->remoteip; }

  /**
   * Get Remote IP String
   *
   * @return string Remote IP address in dot-quad form
   */
  public function getRemoteIPString() { return long2ip( $this->remoteip ); }

  /**
   * Set Order Status
   *
   * @param string Account status (Incomplete, Pending, or Fulfilled)
   */
  public function setStatus( $status )
  {
    if( !( $status == "Incomplete" || $status == "Pending" || $status == "Fulfilled" ) )
      {
	fatal_error( "OrderDBO::setStatus()",
		     "Bad value for Order status: " . $status );
      }

    $this->status = $status;
  }

  /**
   * Get Order Status
   *
   * @return string Order status
   */
  public function getStatus() { return $this->status; }

  /**
   * Set Business Name
   *
   * @param string $name New Business Name
   */
  public function setBusinessName( $name ) { $this->businessname = $name; }

  /**
   * Get Business Name
   *
   * return string Business Name
   */
  public function getBusinessName() { return $this->businessname; }

  /**
   * Set Contact's Name
   *
   * @param string $name New Contact Name
   */
  public function setContactName( $name ) { $this->contactname = $name; }

  /**
   * Get Contact's Name
   *
   * @return string Contact's name
   */
  public function getContactName() { return $this->contactname; }

  /**
   * Set Contact's Email Address
   *
   * @param string $email New contact email address
   */
  public function setContactEmail( $email ) { $this->contactemail = $email; }

  /**
   * Get Contact's Email Address
   *
   * @return string Contact's email address
   */
  public function getContactEmail() { return $this->contactemail; }

  /**
   * Set Contact's Address (line 1)
   *
   * @param string $address Contact's first address line
   */
  public function setAddress1( $address ) { $this->address1 = $address; }

  /**
   * Get Contact's Address (line 1)
   *
   * return string Contact's first address line
   */
  public function getAddress1() { return $this->address1; }

  /**
   * Set Contact's Address (line 2)
   *
   * @param string $address Contact's address line 2
   */
  public function setAddress2( $address ) { $this->address2 = $address; }

  /**
   * Get Contac'ts Address (line 2)
   *
   * return string Contact's address line 2
   */
  public function getAddress2() { return $this->address2; }

  /**
   * Set Contact's City
   *
   * @param string $city Contact's city
   */
  public function setCity( $city ) { $this->city = $city; }

  /**
   * Get Contact's City
   *
   * return $string Contact's City
   */
  public function getCity() { return $this->city; }

  /**
   * Set Contact's State
   *
   * @param string $state Contact's State
   */
  public function setState( $state ) { $this->state = $state; }

  /**
   * Get Contact's State
   *
   * @return string Contact's State
   */
  public function getState() { return $this->state; }

  /**
   * Set Contact's Country
   *
   * @param string $country Contact's country code
   */
  public function setCountry( $country ) { $this->country = $country; }

  /**
   * Get Contact's Country
   *
   * @return string Contac'ts 2-digit country code
   */
  public function getCountry() { return $this->country; }

  /**
   * Set Contact's Postal Code
   *
   * @param string $zip Contact's postal code
   */
  public function setPostalCode( $zip ) { $this->postalcode = $zip; }

  /**
   * Get Contact's Postal Code
   *
   * @return string Contac'ts postal code
   */
  public function getPostalCode() { return $this->postalcode; }

  /**
   * Set Contact's Phone Number
   *
   * @param string $phone Contact's phone number
   */
  public function setPhone( $phone ) { $this->phone = $phone; }

  /**
   * Get Contact's Phone Number
   *
   * @return string Contact's phone number
   */
  public function getPhone() { return $this->phone; }

  /**
   * Set Contact's Mobile Phone Number
   *
   * @param string $phone Contact's mobile phone number
   */
  public function setMobilePhone( $phone ) { $this->mobilephone = $phone; }

  /**
   * Get Contact's Mobile Phone Number
   *
   * @return string Contact's mobile phone number
   */
  public function getMobilePhone() { return $this->mobilephone; }

  /**
   * Set Contact's Fax Number
   *
   * @param string $fax Contact's fax number
   */
  public function setFax( $fax ) { $this->fax = $fax; }

  /**
   * Get Contact's Fax Number
   *
   * @return string Contact's fax number
   */
  public function getFax() { return $this->fax; }

  /**
   * Set Username
   *
   * @param string $username Username
   */
  public function setUsername( $username ) { $this->username = $username; }

  /**
   * Get Username
   *
   * @return string Username
   */
  public function getUsername() { return $this->username; }

  /**
   * Set Password
   *
   * @param string $password Password
   */
  public function setPassword( $password ) { $this->password = $password; }

  /**
   * Get Password
   *
   * @return string Password
   */
  public function getPassword() { return $this->password; }

  /**
   * Set Customer Note
   *
   * @param string $note Customer note
   */
  public function setNote( $note ) { $this->note = $note; }

  /**
   * Get Customer Note
   *
   * @return string Customer note
   */
  public function getNote() { return $this->note; }

  /**
   * Add Item
   *
   * @param OrderItemDBO $orderitemdbo The order item to add to the order
   */
  public function addItem( OrderItemDBO $orderitemdbo )
  {
    // Assign an ID to the order item
    $orderitemdbo->setOrderItemID( $this->orderitemid );

    // Add the order item to the order
    $this->orderitems[$this->orderitemid] = $orderitemdbo;

    $this->orderitemid++;
  }

  /**
   * Get Items
   *
   * @return array OrderItemDBO's
   */
  public function getItems() { return $this->orderitems; }

  /**
   * Get Domain Order Items
   *
   * @return array Order domain DBOs
   */
  public function getDomainItems() 
  {
    $domainitems = array();
    foreach( $this->orderitems as $orderitemdbo )
      {
	if( is_a( $orderitemdbo, "OrderDomainDBO" ) )
	  {
	    $domainitems[] = $orderitemdbo;
	  }
      }

    return $domainitems; 
  }

  /**
   * Get Hosting Order Items
   *
   * @return array Order hosting DBOs
   */
  public function getHostingItems() 
  { 
    $hostingitems = array();
    foreach( $this->orderitems as $orderitemdbo )
      {
	if( is_a( $orderitemdbo, "OrderHostingDBO" ) )
	  {
	    $hostingitems[] = $orderitemdbo;
	  }
      }

    return $hostingitems; 
  }

  /**
   * Remove an Item from the Order
   *
   * @param integer $orderitemid Order Item ID
   */
  public function removeItem( $orderitemid )
  {
    unset( $this->orderitems[$orderitemid] );
  }

  /**
   * Set Contact Info for a Domain Item
   *
   * @param integer $orderitemid Order Item ID
   * @param ContactDBO $adminContactDBO Admin Contact information array
   * @param ContactDBO $billingContactDBO Billing Contact information array
   * @param ContactDBO $techContactDBO Technical Contact information array
   */
  public function setDomainContact( $orderitemid, 
				    $adminContactDBO, 
				    $billingContactDBO, 
				    $techContactDBO )
  {
    if( !isset( $this->orderitems[$orderitemid] ) )
      {
	throw new SWException( "The order item does not exist" );
      }
    if( !is_a( $this->orderitems[$orderitemid], "OrderDomainDBO" ) )
      {
	throw new SWException( "Attempted to set a domain contact on a non-OrderDomainDBO!" );
      }

    // Set the contacts
    $this->orderitems[$orderitemid]->setAdminContact( $adminContactDBO );
    $this->orderitems[$orderitemid]->setBillingContact( $billingContactDBO );
    $this->orderitems[$orderitemid]->setTechContact( $techContactDBO );
  }

  /**
   * Get Total of Non-recurring Costs (i.e. setup fees)
   *
   * @return double Total non-recurring price, without tax
   */
  public function getNonRecurringTotal()
  {
    $total = 0.00;
    foreach( $this->orderitems as $orderitemdbo )
      {
	if( $orderitemdbo->getStatus != "Rejected" )
	  {
	    $total += $orderitemdbo->getOnetimePrice();
	  }
      }
    return $total;
  }

  /**
   * Get Total of Recurring Costs
   *
   * @return double Total price of all recurring items, without tax or setup fees
   */
  public function getRecurringTotal()
  {
    $total = 0.00;
    foreach( $this->orderitems as $orderitemdbo )
      {
	if( $orderitemdbo->getStatus() != "Rejected" )
	  {
	    $total += $orderitemdbo->getRecurringPrice();
	  }
      }
    return $total;
  }

  /**
   * Get Order Sub-Total (total of recurring and non-recurring costs, w/o taxes)
   *
   * @return double Total cost of order without taxes
   */
  public function getSubTotal() 
  { 
    return $this->getNonRecurringTotal() + $this->getRecurringTotal();
  }

  /**
   * Get the Total Taxes charged for this Order
   *
   * @return double Total taxes
   */
  public function getTaxTotal()
  {
    $total = 0.00;
    foreach( $this->orderitems as $orderitemdbo )
      {
	if( $orderitemdbo->getStatus() != "Rejected" )
	  {
	    $total += ($orderitemdbo->getOnetimeTaxes() + 
		       $orderitemdbo->getRecurringTaxes());
	  }
      }
    return $total;
  }

  /**
   * Get the Grand Total
   *
   * @return double Total of the entire order
   */
  public function getTotal() { return $this->getSubTotal() + $this->getTaxTotal(); }

  /**
   * Get Account Type
   *
   * If the order has an account ID already, it is an "Existing Account", otherwise
   * it is a "New Account" type.
   *
   * @return string Account type, Existing Account or New Account
   */
  public function getAccountType()
  {
      return $this->getAccountID() != 0 ? "Existing Account" : "New Account";
  }
  
  /**
   * Is the Order Empty?
   *
   * @return boolean True if there are no items attached to this order
   */
  public function isEmpty()
  {
    return $this->orderitems == null;
  }

  /**
   * Calculate Taxes for all OrderItems
   */
  public function calculateTaxes()
  {
    $DB = DBConnection::getDBConnection();

    if( !isset( $this->orderitems ) )
      {
	// No items to tax
	return;
      }

    // Load the tax rules that apply to the country and state provided
    $taxQuery = sprintf( "country=%s AND (allstates=%s OR state=%s)",
			 $DB->quote_smart( $this->getCountry() ),
			 $DB->quote_smart( "YES" ),
			 $DB->quote_smart( $this->getState() ) );
    try
      {
	$taxRuleDBOArray = load_array_TaxRuleDBO( $taxQuery );
	foreach( $this->orderitems as $orderItemDBO )
	  {
	    $orderItemDBO->setTaxRules( $taxRuleDBOArray );
	  }
      }
    catch( DBNoRowsFoundException $e ) {}
  }

  /**
   * Get Item
   *
   * @param integer $orderItemID Order Item ID
   * @return &OrderItemDBO Order Item DBO
   */
  public function getItem( $orderItemID )
  {
    return $this->orderitems[$orderItemID];
  }

  /**
   * Accept Item
   *
   * Set an Item's Accept Flag to Yes
   *
   * @param integer $orderitemid Order Item ID
   */
  public function acceptItem( $orderItemID )
  {
    $this->orderitems[$orderItemID]->setStatus( "Accepted" );
  }

  /**
   * Reject Item
   *
   * Set an Item's Accept Flag to No
   *
   * @param integer $orderItemID Order Item ID
   */
  public function rejectItem( $orderItemID )
  {
    $this->orderitems[$orderItemID]->setStatus( "Rejected" );
  }

  /**
   * Get Accepted Items
   *
   * @return array OrderItemDBO's (references) with status == "Accepted"
   */
  public function getAcceptedItems()
  {
    $acceptedItems = array();
    foreach( $this->orderitems as $key => $orderItemDBO )
      {
	if( $orderItemDBO->getStatus() == "Accepted" )
	  {
	    $acceptedItems[] =& $this->orderitems[$key];
	  }
      }

    return $acceptedItems;
  }

  /**
   * Execute New Account Order
   *
   * Create a new account from the OrderDBO
   *
   * @param string $accountType Account type to be created
   * @param string $accountStatus Status for the new account
   * @param string $billingStatus Billing status for the new account
   * @param string $billingDay Billing day for the new account
   * @return boolean True for success
   */
  public function executeNewAccount( $accountType, 
				     $accountStatus, 
				     $billingStatus, 
				     $billingDay )
  {
    // Verify that the username is not in use already
    try 
      { 
	load_UserDBO( $this->getUsername() ); 
	throw new OrderFailedException( "[USER_ALREADY_EXISTS]" );
      }
    catch( DBNoRowsFoundException $e ) {}

    // Create user
    $userDBO = new UserDBO();
    $userDBO->setUsername( $this->getUsername() );
    $userDBO->setPassword( md5( $this->getPassword() ) );
    $userDBO->setType( "Client" );
    add_UserDBO( $userDBO );

    // Create the account
    $accountDBO = new AccountDBO();
    $accountDBO->setType( $accountType );
    $accountDBO->setStatus( $accountStatus );
    $accountDBO->setBillingStatus( $billingStatus );
    $accountDBO->setBillingDay( $billingDay );
    $accountDBO->setBusinessName( $this->getBusinessName() );
    $accountDBO->setContactName( $this->getContactName() );
    $accountDBO->setContactEmail( $this->getContactEmail() );
    $accountDBO->setAddress1( $this->getAddress1() );
    $accountDBO->setAddress2( $this->getAddress2() );
    $accountDBO->setCity( $this->getCity() );
    $accountDBO->setState( $this->getState() );
    $accountDBO->setCountry( $this->getCountry() );
    $accountDBO->setPostalCode( $this->getPostalCode() );
    $accountDBO->setPhone( $this->getPhone() );
    $accountDBO->setMobilePhone( $this->getMobilePhone() );
    $accountDBO->setFax( $this->getFax() );
    $accountDBO->setUsername( $userDBO->getUsername() );
    add_AccountDBO( $accountDBO );

    $this->setAccountID( $accountDBO->getID() );
    return $this->execute();
  }

  /**
   * Execute Order
   *
   * @return boolean True for success
   */
  public function execute()
  {
    $accountDBO = $this->getAccount();

    // Act on all of the accepted items
    foreach( $this->getAcceptedItems() as $orderItemDBO )
      {
	if( !$orderItemDBO->execute( $accountDBO ) )
	  {
	    throw new OrderFailedException( "[FAILED_TO_EXECUTE_ITEM]: " .
					    $orderItemDBO->getOrderItemID() );
	  }
      }
  
    // Set the order to fulfilled and update the database
    $this->setAccountID( $accountDBO->getID() );
    $this->setDateFulfilled( DBConnection::format_datetime( time() ) );
    $this->setStatus( "Fulfilled" );
    update_OrderDBO( $this );

    // Success
    return true;
  }

  /**
   * Complete Order
   *
   * Set the status to "Pending" and the data completed to now, then update DB
   */
  public function complete()
  {
    // Set status to pending and give a timestamp
    $this->setStatus( "Pending" );
    $this->setDateCompleted( DBConnection::format_datetime( time() ) );

    // Update the database record
    update_OrderDBO( $this );

    // Notification e-mail
    $body = $this->replaceTokens( $conf['order']['notification_email'] );

    $notifyEmail = new Email();
    $notifyEmail->addRecipient( $conf['company']['notification_email'] );
    $notifyEmail->setFrom( $conf['company']['email'], "SolidState" );
    $notifyEmail->setSubject( $conf['order']['notification_subject'] );
    $notifyEmail->setBody( $body );
    if( !$notifyEmail->send() )
      {
	log_error( "OrderDBO::complete()", 
		   "Failed to send notification e-mail." );
      }

    // Confirmation e-mail
    $body = $this->replaceTokens( $conf['order']['confirmation_email'] );

    $confirmEmail = new Email();
    $confirmEmail->addRecipient( $this->getContactEmail() );
    $confirmEmail->setFrom( $conf['company']['email'], $conf['company']['name'] );
    $confirmEmail->setSubject( $conf['order']['confirmation_subject'] );
    $confirmEmail->setBody( $body );
    if( !$confirmEmail->send() )
      {
	log_error( "OrderDBO::complete()",
		   "Failed to send confirmation e-mail." );
      }
  }

  /**
   * Replace E-Mail Tokens
   *
   * @param string $body E-mail body
   * @return string E-mail body with tokens replaced
   */
  public function replaceTokens( $body )
  {
    $body = str_replace( "{contact_name}", $this->getContactName(), $body );
    $body = str_replace( "{order_datestamp}", $this->getDateCompleted(), $body );
    $body = str_replace( "{order_id}", $this->getID(), $body );
    $body = str_replace( "{order_ip}", long2ip( $this->getRemoteIP() ), $body );

    return $body;
  }

  /**
   * Get Payment's
   *
   * @return array An array of PaymentDBO's for this order
   */
  public function getPayments() 
  {
    try{ return load_array_PaymentDBO( "orderid=" . $this->getID() ); }
    catch( DBNoRowsFoundException $e ) { return array(); }
  }

  /**
   * Load Data from Array
   *
   * @param array $data Order data
   */
  public function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setDateCreated( $data['datecreated'] );
    $this->setDateCompleted( $data['datecompleted'] );
    $this->setDateFulfilled( $data['datefulfilled'] );
    $this->setRemoteIP( $data['remoteip'] );
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
    $this->setUsername( $data['username'] );
    $this->setPassword( $data['password'] );
    $this->setStatus( $data['status'] );
    $this->setAccountID( $data['accountid'] );
    $this->setNote( $data['note'] );
    $this->setAcceptedTOS( $data['accepted_tos'] );

    // Load order items
    try { $domains = load_array_OrderDomainDBO( "orderid=" . intval( $data['id'] ) ); }
    catch( DBNoRowsFoundException $e ) { $domains = array(); }

    try{ $services = load_array_OrderHostingDBO( "orderid=" . intval( $data['id'] ) ); }
    catch( DBNoRowsFoundException $e ) { $services = array(); }
  
    // Combine domains and services into the orderitems array
    foreach( $domains as $domainItem )
      {
	$this->orderitems[$domainItem->getOrderItemID()] = $domainItem;
      }
    foreach( $services as $serviceItem )
      {
	$this->orderitems[$serviceItem->getOrderItemID()] = $serviceItem;
      }

    // Calculate taxes
    $this->calculateTaxes();
  }
}

/**
 * Insert OrderDBO into database
 *
 * @param OrderDBO &$dbo OrderDBO to add to database
 */
function add_OrderDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "order",
				array( "businessname" => $dbo->getBusinessName(),
				       "datecreated" => $dbo->getDateCreated(),
				       "datecompleted" => $dbo->getDateCompleted(),
				       "datefulfilled" => $dbo->getDateFulfilled(),
				       "remoteip" => $dbo->getRemoteIP(),
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
				       "username" => $dbo->getUsername(),
				       "password" => $dbo->getPassword(),
				       "accountid" => $dbo->getAccountID(),
				       "status" => $dbo->getStatus(),
				       "note" => $dbo->getNote(),
				       "accepted_tos" => $dbo->getAcceptedTOS() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }

  // Get auto-increment ID
  $id = mysql_insert_id( $DB->handle() );

  // Validate ID
  if( $id == false )
    {
      // DB error
      throw new DBException( "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      throw new DBException( "Previous INSERT did not generate an ID" );
    }

  // Save all OrderItemDBO's
  foreach( $dbo->getItems() as $orderItemDBO )
    {
      $orderItemDBO->setOrderID( $id );
      if( is_a( $orderItemDBO, "OrderHostingDBO" ) )
	{
	  add_OrderHostingDBO( $orderItemDBO );
	}
      elseif( is_a( $orderItemDBO, "OrderDomainDBO" ) )
	{
	  add_OrderDomainDBO( $orderItemDBO );
	}
    }

  // Store ID in DBO
  $dbo->setID( $id );
}

/**
 * Update OrderDBO in database
 *
 * @param OrderDBO &$dbo OrderDBO to update
 */
function update_OrderDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Update all OrderItemDBO's
  foreach( $dbo->getItems() as $orderItemDBO )
    {
      if( is_a( $orderItemDBO, "OrderHostingDBO" ) )
	{
	  update_OrderHostingDBO( $orderItemDBO );
	}
      elseif( is_a( $orderItemDBO, "OrderDomainDBO" ) )
	{
	  update_OrderDomainDBO( $orderItemDBO );
	}
    }

  // Build SQL
  $sql = $DB->build_update_sql( "order",
				"id = " . intval( $dbo->getID() ),
				array( "businessname" => $dbo->getBusinessName(),
				       "datecreated" => $dbo->getDateCreated(),
				       "datecompleted" => $dbo->getDateCompleted(),
				       "datefulfilled" => $dbo->getDateFulfilled(),
				       "remoteip" => $dbo->getRemoteIP(),
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
				       "username" => $dbo->getUsername(),
				       "password" => $dbo->getPassword(),
				       "accountid" => $dbo->getAccountID(),
				       "status" => $dbo->getStatus(),
				       "note" => $dbo->getNote(),
				       "accepted_tos" => $dbo->getAcceptedTOS() ) );
				
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete OrderDBO from database
 *
 * @param OrderDBO &$dbo OrderDBO to delete
 */
function delete_OrderDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Delete all Order Items
  foreach( $dbo->getHostingItems() as $orderItemDBO )
    {
      delete_OrderHostingDBO( $orderItemDBO );
    }

  foreach( $dbo->getDomainItems() as $orderItemDBO )
    {
      delete_OrderDomainDBO( $orderItemDBO );
    }

  // Build SQL
  $sql = $DB->build_delete_sql( "order",
				"id = " . intval( $dbo->getID() ) );

  // Delete order
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a OrderDBO from the database
 *
 * @param integer $id Order ID
 * @return OrderDBO OrderDBO
 */
function load_OrderDBO( $id )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "order",
				"*",
				"id=" . intval( $id ),
				null,
				null,
				null,
				null );

  // Run query
  if( !($result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
    }

  // Load a new OrderDBO
  $dbo = new OrderDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple OrderDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function &load_array_OrderDBO( $filter = null,
			       $sortby = null,
			       $sortdir = null,
			       $limit = null,
			       $start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "order",
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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
    }

  // Build an array of DBOs from the result set
  $dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DBO with the data from the DB
      $dbo =& new OrderDBO();
      $dbo->load( $data );

      // Add OrderDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count OrderDBO's
 *
 * Same as load_array_OrderDBO, except this function just COUNTs the number
 * of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function count_all_OrderDBO( $filter = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = "SELECT COUNT(*) FROM `order`";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      throw new DBException();
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      throw new DBException();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>