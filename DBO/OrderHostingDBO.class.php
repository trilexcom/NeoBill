<?php
/**
 * OrderHostingDBO.class.php
 *
 * This file contains the definition for the OrderHostingDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once BASE_PATH . "DBO/OrderItemDBO.class.php";

require_once BASE_PATH . "DBO/HostingServicePurchaseDBO.class.php";

/**
 * OrderHostingDBO
 *
 * Represent an OrderHosting.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderHostingDBO extends OrderItemDBO
{
  /**
   * @var integer OrderHosting ID
   */
  var $id;

  /**
   * @var integer Service ID
   */
  var $serviceid;

  /**
   * @var HostingServiceDBO Hosting service that is being ordered
   */
  var $servicedbo;

  /**
   * @var string Term
   */
  var $term;

  /**
   * Set OrderHosting ID
   *
   * @param integer $id OrderHosting ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get OrderHosting ID
   *
   * @return integer OrderHosting ID
   */
  function getID() { return $this->id; }

  /**
   * Set Service
   *
   * @param HostingServiceDBO $dbo Hosting Service DBO
   */
  function setService( $dbo ) 
  {
    if( !is_a( $dbo, "HostingServiceDBO" ) )
      {
	fatal_error( "OrderHostingDBO::setService", "DBO is not a HostingServiceDBO" );
      }
    $this->servicedbo = $dbo;
    $this->serviceid = $dbo->getID(); 
  }

  /**
   * Set Service ID
   *
   * @param integer $id Hosting Service ID
   */
  function setServiceID( $id ) 
  { 
    if( ($this->servicedbo = load_HostingServiceDBO( $id )) == null )
      {
	fatal_error( "OrderHostingDBO::setServiceID()",
		     "Unable to load HostingServiceDBO with id = " . $id );
      }
    $this->serviceid = $id; 
  }

  /**
   * Get Service ID
   *
   * @return integer Hosting Service ID
   */
  function getServiceID() { return $this->serviceid; }

  /**
   * Set Term
   *
   * @param string $term Hosting term ("1 month" ... "12 months")
   */
  function setTerm( $term )
  {
    if( !( $term == null ||
	   $term == "1 month" ||
	   $term == "3 month" ||
	   $term == "6 month" ||
	   $term == "12 month"  ) )
      {
	fatal_error( "OrderHostingDBO::setTerm()", "Invalid term: " . $term );
      }
    $this->term = $term;
  }

  /**
   * Get Term
   *
   * @return string Hosting term ("1 month" ... "12 months")
   */
  function getTerm() { return $this->term; }

  /**
   * Get Description
   *
   * @return string Description of this order item
   */
  function getDescription()
  {
    return "[WEB_HOSTING_PACKAGE]: " . $this->servicedbo->getTitle();
  }

  /**
   * Get Price
   *
   * @return double Price of this order item
   */
  function getPrice()
  {
    switch( $this->getTerm() )
      {
      case "1 month": return $this->servicedbo->getPrice1mo();
      case "3 month": return $this->servicedbo->getPrice3mo();
      case "6 month": return $this->servicedbo->getPrice6mo();
      case "12 month": return $this->servicedbo->getPrice12mo();
      }
  }

  /**
   * Get Price String
   *
   * @return string Price formatted with currency symbol
   */
  function getPriceString()
  {
    return smarty_modifier_currency( $this->getPrice() );
  }

  /**
   * Get Setup Fee
   *
   * @return double Setup fee for this order item
   */
  function getSetupFee()
  {
    switch( $this->getTerm() )
      {
      case "1 month": return $this->servicedbo->getSetupPrice1mo();
      case "3 month": return $this->servicedbo->getSetupPrice3mo();
      case "6 month": return $this->servicedbo->getSetupPrice6mo();
      case "12 month": return $this->servicedbo->getSetupPrice12mo();
      }
  }

  /**
   * Get Setup Fee String
   *
   * @return string Setup fee formatted with currency symbol
   */
  function getSetupFeeString()
  {
    return smarty_modifier_currency( $this->getSetupFee() );
  }

  /**
   * Is Taxable
   *
   * @return boolean True if this item is taxable
   */
  function isTaxable() { return $this->servicedbo->getTaxable() == "Yes"; }

  /**
   * Execute Hosting Service Order
   *
   * Create a new Hosting Service Purchase for this order item
   *
   * @param AccountDBO $accountDBO Account object
   * @return boolean True for success
   */
  function execute( $accountDBO )
  {
    global $DB;

    // Create a hosting service purchase record
    $purchaseDBO = new HostingServicePurchaseDBO();
    $purchaseDBO->setAccountID( $accountDBO->getID() );
    $purchaseDBO->setHostingServiceID( $this->getServiceID() );
    $purchaseDBO->setTerm( $this->getTerm() );
    $purchaseDBO->setDate( $DB->format_datetime( time() ) );
    if( !add_HostingServicePurchaseDBO( $purchaseDBO ) )
      {
	log_error( "OrderHostingDBO::execute()", 
		   "Failed to add hosting service purchase to DB" );
	return false;
      }

    // Fulfill the order and return
    $this->setStatus( "Fulfilled" );
    if( !update_OrderHostingDBO( $this ) )
      {
	log_error( "OrderDomainDBO::execute()",
		   "Failed to update OrderDomainDBO" );
	return false;
      }

    // Success
    return true;
  }

  /**
   * Load Member Data from Array
   */
  function load( $data )
  {
    parent::load( $data );
    $this->setID( $data['id'] );
    $this->setOrderID( $data['orderid'] );
    $this->setOrderItemID( $data['orderitemid'] );
    $this->setServiceID( $data['serviceid'] );
    $this->setTerm( $data['term'] );
  }

}

