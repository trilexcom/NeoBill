<?php
/**
 * ProductPurchaseDBO.class.php
 *
 * This file contains the definition for the Product Database Object class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

require_once "ProductDBO.class.php";
require_once "AccountDBO.class.php";

/**
 * ProductPurchaseDBO
 *
 * Represents a Product purchase by an account.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductPurchaseDBO extends DBO
{
  /**
   * @var integer Product Purchase ID
   */
  var $id;

  /**
   * @var integer Product ID
   */
  var $productid;

  /**
   * @var ProductDBO Product
   */
  var $productdbo;

  /**
   * @var integer Account ID
   */
  var $accountid;

  /**
   * @var AccountDBO Account
   */
  var $accountdbo;

  /**
   * @var string Date of purchase (MySQL DATETIME)
   */
  var $date;

  /**
   * @var string Purchase note
   */
  var $note;

  /**
   * Set Purchase ID
   *
   * @param integer $id Purchase ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Purchase ID
   *
   * @return integer Purchase ID
   */
  function getID() { return $this->id; }

  /**
   * Set Product ID
   *
   * @param integer $id Product ID
   */
  function setProductID( $id )
  {
    $this->productid = $id;
    if( ($this->productdbo = load_ProductDBO( $id )) == null )
      {
	fatal_error( "ProductPurchaseDBO::setProductID()",
		     "could not load ProductDBO for ProductPurchaseDBO, id = " . $id );
      }
  }

  /**
   * Get Product ID
   *
   * @return integer Product ID
   */
  function getProductID() { return $this->productid; }

  /**
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  function setAccountID( $id )
  {
    $this->accountid = $id;
    if( ($this->accountdbo = load_AccountDBO( $id )) == null )
      {
	fatal_error( "ProductPurchaseDBO::setAccountID()",
		     "could not load AccountDBO for AccountPurchaseDBO, id = " . $id );
      }
  }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  function getAccountID() { return $this->accountid; }

  /**
   * Set Purchase Date
   *
   * @param string $date Purchase date (MySQL DATETIME)
   */
  function setDate( $date ) { $this->date = $date; }

  /**
   * Get Purchase Date
   *
   * @return string Purchase date (MySQL DATETIME)
   */
  function getDate() { return $this->date; }

  /**
   * Set Purchase Note
   *
   * @param string $note Purchase note
   */
  function setNote( $note ) { $this->note = $note; }

  /**
   * Get Purchase Note
   *
   * @return string Purchase note
   */
  function getNote() { return $this->note; }

  /**
   * Get Product Name
   *
   * @return string Product name
   */
  function getProductName() { return $this->productdbo->getName(); }

  /**
   * Get Product Price
   *
   * @return double Product price
   */
  function getPrice() { return $this->productdbo->getPrice(); }

  /**
   * Get Taxes
   *
   * Returns all the Tax Rules that affect this purchase (if taxable)
   *
   * @return array TaxRuleDBO array
   */
  function getTaxes()
  {
    global $DB;

    if( $this->productdbo->getTaxable() == "No" )
      {
	return null;
      }

    $filter = 
      "country=" . $DB->quote_smart( $this->accountdbo->getCountry() ) . " AND (" .
      "allstates=" . $DB->quote_smart( "YES" ) . " OR " .
      "state=" . $DB->quote_smart( $this->accountdbo->getState() ) . ")";
    return load_array_TaxRuleDBO( $filter );
  }

  /**
   * Calculate Tax
   *
   * Given a Tax Rule, determine the amount of tax on this purchase
   *
   * @param TaxRuleDBO $taxruledbo Tax rule
   * @return float Amount of tax
   */
  function calculateTax( $taxruledbo )
  {
    return $this->getPrice() * ($taxruledbo->getRate() / 100.00);
  }

  /**
   * Determine if Billable
   *
   * Given an invoice period, returns true if this purchase occured during that
   * period and thus, should be billed.
   *
   * @param string $period_begin Beginning of invoice period (MySQL DATETIME)
   * @param string $period_end End of invoice period (MySQL DATETIME)
   * @return boolean True if billable
   */
  function is_billable( $period_begin, $period_end )
  {
    global $DB;
    return ($DB->datetime_to_unix($this->getDate()) >= $period_begin) && 
      ($DB->datetime_to_unix($this->getDate()) < $period_end);
  }

  /**
   * Load Member Data from Array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setProductID( $data['productid'] );
    $this->setAccountID( $data['accountid'] );
    $this->setDate( $data['date'] );
    $this->setNote( $data['note'] );
  }
}

/**
 * Add ProductPurchaseDBO to database
 *
 * @param ProductPurchaseDBO &$dbo ProductPurchaseDBO to be added to database
 * @return boolean True on success
 */
function add_ProductPurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "productpurchase",
				array( "productid" => intval( $dbo->getProductID() ),
				       "accountid" => intval( $dbo->getAccountID() ),
				       "date" => $dbo->getDate(),
				       "note" => $dbo->getNote() ) );

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
      fatal_error( "add_ProductPurchaseDBO()",
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_ProductPurchaseDBO()", 
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update ProductPurchaseDBO
 *
 * @param ProductPurchaseDBO &$dbo ProductPurchaseDBO to update
 * @return boolean True on success
 */
function update_ProductPurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "productpurchase",
				"id = " . intval( $dbo->getID() ),
				array( "note" => $dbo->getNote(),
				       "date" => $dbo->getDate() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete ProductPurchaseDBO from database
 *
 * @param ProductPurcaseDBO &$dbo ProductPurchaseDBO to delete
 * @return boolean True on success
 */
function delete_ProductPurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "productpurchase",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load ProductPurchaseDBO from Database
 *
 * @param integer $id ProductPurchase ID
 * @return ProductPurchaseDBO ProductPuchase, or null if not found
 */
function load_ProductPurchaseDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "productpurchase",
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
      fatal_error( "load_ProductPurchaseDBO()",
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new HostingServiceDBO
  $dbo = new ProductPurchaseDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple ProductPurchaseDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of ProdutPurchaseDBO's
 */
function &load_array_ProductPurchaseDBO( $filter = null,
					 $sortby = null,
					 $sortdir = null,
					 $limit = null,
					 $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "productpurchase",
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
      fatal_error( "load_array_ProductPurchaseDBO()", "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      return null;
    }

  // Build an array of DBOs from the result set
  $dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DBO with the data from the DB
      $dbo =& new ProductPurchaseDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count ProductPurchaseDBO's
 *
 * Same as load_array_ProductPurchaseDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @return integer Number of ProductPurchase records
 */
function count_all_ProductPurchaseDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "productpurchase",
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
      fatal_error( "count_all_ProductPurchaseDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_ProductPurchaseDBO()",
		   "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>