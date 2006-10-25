<?php
/**
 * HostingServiceDBO.class.php
 *
 * This file contains the definition for the HostingServiceDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once BASE_PATH . "solidworks/DBO.class.php";

// Tax Rule DBO
require_once BASE_PATH . "DBO/TaxRuleDBO.class.php";

/**
 * HostingServiceDBO
 * 
 * Represents a web hosting service offered by the provider.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingServiceDBO extends DBO
{
  /**
   * @var integer HostingService ID
   */
  var $id;
  
  /**
   * @var string Hosting service title
   */
  var $title;

  /** 
   * @var string Hosting service description
   */
  var $description;

  /**
   * @var double Setup price for 1 month term
   */
  var $setupprice1mo;

  /**
   * @var double Setup price for 3 month term
   */
  var $setupprice3mo;

  /**
   * @var double Setup price for 6 month term
   */
  var $setupprice6mo;

  /**
   * @var double Setup price for 12 month term
   */
  var $setupprice12mo;

  /**
   * @var double Recurring price for 1 month term
   */
  var $price1mo;

  /**
   * @var double Recurring price for 3 month term
   */
  var $price3mo;

  /**
   * @var double Recurring price for 6 month term
   */
  var $price6mo;

  /**
   * @var double Recurring price for 12 month term
   */
  var $price12mo;

  /**
   * @var string Unique IP Requirement
   */
  var $uniqueip;

  /**
   * @var string Taxable
   */
  var $taxable;

  /**
   * Convert to a String
   *
   * @return string Hosting service ID
   */
  function __toString() { return $this->getID(); }

  /**
   * Set Hosting Service ID
   *
   * @param integer $id Hosting Service ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Hosting Service ID
   *
   * @return integer Hosting Service ID
   */
  function getID() { return $this->id; }

  /**
   * Set Hosting Service Title
   *
   * @var string $title Hosting Service Title
   */
  function setTitle( $title ) { $this->title = $title; }

  /**
   * Get Hosting Service Title
   *
   * @return string Hosting Service Title
   */
  function getTitle() { return $this->title; }

  /**
   * Set Description
   *
   * @var string Description
   */
  function setDescription( $description ) { $this->description = $description; }

  /**
   * Get Description
   *
   * @return string Description
   */
  function getDescription() { return $this->description; }

  /**
   * Set Setup Price for 1 month Term
   *
   * @param double Price
   */
  function setSetupPrice1mo( $setup_price ) { $this->setupprice1mo = $setup_price; }

  /**
   * Get Setup Price for 1 Month Term
   *
   * @return double Price
   */
  function getSetupPrice1mo() { return $this->setupprice1mo; }

  /**
   * Set Setup Price for 3 month Term
   *
   * @param double Price
   */
  function setSetupPrice3mo( $setup_price ) { $this->setupprice3mo = $setup_price; }

  /**
   * Get Setup Price for 3 Month Term
   *
   * @return double Price
   */
  function getSetupPrice3mo() { return $this->setupprice3mo; }

  /**
   * Set Setup Price for 6 month Term
   *
   * @param double Price
   */
  function setSetupPrice6mo( $setup_price ) { $this->setupprice6mo = $setup_price; }

  /**
   * Get Setup Price for 6 Month Term
   *
   * @return double Price
   */
  function getSetupPrice6mo() { return $this->setupprice6mo; }

  /**
   * Set Setup Price for 12 month Term
   *
   * @param double Price
   */
  function setSetupPrice12mo( $setup_price ) { $this->setupprice12mo = $setup_price; }

  /**
   * Get Setup Price for 12 Month Term
   *
   * @return double Price
   */
  function getSetupPrice12mo() { return $this->setupprice12mo; }

  /**
   * Set Recurring Price for 1 Month Term
   *
   * @param double $price Price
   */
  function setPrice1mo( $price ) { $this->price1mo = $price; }

  /**
   * Get Recurring Price for 1 Month Term
   *
   * @param double Price
   */
  function getPrice1mo() { return $this->price1mo; }

  /**
   * Set Recurring Price for 3 Month Term
   *
   * @param double $price Price
   */
  function setPrice3mo( $price ) { $this->price3mo = $price; }

  /**
   * Get Recurring Price for 3 Month Term
   *
   * @param double Price
   */
  function getPrice3mo() { return $this->price3mo; }

  /**
   * Set Recurring Price for 6 Month Term
   *
   * @param double $price Price
   */
  function setPrice6mo( $price ) { $this->price6mo = $price; }

  /**
   * Get Recurring Price for 6 Month Term
   *
   * @param double Price
   */
  function getPrice6mo() { return $this->price6mo; }

  /**
   * Set Recurring Price for 12 Month Term
   *
   * @param double $price Price
   */
  function setPrice12mo( $price ) { $this->price12mo = $price; }

  /**
   * Get Recurring Price for 12 Month Term
   *
   * @param double Price
   */
  function getPrice12mo() { return $this->price12mo; }

  /**
   * Set Unique IP Requirement
   *
   * @param string $required 'Required' or 'Not Required'
   */
  function setUniqueIP( $required )
  {
    if( !($required == "Required" || $required == "Not Required") )
      {
	fatal_error( "HostingServiceDBO::setUniqueIP()",
		     "Invalid setting for unique_ip!" );
      }
    $this->uniqueip = $required;
  }

  /**
   * Get Unique IP Requirement
   *
   * @return string Unique IP 'Required' / 'Not Required'
   */
  function getUniqueIP() { return $this->uniqueip; }

  /**
   * Set Taxable Flag
   * 
   * @param string $taxable Taxable flag (Yes or No)
   */
  function setTaxable( $taxable )
  {
    if( !($taxable == "Yes" || $taxable == "No" ) )
      {
	fatal_error( "HostingServiceDBO::setTaxable", "Invalid value: " . $taxable );
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
    $this->setID( $data['id'] );
    $this->setTitle( $data['title'] );
    $this->setDescription( $data['description'] );
    $this->setSetupPrice1mo( $data['setupprice1mo'] );
    $this->setSetupPrice3mo( $data['setupprice3mo'] );
    $this->setSetupPrice6mo( $data['setupprice6mo'] );
    $this->setSetupPrice12mo( $data['setupprice12mo'] );
    $this->setPrice1mo( $data['price1mo'] );
    $this->setPrice3mo( $data['price3mo'] );
    $this->setPrice6mo( $data['price6mo'] );
    $this->setPrice12mo( $data['price12mo'] );
    $this->setUniqueIP( $data['uniqueip'] );
    $this->setTaxable( $data['taxable'] );
  }
}