/**
 * Insert OrderHostingDBO into database
 *
 * @param OrderHostingDBO &$dbo OrderHostingDBO to add to database
 * @return boolean True on success
 */
function add_OrderHostingDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "orderhosting",
				array( "orderid" => intval( $dbo->getOrderID() ),
				       "orderitemid" => intval( $dbo->getOrderItemID() ),
				       "serviceid" => $dbo->getServiceID(),
				       "status" => $dbo->getStatus(),
				       "term" => $dbo->getTerm() ) );

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
      fatal_error( "add_OrderHostingDBO()", 
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_OrderHostingDBO()", 
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );
  return true;
}

/**
 * Update OrderHostingDBO in database
 *
 * @param OrderHostingDBO &$dbo OrderHostingDBO to update
 * @return boolean True on success
 */
function update_OrderHostingDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "orderhosting",
				"id = " . intval( $dbo->getID() ),
				array( "orderid" => intval( $dbo->getOrderID() ),
				       "serviceid" => $dbo->getServiceID(),
				       "status" => $dbo->getStatus(),
				       "term" => $dbo->getTerm() ) );
				
  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete OrderHostingDBO from database
 *
 * @param OrderHostingDBO &$dbo OrderHostingDBO to delete
 * @return boolean True on success
 */
function delete_OrderHostingDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "orderhosting",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a OrderHostingDBO from the database
 *
 * @param integer $id OrderHosting ID
 * @return OrderHostingDBO OrderHostingDBO, or null if not found
 */
function load_OrderHostingDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "orderhosting",
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
      fatel_error( "load_OrderHostingDBO", 
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new OrderDBO
  $dbo = new OrderHostingDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple OrderHostingDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function &load_array_OrderHostingDBO( $filter = null,
				     $sortby = null,
				     $sortdir = null,
				     $limit = null,
				     $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "orderhosting",
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
      fatal_error( "load_array_OrderHostingDBO", "SELECT failure" );
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
      $dbo =& new OrderHostingDBO();
      $dbo->load( $data );

      // Add OrderDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count OrderHostingDBO's
 *
 * Same as load_array_OrderHostingDBO, except this function just COUNTs the number
 * of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function count_all_OrderHostingDBO( $filter = null )
{
  global $DB;

  // Build query
  $sql = "SELECT COUNT(*) FROM orderhosting";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_OrderHostingDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_OrderHostingDBO()",
		   "Expected SELECT to return 1 row" );
      exit();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}
?>