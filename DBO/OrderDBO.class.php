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

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

require_once $base_path . "DBO/OrderDomainDBO.class.php";
require_once $base_path . "DBO/OrderHostingDBO.class.php";

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
  var $id;

  /**
   * @var string Business Name
   */
  var $businessname;

  /**
   * @var string Contact Name
   */
  var $contactname;

  /**
   * @var string Contact Email
   */
  var $contactemail;

  /**
   * @var string Address line 1
   */
  var $address1;

  /**
   * @var string Address line 2
   */
  var $address2;

  /**
   * @var string City
   */
  var $city;

  /**
   * @var string State
   */
  var $state;

  /**
   * @var string Country code
   */
  var $country;

  /**
   * @var string Postal / Zip code
   */
  var $postalcode;

  /**
   * @var string Phone number
   */
  var $phone;

  /**
   * @var string Mobile Phone number
   */
  var $mobilephone;

  /**
   * @var string Fax number
   */
  var $fax;

  /**
   * @var string Username
   */
  var $username;

  /**
   * @var string Password
   */
  var $password;

  /**
   * @var string Order status (Incomplete, Pending, or Fulfilled)
   */
  var $status = "Incomplete";

  /**
   * @var integer Account ID
   */
  var $accountid;

  /**
   * @var integer The next order item ID
   */
  var $orderitemid = 0;

  /**
   * @var boolean Set to true if the customer does not want to purcahse hosting
   */
  var $skiphosting = false;

  /**
   * @var array List of domains that the customer already owns
   */
  var $existingdomains = array();

  /**
   * @var array Array of order items (OrderItemDBO's) for this order
   */
  var $orderitems = array();

  /**
   * Set Order ID
   *
   * @param integer $id New Order ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Order ID
   *
   * return integer Order ID
   */
  function getID() { return $this->id; }

  /**
   * Set Account ID
   *
   * @param integer $accountid Account ID
   */
  function setAccountID( $accountid ) { $this->accountid = $accountid; }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  function getAccountID() { return $this->accountid; }

  /**
   * Set Order Status
   *
   * @param string Account status (Incomplete, Pending, or Fulfilled)
   */
  function setStatus( $status )
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
  function getStatus() { return $this->status; }

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
   * Set Username
   *
   * @param string $username Username
   */
  function setUsername( $username ) { $this->username = $username; }

  /**
   * Get Username
   *
   * @return string Username
   */
  function getUsername() { return $this->username; }

  /**
   * Set Password
   *
   * @param string $password Password
   */
  function setPassword( $password ) { $this->password = $password; }

  /**
   * Get Password
   *
   * @return string Password
   */
  function getPassword() { return $this->password; }

  /**
   * Skip Hosting
   *
   * @param boolean $flag Pass in true if the customer does not want to purhase hosting
   * @return mixed Null to read the flag, true/false to set it
   */
  function skipHosting( $flag = null )
  {
    if( !isset( $flag ) )
      {
	return $this->skiphosting;
      }

    $this->skiphosting = $flag;
  }

  /**
   * Add Existing Domain
   *
   * @param string $domainname An existing domain name that the customer wants to be hosted
   */
  function addExistingDomain( $orderdomaindbo )
  {
    if( !is_a( $orderdomaindbo, "OrderDomainDBO" ) )
      {
	fatal_error( "OrderDBO::addExistingDBO()", 
		     "Parameter is not a valid OrderDomainDBO" );
      }
    // Assign an order item id to this item
    $orderdomaindbo->setOrderItemID( $this->orderitemid );
    $this->orderitemid++;

    // Add item to the existing domains list
    $this->existingdomains[] = $orderdomaindbo;
  }

  /**
   * Get Existing Domains
   *
   * @return array List of existing domains
   */
  function getExistingDomains() { return $this->existingdomains; }

  /**
   * Remove an Existing Domain from the Order
   *
   * @param integer $orderitemid Order Item ID
   */
  function removeExistingDomain( $orderitemid )
  {
    foreach( $this->existingdomains as $key => $orderitemdbo )
      {
	if( $orderitemdbo->getOrderItemID() == $orderitemid )
	  {
	    unset( $this->existingdomains[$key] );
	    return;
	  }
      }
  }

  /**
   * Add Item
   *
   * @param OrderItemDBO $orderitemdbo The order item to add to the order
   */
  function addItem( $orderitemdbo )
  {
    if( !is_a( $orderitemdbo, "OrderItemDBO" ) )
      {
	fatal_error( "OrderDBO::addItem()", "Parameter is not an OrderItemDBO" );
      }

    // Assign an ID to the order item
    $orderitemdbo->setOrderItemID( $this->orderitemid );
    $this->orderitemid++;

    // Add the order item to the order
    $this->orderitems[] = $orderitemdbo;
  }

  /**
   * Get Items
   *
   * @return array OrderItemDBO's
   */
  function getItems() { return $this->orderitems; }

  /**
   * Get Domain Order Items
   *
   * @return array Order domain DBOs
   */
  function getDomainItems() 
  {
    $domainitems = null;
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
  function getHostingItems() 
  { 
    $hostingitems = null;
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
  function removeItem( $orderitemid )
  {
    foreach( $this->orderitems as $key => $orderitemdbo )
      {
	if( $orderitemdbo->getOrderItemID() == $orderitemid )
	  {
	    unset( $this->orderitems[$key] );
	    return;
	  }
      }
  }

  /**
   * Get Total of Non-recurring Costs (i.e. setup fees)
   *
   * @return double Total non-recurring price, without tax
   */
  function getNonRecurringTotal()
  {
    $total = 0.00;
    foreach( $this->orderitems as $orderitemdbo )
      {
	$total += $orderitemdbo->getSetupFee();
      }
    return $total;
  }

  /**
   * Get Total of Recurring Costs
   *
   * @return double Total price of all recurring items, without tax or setup fees
   */
  function getRecurringTotal()
  {
    $total = 0.00;
    foreach( $this->orderitems as $orderitemdbo )
      {
	$total += $orderitemdbo->getPrice();
      }
    return $total;
  }

  /**
   * Get Order Sub-Total (total of recurring and non-recurring costs, w/o taxes)
   *
   * @return double Total cost of order without taxes
   */
  function getSubTotal() 
  { 
    return $this->getNonRecurringTotal() + $this->getRecurringTotal();
  }

  /**
   * Get the Total Taxes charged for this Order
   *
   * @return double Total taxes
   */
  function getTaxTotal()
  {
    $total = 0.00;
    foreach( $this->orderitems as $orderitemdbo )
      {
	$total += $orderitemdbo->getTaxAmount( $this->getCountry(), 
					       $this->getState() );
      }
    return $total;
  }

  /**
   * Get the Grand Total
   *
   * @return double Total of the entire order
   */
  function getTotal() { return $this->getSubTotal() + $this->getTaxTotal(); }

  /**
   * Is the Order Empty?
   *
   * @return boolean True if there are no items attached to this order
   */
  function isEmpty()
  {
    return $this->orderitems == null;
  }

  /**
   * Calculate Taxes for all OrderItems
   */
  function calculateTaxes()
  {
    global $DB;

    if( !isset( $this->orderitems ) )
      {
	// No items to tax
	return;
      }

    // Load the tax rules that apply to the country and state provided
    if( null == 
	($taxRuleDBOArray = 
	 load_array_TaxRuleDBO( sprintf( "country=%s AND (allstates=%s OR state=%s)",
					 $DB->quote_smart( $this->getCountry() ),
					 $DB->quote_smart( "YES" ),
					 $DB->quote_smart( $this->getState() ) ) ) ) )
      {
	// No taxes apply
	return;
      }
    
    foreach( $this->orderitems as $orderItemDBO )
      {
	if( !$orderItemDBO->isTaxable() )
	  {
	    // This item is not taxable
	    continue;
	  }

	$taxAmount = 0.00;
	foreach( $taxRuleDBOArray as $taxRuleDBO )
	  {
	    $rate = $taxRuleDBO->getRate() / 100.00;
	    $taxAmount += 
	      ($orderItemDBO->getPrice() * $rate) + 
	      ($orderItemDBO->getSetupFee() * $rate);
	  }

	// Assign the order item it's tax amount
	$orderItemDBO->setTaxAmount( $taxAmount );
      }
  }
}

/**
 * Insert OrderDBO into database
 *
 * @param OrderDBO &$dbo OrderDBO to add to database
 * @return boolean True on success
 */
function add_OrderDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "order",
				array( "businessname" => $dbo->getBusinessName(),
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
				       "status" => $dbo->getStatus() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      echo $sql;
      echo mysql_error();
      return false;
    }

  // Get auto-increment ID
  $id = mysql_insert_id( $DB->handle() );

  // Validate ID
  if( $id == false )
    {
      // DB error
      fatal_error( "add_OrderDBO()", "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_OrderDBO()", "Previous INSERT did not generate an ID" );
    }

  // Save all OrderItemDBO's
  foreach( $dbo->orderitems as $orderItemDBO )
    {
      $orderItemDBO->setOrderID( $id );
      if( is_a( $orderItemDBO, "OrderHostingDBO" ) )
	{
	  if( !add_OrderHostingDBO( $orderItemDBO ) )
	    {
	      fatal_error( "add_OrderDBO()", "Could not save Hosting Item to database!" );
	    }
	}
      elseif( is_a( $orderItemDBO, "OrderDomainDBO" ) )
	{
	  if( !add_OrderDomainDBO( $orderItemDBO ) )
	    {
	      fatal_error( "add_OrderDBO()", "Could not save Hosting Item to database!" );
	    }
	}
    }

  // Save existing domains
  foreach( $dbo->existingdomains as $orderItemDBO )
    {
      if( !add_OrderDomainItemDBO( $orderItemDBO ) )
	{
	  fatal_error( "add_OrderDBO()", "Could not save Hosting Item to database!" );
	}
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update OrderDBO in database
 *
 * @param OrderDBO &$dbo OrderDBO to update
 * @return boolean True on success
 */
function update_OrderDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "order",
				"id = " . intval( $dbo->getID() ),
				array( "businessname" => $dbo->getBusinessName(),
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
				       "status" => $dbo->getStatus() ) );
				
  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete OrderDBO from database
 *
 * @param OrderDBO &$dbo OrderDBO to delete
 * @return boolean True on success
 */
function delete_OrderDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "order",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a OrderDBO from the database
 *
 * @param integer $id Order ID
 * @return OrderDBO OrderDBO, or null if not found
 */
function load_OrderDBO( $id )
{
  global $DB;

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
      fatel_error( "load_OrderDBO", 
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
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
  global $DB;

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
      fatal_error( "load_array_OrderDBO", "SELECT failure" );
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
  global $DB;

  // Build query
  $sql = "SELECT COUNT(*) FROM order";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_OrderDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_OrderDBO()",
		   "Expected SELECT to return 1 row" );
      exit();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>