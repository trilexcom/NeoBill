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

// Parent class
require_once BASE_PATH . "solidworks/DBO.class.php";

/**
 * ProductDBO
 *
 * Represents a Product or Service that is not recurring.
 *
 * @pacakge DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductDBO extends DBO
{
  /**
   * @var integer Product ID
   */
  var $id;

  /**
   * @var string Product name
   */
  var $name;

  /**
   * @var string Product description
   */
  var $description;

  /**
   * @var double Product price
   */
  var $price;

  /**
   * @var string Taxable flag
   */
  var $taxable;

  /**
   * Set Product ID
   *
   * @param integer $id Product ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Product ID
   *
   * @return integer Product ID
   */
  function getID() { return $this->id; }

  /**
   * Set Product Name
   *
   * @param string $name Product name
   */
  function setName( $name ) { $this->name = $name; }

  /**
   * Get Product Name
   *
   * @return string Product name
   */
  function getName() { return $this->name; }

  /**
   * Set Product Description
   *
   * @var string $description Product description
   */
  function setDescription( $description ) { $this->description = $description; }

  /**
   * Get Product Description
   *
   * @return string Product description
   */
  function getDescription() { return $this->description; }

  /**
   * Set Product Price
   *
   * @param double $price Product price
   */
  function setPrice( $price ) { $this->price = $price; }

  /**
   * Get Product Price
   *
   * @return double Product price
   */
  function getPrice() { return $this->price; }

  /**
   * Set Taxable Flag
   * 
   * @param string $taxable Taxable flag (Yes or No)
   */
  function setTaxable( $taxable )
  {
    if( !($taxable == "Yes" || $taxable == "No" ) )
      {
	fatal_error( "ProductDBO::setTaxable", "Invalid value: " . $taxable );
      }
    $this->taxable = $taxable;
  }

  /**
   * Get Taxable Flag
   *
   * @return string Taxable flag (Yes or No)
   */
  function getTaxable() { return $this->taxable; }

  /**
   * Load Member Data from Array
   *
   * @param array $date Data to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setName( $data['name'] );
    $this->setDescription( $data['description'] );
    $this->setPrice( $data['price'] );
    $this->setTaxable( $data['taxable'] );
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
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "product",
				array( "name" => $dbo->getName(),
				       "description" => $dbo->getDescription(),
				       "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

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
      fatal_error( "add_ProductDBO()",
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_ProductDBO()", "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update ProductDBO
 *
 * @param ProductDBO &$dbo ProductDBO to be updated
 * @return boolean True on success
 */
function update_ProductDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "product",
				"id = " . intval( $dbo->getID() ),
				array( "name" => $dbo->getName(),
				       "description" => $dbo->getDescription(),
				       "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete ProductDBO
 *
 * @param ProductDBO &$dbo ProductDBO to be deleted
 * @return boolean True on success
 */
function delete_ProductDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "product",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load ProductDBO from Database
 *
 * @param integer $id Product ID
 * @return ProductDBO Product, or null if not found
 */
function load_ProductDBO( $id )
{
  global $DB;

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
      fatal_error( "load_ProductDBO()", "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
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
  global $DB;

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
      fatal_error( "load_array_ProductDBO()", "SELECT failure" );
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
  global $DB;
  
  // Build query
  $sql = "SELECT COUNT(*) FROM product";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_ProductDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_ProductDBO()", "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>