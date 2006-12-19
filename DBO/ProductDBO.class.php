<?php
/**
 * ProductDBO.class.php
 *
 * This file contains the definition for the Product Database Object class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ProductDBO
 *
 * Represents a Product or Service that is not recurring.
 *
 * @pacakge DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductDBO extends PurchasableDBO
{
  /**
   * @var string Product description
   */
  protected $description;

  /**
   * @var integer Product ID
   */
  protected $id;

  /**
   * @var string Product name
   */
  protected $name;

  /**
   * Convert to a String
   *
   * @return string Product ID
   */
  public function __toString() { return $this->getID(); }

  /**
   * Set Product ID
   *
   * @param integer $id Product ID
   */
  public function setID( $id ) { $this->id = $id; }

  /**
   * Get Product ID
   *
   * @return integer Product ID
   */
  public function getID() { return $this->id; }

  /**
   * Set Product Name
   *
   * @param string $name Product name
   */
  public function setName( $name ) { $this->name = $name; }

  /**
   * Get Product Name
   *
   * @return string Product name
   */
  public function getName() { return $this->name; }

  /**
   * Set Product Description
   *
   * @var string $description Product description
   */
  public function setDescription( $description ) { $this->description = $description; }

  /**
   * Get Product Description
   *
   * @return string Product description
   */
  public function getDescription() { return $this->description; }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  public function load( $data )
  {
    // Load the record data
    parent::load( $data );

    // Load pricing
    try { $this->prices = load_array_ProductPriceDBO( "productid=" . $this->getID() ); }
    catch( DBNoRowsFoundException $e ) { $this->prices = array(); }
  }
}

/**
 * Add ProductDBO to Database
 *
 * @param ProductDBO &$dbo ProductDBO to be added to database
 * @return boolean True on success
 */
function add_ProductDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "product",
				array( "name" => $dbo->getName(),
				       "description" => $dbo->getDescription() ) );

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
 * Update ProductDBO
 *
 * @param ProductDBO &$dbo ProductDBO to be updated
 * @return boolean True on success
 */
function update_ProductDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "product",
				"id = " . intval( $dbo->getID() ),
				array( "name" => $dbo->getName(),
				       "description" => $dbo->getDescription() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete ProductDBO
 *
 * @param ProductDBO &$dbo ProductDBO to be deleted
 * @return boolean True on success
 */
function delete_ProductDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  try
    {
      load_array_ProductPurchaseDBO( "productid=" . $dbo->getID() );
      
      // Can not delete product if any purchases exist
      throw new DBException( "[PURCHASES_EXIST]" );
    }
  catch( DBNoRowsFoundException $e ) {}

  // Build SQL
  $sql = $DB->build_delete_sql( "product",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load ProductDBO from Database
 *
 * @param integer $id Product ID
 * @return ProductDBO Product, or null if not found
 */
function load_ProductDBO( $id )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "product",
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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
    }
  
  // Load a new HostingServiceDBO
  $dbo = new ProductDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple ProductDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of ProdutDBO's
 */
function &load_array_ProductDBO( $filter = null,
				 $sortby = null,
				 $sortdir = null,
				 $limit = null,
				 $start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "product",
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
      $dbo =& new ProductDBO();
      $dbo->load( $data );

      // Add DomainServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count ProductDBO's
 *
 * Same as load_array_ProductDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of Product records
 */
function count_all_ProductDBO( $filter = null )
{
  $DB = DBConnection::getDBConnection();
  
  // Build query
  $sql = "SELECT COUNT(*) FROM product";

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