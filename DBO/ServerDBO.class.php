<?php
/**
 * ServerDBO.class.php
 *
 * This file contains the definition for the ServerDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

/**
 * ServerDBO
 * 
 * Represents a Server.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServerDBO extends DBO
{
  /**
   * @var integer Server ID
   */
  var $id;

  /**
   * @var string Host Name
   */
  var $hostname;

  /**
   * @var string Location
   */
  var $location;

  /**
   * Set ID
   *
   * @param integer $id Server ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get ID
   *
   * @return integer Server ID
   */
  function getID() { return $this->id; }

  /**
   * Set Host Name
   *
   * @param string $hostname Host name
   */
  function setHostName( $hostname ) { $this->hostname = $hostname; }

  /**
   * Get Host Name
   *
   * @return string Host name
   */
  function getHostName() { return $this->hostname; }

  /**
   * Set Location
   *
   * @param string $location Location of Server
   */
  function setLocation( $location ) { $this->location = $location; }

  /**
   * Get Location
   *
   * @return string Location of Server
   */
  function getLocation() { return $this->location; }

  /**
   * Get Hosting Service Purchases
   *
   * Returns an array of HostingServicePurchaseDBO's assigned to this server
   *
   * @return array Array of HostingServicePurchaseDBO's
   */
  function getPurchases()
  {
    return load_array_HostingServicePurchaseDBO( "serverid=" . $this->getID() );
  }

  /**
   * Get IP Addresses
   *
   * Returns an array of IPAddressDBO's assigned to this server
   *
   * @return array Array of IPAddressDBO's
   */
  function getIPAddresses()
  {
    return load_array_IPAddressDBO( "serverid=" . $this->getID() );
  }

  /**
   * Load member data from an array
   *
   * @param array $data Data to be loaded
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setHostName( $data['hostname'] );
    $this->setLocation( $data['location'] );
  }
}

/**
 * Insert ServerDBO into database
 *
 * @param ServerDBO &$dbo ServerDBO to add to database
 * @return boolean True on success
 */
function add_ServerDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "server",
				array( "hostname" => $dbo->getHostName(),
				       "location" => $dbo->getLocation() ) );

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
      fatal_error( "add_ServerDBO()", "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_ServerDBO()", "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update ServerDBO in database
 *
 * @param ServerDBO &$dbo ServerDBO to update
 * @return boolean True on success
 */
function update_ServerDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "server",
				"id = " . $dbo->getID(),
				array( "hostname" => $dbo->getHostName(),
				       "location" => $dbo->getLocation() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete ServerDBO from database
 *
 * @param ServerDBO &$dbo ServerDBO to delete
 * @return boolean True on success
 */
function delete_ServerDBO( &$dbo )
{
  global $DB;

  // Build DELETE query
  $sql = $DB->build_delete_sql( "server",
				"id = " . $dbo->getID() );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a ServerDBO from the database
 *
 * @param integer Server ID
 * @return ServerDBO ServerDBO, or null if not found
 */
function load_ServerDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "server",
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
      fatal_error( "load_ServerDBO()", "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new ServerDBO
  $dbo = new ServerDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple ServerDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of HostingServiceDBO's
 */
function &load_array_ServerDBO( $filter = null,
				$sortby = null,
				$sortdir = null,
				$limit = null,
				$start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "server",
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
      fatal_error( "load_array_ServerDBO()", "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      return null;
    }

  // Build an array of HostingServiceDBOs from the result set
  $server_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new ServerDBO with the data from the DB
      $dbo =& new ServerDBO();
      $dbo->load( $data );

      // Add ServerDBO to array
      $server_dbo_array[] = $dbo;
    }

  return $server_dbo_array;
}

/**
 * Count ServerDBO's
 *
 * Same as load_array_ServerDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of HostingService records
 */
function count_all_ServerDBO( $filter = null )
{
  global $DB;

  // Build query
  $sql = "SELECT COUNT(*) FROM server";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_ServerDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_ServerDBO()", "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>
