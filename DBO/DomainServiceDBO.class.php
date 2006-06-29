<?php
/**
 * DomainServiceDBO.class.php
 *
 * This file contains the definition for the DomainServiceDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

// XML-RPC library
require_once $base_path . "xmlrpc/IXR.php";

/**
 * DomainServiceDBO
 *
 * Represents a domain registration service.  Each Top Level Domain that the hosting
 * provider offers registration service for gets a DomainServiceDBO.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServiceDBO extends DBO
{
  /**
   * @var string Top Level Domain
   */
  var $tld;

  /**
   * @var string Name of the domain_registrar module that handles this TLD
   */
  var $modulename;

  /**
   * @var string Service description
   */
  var $description;

  /**
   * @var double Price for 1 year registration
   */
  var $price1yr;

  /**
   * @var double Price for 2 year registration
   */
  var $price2yr;

  /**
   * @var double Price for 3 year registration
   */
  var $price3yr;

  /**
   * @var double Price for 4 year registration
   */
  var $price4yr;

  /**
   * @var double Price for 5 year registration
   */
  var $price5yr;

  /**
   * @var double Price for 6 year registration
   */
  var $price6yr;

  /**
   * @var double Price for 7 year registration
   */
  var $price7yr;

  /**
   * @var double Price for 8 year registration
   */
  var $price8yr;

  /**
   * @var double Price for 9 year registration
   */
  var $price9yr;

  /**
   * @var double Price for 10 year registration
   */
  var $price10yr;

  /**
   * @var string Taxable flag
   */
  var $taxable;

  /**
   * Set Top Level Domain (key field)
   *
   * @param string $tld Top Level Domain
   */
  function setTLD( $tld ) { $this->tld = $tld; }

  /**
   * Get Top Level Domain (key field)
   *
   * @return string Top Level Domain
   */
  function getTLD() { return $this->tld; }
  
  /**
   * Set Module Name
   *
   * @param string $module Module name
   */
  function setModuleName( $modulename ) { $this->modulename = $modulename; }

  /**
   * Get Module Name
   *
   * @return string Module name
   */
  function getModuleName() { return $this->modulename; }

  /**
   * Set Description
   *
   * @param string $description Description
   */
  function setDescription( $description ) { $this->description = $description; }

  /**
   * Get Description
   *
   * @return string Description
   */
  function getDescription() { return $this->description; }

  /**
   * Set Price (1 year term)
   *
   * @param double $price Price
   */
  function setPrice1yr( $price ) { $this->price1yr = $price; }

  /**
   * Get Price (1 year term)
   *
   * @return double Price
   */
  function getPrice1yr() { return $this->price1yr; }

  /**
   * Set Price (2 year term)
   *
   * @param double $price Price
   */
  function setPrice2yr( $price ) { $this->price2yr = $price; }

  /**
   * Get Price (2 year term)
   *
   * @return double Price
   */
  function getPrice2yr() { return $this->price2yr; }

  /**
   * Set Price (3 year term)
   *
   * @param double $price Price
   */
  function setPrice3yr( $price ) { $this->price3yr = $price; }

  /**
   * Get Price (3 year term)
   *
   * @return double Price
   */
  function getPrice3yr() { return $this->price3yr; }

  /**
   * Set Price (4 year term)
   *
   * @param double $price Price
   */
  function setPrice4yr( $price ) { $this->price4yr = $price; }

  /**
   * Get Price (4 year term)
   *
   * @return double Price
   */
  function getPrice4yr() { return $this->price4yr; }

  /**
   * Set Price (5 year term)
   *
   * @param double $price Price
   */
  function setPrice5yr( $price ) { $this->price5yr = $price; }

  /**
   * Get Price (5 year term)
   *
   * @return double Price
   */
  function getPrice5yr() { return $this->price5yr; }

  /**
   * Set Price (6 year term)
   *
   * @param double $price Price
   */
  function setPrice6yr( $price ) { $this->price6yr = $price; }

  /**
   * Get Price (6 year term)
   *
   * @return double Price
   */
  function getPrice6yr() { return $this->price6yr; }

  /**
   * Set Price (7 year term)
   *
   * @param double $price Price
   */
  function setPrice7yr( $price ) { $this->price7yr = $price; }

  /**
   * Get Price (7 year term)
   *
   * @return double Price
   */
  function getPrice7yr() { return $this->price7yr; }

  /**
   * Set Price (8 year term)
   *
   * @param double $price Price
   */
  function setPrice8yr( $price ) { $this->price8yr = $price; }

  /**
   * Get Price (8 year term)
   *
   * @return double Price
   */
  function getPrice8yr() { return $this->price8yr; }

  /**
   * Set Price (9 year term)
   *
   * @param double $price Price
   */
  function setPrice9yr( $price ) { $this->price9yr = $price; }

  /**
   * Get Price (9 year term)
   *
   * @return double Price
   */
  function getPrice9yr() { return $this->price9yr; }

  /**
   * Set Price (10 year term)
   *
   * @param double $price Price
   */
  function setPrice10yr( $price ) { $this->price10yr = $price; }

  /**
   * Get Price (10 year term)
   *
   * @return double Price
   */
  function getPrice10yr() { return $this->price10yr; }

  /**
   * Set Taxable Flag
   * 
   * @param string $taxable Taxable flag (Yes or No)
   */
  function setTaxable( $taxable )
  {
    if( !($taxable == "Yes" || $taxable == "No" ) )
      {
	fatal_error( "DomainServiceDBO::setTaxable", "Invalid value: " . $taxable );
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
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setTLD( $data['tld'] );
    $this->setModuleName( $data['modulename'] );
    $this->setDescription( $data['description'] );
    $this->setPrice1yr( $data['price1yr'] );
    $this->setPrice2yr( $data['price2yr'] );
    $this->setPrice3yr( $data['price3yr'] );
    $this->setPrice4yr( $data['price4yr'] );
    $this->setPrice5yr( $data['price5yr'] );
    $this->setPrice6yr( $data['price6yr'] );
    $this->setPrice7yr( $data['price7yr'] );
    $this->setPrice8yr( $data['price8yr'] );
    $this->setPrice9yr( $data['price9yr'] );
    $this->setPrice10yr( $data['price10yr'] );
    $this->setTaxable( $data['taxable'] );
  }
}