/**
 * Insert HostingServiceDBO into database
 *
 * @param HostingServiceDBO &$dbo HostingServiceDBO to add to database
 * @return boolean True on success
 */
function add_HostingServiceDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "hostingservice",
				array( "title" => $dbo->getTitle(),
				       "description" => $dbo->getDescription(),
				       "uniqueip" => $dbo->getUniqueIP(),
				       "setupprice1mo" => $dbo->getSetupPrice1mo(),
				       "setupprice3mo" => $dbo->getSetupPrice3mo(),
				       "setupprice6mo" => $dbo->getSetupPrice6mo(),
				       "setupprice12mo" => $dbo->getSetupPrice12mo(),
				       "price1mo" => $dbo->getPrice1mo(),
				       "price3mo" => $dbo->getPrice3mo(),
				       "price6mo" => $dbo->getPrice6mo(),
				       "price12mo" => $dbo->getPrice12mo(),
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
      fatal_error( "add_HostingServiceDBO()", 
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_HostingServiceDBO()", 
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update HostingServiceDBO in database
 *
 * @param HostingServiceDBO &$dbo HostingServiceDBO to update
 * @return boolean True on success
 */
function update_HostingServiceDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "hostingservice",
				"id = " . $dbo->getID(),
				array( "title" => $dbo->getTitle(),
				       "description" => $dbo->getDescription(),
				       "uniqueip" => $dbo->getUniqueIP(),
				       "setupprice1mo" => $dbo->getSetupPrice1mo(),
				       "setupprice3mo" => $dbo->getSetupPrice3mo(),
				       "setupprice6mo" => $dbo->getSetupPrice6mo(),
				       "setupprice12mo" => $dbo->getSetupPrice12mo(),
				       "price1mo" => $dbo->getPrice1mo(),
				       "price3mo" => $dbo->getPrice3mo(),
				       "price6mo" => $dbo->getPrice6mo(),
				       "price12mo" => $dbo->getPrice12mo(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete HostingServiceDBO from database
 *
 * @param HostingServiceDBO &$dbo HostingServiceDBO to delete
 * @return boolean True on success
 */
function delete_HostingServiceDBO( &$dbo )
{
  global $DB;

  // Build DELETE query
  $sql = $DB->build_delete_sql( "hostingservice",
				"id = " . $dbo->getID() );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a HostingServiceDBO from the database
 *
 * @param integer $id HostingService ID
 * @return HostingServiceDBO HostingServiceDBO, or null if not found
 */
function load_HostingServiceDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "hostingservice",
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
      fatal_error( "load_HostingServiceDBO", 
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new HostingServiceDBO
  $dbo = new HostingServiceDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple HostingServiceDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of HostingServiceDBO's
 */
function &load_array_HostingServiceDBO( $filter = null,
					$sortby = null,
					$sortdir = null,
					$limit = null,
					$start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "hostingservice",
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
      fatal_error( "load_array_HostingServiceDBO", "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      return null;
    }

  // Build an array of HostingServiceDBOs from the result set
  $service_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new HostingServiceDBO with the data from the DB
      $dbo =& new HostingServiceDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $service_dbo_array[] = $dbo;
    }

  return $service_dbo_array;
}

/**
 * Count HostingServiceDBO's
 *
 * Same as load_array_HostingServiceDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of HostingService records
 */
function count_all_HostingServiceDBO( $filter = null )
{
  global $DB;

  // Build query
  $sql = "SELECT COUNT(*) FROM hostingservice";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_HostingServiceDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_HostingServiceDBO()", 
		   "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>