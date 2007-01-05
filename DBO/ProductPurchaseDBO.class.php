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

/**
 * ProductPurchaseDBO
 *
 * Represents a Product purchase by an account.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductPurchaseDBO extends PurchaseDBO
{
  /**
   * @var integer Product Purchase ID
   */
  protected $id;

  /**
   * @var integer Product ID
   */
  protected $productid;

  /**
   * @var string Purchase note
   */
  protected $note;

  /**
   * Convert to a String
   *
   * @return string Product Purchase ID
   */
  function __toString() { return $this->getID(); }

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
    $this->setPurchasable( load_ProductDBO( $id ) );
  }

  /**
   * Get Product ID
   *
   * @return integer Product ID
   */
  function getProductID() { return $this->purchasable->getID(); }

  /**
   * Set Purchasable
   *
   * @param ProductDBO The product that is/was purchased
   */
  public function setPurchasable( ProductDBO $productDBO )
  {
    // This function is meant to force purchasable to be a ProductDBO
    parent::setPurchasable( $productDBO );
  }

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
  function getProductName() { return $this->purchasable->getName(); }

  /**
   * Get Domain Service Title
   *
   * @return string Product name
   */
  function getTitle() { return $this->getProductName(); }

  /**
   * Get Description for "Recurring" Line Item
   *
   * @return string The text that should appear on the invoice for this purchase
   */
  public function getLineItemTextRecurring()
  {
    $term = $this->getTerm();
    return sprintf( "%s ([TERM]: %d %s)", 
		    $this->getTitle(), 
		    $term,
		    $term > 1 ? "[MONTHS]" : "[MONTH]" );
  }
}

/**
 * Add ProductPurchaseDBO to database
 *
 * @param ProductPurchaseDBO &$dbo ProductPurchaseDBO to be added to database
 */
function add_ProductPurchaseDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "productpurchase",
				array( "productid" => intval( $dbo->getProductID() ),
				       "accountid" => intval( $dbo->getAccountID() ),
				       "term" => intval( $dbo->getTerm() ),
				       "date" => $dbo->getDate(),
				       "note" => $dbo->getNote(),
				       "nextbillingdate" => $dbo->getNextBillingDate(),
				       "previnvoiceid" => $dbo->getPrevInvoiceID() ) );

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

  // Store ID in DBO
  $dbo->setID( $id );
}

/**
 * Update ProductPurchaseDBO
 *
 * @param ProductPurchaseDBO &$dbo ProductPurchaseDBO to update
 * @return boolean True on success
 */
function update_ProductPurchaseDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "productpurchase",
				"id = " . intval( $dbo->getID() ),
				array( "note" => $dbo->getNote(),
				       "date" => $dbo->getDate(),
				       "term" => $dbo->getTerm(),
				       "nextbillingdate" => $dbo->getNextBillingDate(),
				       "previnvoiceid" => $dbo->getPrevInvoiceID() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete ProductPurchaseDBO from database
 *
 * @param ProductPurcaseDBO &$dbo ProductPurchaseDBO to delete
 * @return boolean True on success
 */
function delete_ProductPurchaseDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_delete_sql( "productpurchase",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load ProductPurchaseDBO from Database
 *
 * @param integer $id ProductPurchase ID
 * @return ProductPurchaseDBO ProductPuchase, or null if not found
 */
function load_ProductPurchaseDBO( $id )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();
  
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