/**
 * Insert DomainServiceDBO into database
 *
 * @param DomainServiceDBO &$dbo DomainServiceDBO to add to database
 * @return boolean True on success
 */
function add_DomainServiceDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "domainservice",
				array( "tld" => $dbo->getTLD(),
				       "modulename" => $dbo->getModuleName(),
				       "description" => $dbo->getDescription(),
				       "price1yr" => $dbo->getPrice1yr(),
				       "price2yr" => $dbo->getPrice2yr(),
				       "price3yr" => $dbo->getPrice3yr(),
				       "price4yr" => $dbo->getPrice4yr(),
				       "price5yr" => $dbo->getPrice5yr(),
				       "price6yr" => $dbo->getPrice6yr(),
				       "price7yr" => $dbo->getPrice7yr(),
				       "price8yr" => $dbo->getPrice8yr(),
				       "price9yr" => $dbo->getPrice9yr(),
				       "price10yr" => $dbo->getPrice10yr(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Update DomainServiceDBO in database
 *
 * @param DomainServiceDBO &$dbo DomainServiceDBO to update
 * @return boolean True on success
 */
function update_DomainServiceDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "domainservice",
				"tld = " . $DB->quote_smart( $dbo->getTLD() ),
				array( "modulename" => $dbo->getModuleName(),
				       "description" => $dbo->getDescription(),
				       "price1yr" => $dbo->getPrice1yr(),
				       "price2yr" => $dbo->getPrice2yr(),
				       "price3yr" => $dbo->getPrice3yr(),
				       "price4yr" => $dbo->getPrice4yr(),
				       "price5yr" => $dbo->getPrice5yr(),
				       "price6yr" => $dbo->getPrice6yr(),
				       "price7yr" => $dbo->getPrice7yr(),
				       "price8yr" => $dbo->getPrice8yr(),
				       "price9yr" => $dbo->getPrice9yr(),
				       "price10yr" => $dbo->getPrice10yr(),
				       "taxable" => $dbo->getTaxable() ) );
				
  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete DomainServiceDBO from database
 *
 * @param DomainServiceDBO &$dbo DomainServiceDBO to delete
 * @return boolean True on success
 */
function delete_DomainServiceDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "domainservice",
				"tld = " . $DB->quote_smart( $dbo->getTLD() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a DomainServiceDBO from the database
 *
 * @param string Top Level Domain
 * @return DomainServiceDBO DomainServiceDBO, or null if not found
 */
function load_DomainServiceDBO( $tld )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "domainservice",
				"*",
				"tld=" . $DB->quote_smart( $tld ),
				null,
				null,
				null,
				null );

  // Run query
  if( !($result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatel_error( "load_DomainServiceDBO", 
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new DomainServiceDBO
  $dbo = new DomainServiceDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple DomainServiceDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of DomainServiceDBO's
 */
function &load_array_DomainServiceDBO( $filter = null,
				       $sortby = null,
				       $sortdir = null,
				       $limit = null,
				       $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "domainservice",
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
      fatal_error( "load_array_DomainServiceDBO", "SELECT failure" );
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
      $dbo =& new DomainServiceDBO();
      $dbo->load( $data );

      // Add DomainServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count DomainServiceDBO's
 *
 * Same as load_array_DomainServiceDBO, except this function just COUNTs the number
 * of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of DomainServiceDBO's
 */
function count_all_DomainServiceDBO( $filter = null )
{
  global $DB;

  // Build query
  $sql = "SELECT COUNT(*) FROM domainservice";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_DomainServiceDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_DomainServiceDBO()",
		   "Expected SELECT to return 1 row" );
      exit();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}
?>