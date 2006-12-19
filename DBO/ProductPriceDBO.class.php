<?php
/**
 * ProductPriceDBO.class.php
 *
 * This file contains the definition for the ProductPriceDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ProductPriceDBO
 *
 * Represents a single price for a product
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductPriceDBO extends PriceDBO
{
  /**
   * @var integer The ID of the product this price belongs to
   */
  protected $productid = null;

  /**
   * Get Concatenated ID
   *
   * @return string The concatenated ID of this price (tld-type-termlength)
   */
  public function getID()
  {
    return sprintf( "%d-%s-%d", 
		    $this->getProductID(), 
		    $this->getType(), 
		    $this->getTermLength() );
  }

  /**
   * Get Product ID
   *
   * @return integer Product ID
   */
  public function getProductID() { return $this->productid; }

  /**
   * Set Product ID
   *
   * @param integer The ID of the product that this price is for
   */
  public function setProductID( $id ) { $this->productid = $id; }
}

/**
 * Insert ProductPriceDBO into database
 *
 * @param ProductPriceDBO &$dbo ProductPriceDBO to add to database
 * @return boolean True on success
 */
function add_ProductPriceDBO( ProductPriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "productprice",
				array( "productid" => $dbo->getProductID(),
				       "type" => $dbo->getType(),
				       "termlength" => $dbo->getTermLength(),
				       "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Update ProductPriceDBO in database
 *
 * @param ProductPriceDBO $dbo ProductPriceDBO to update
 * @return boolean True on success
 */
function update_ProductPriceDBO( ProductPriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "productprice",
				sprintf( "productid=%d AND type='%s' AND termlength=%d",
					 $dbo->getProductID(),
					 $dbo->getType(),
					 $dbo->getTermLength() ),
				array( "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete ProductPriceDBO from database
 *
 * @param ProductPriceDBO $dbo ProductPriceDBO to delete
 */
function delete_ProductPriceDBO( ProductPriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build DELETE query
  $sql = $DB->build_delete_sql( "productprice",
				sprintf( "productid=%d AND type='%s' AND termlength=%d",
					 $dbo->getProductID(),
					 $dbo->getType(),
					 $dbo->getTermLength() ) );
  
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a ProductPriceDBO from the database
 *
 * @param integer Product ID
 * @param string Payment type
 * @param integer Term length
 * @return ProductPriceDBO ProductPriceDBO, or null if not found
 */
function load_ProductPriceDBO( $productid, $type, $termLength )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "productprice",
				"*",
				sprintf( "productid=%d AND type='%s' AND termlength=%d",
					 $productid,
					 $type,
					 $termLength ),
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

  // Load a new ProductPriceDBO
  $dbo = new ProductPriceDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple ProductPriceDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of ProductDBO's
 */
function load_array_ProductPriceDBO( $filter = null,
				     $sortby = null,
				     $sortdir = null,
				     $limit = null,
				     $start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "productprice",
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

  // Build an array of ProductPriceDBOs from the result set
  $price_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new ProductDBO with the data from the DB
      $dbo =& new ProductPriceDBO();
      $dbo->load( $data );

      // Add ProductDBO to array
      $price_dbo_array[] = $dbo;
    }

  return $price_dbo_array;
}
?>