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
   * @var string Control Panel module
   */
  protected $CPModule = null;

  /**
   * Convert to a String
   *
   * @return string Server ID
   */
  function __toString() { return $this->getID(); }

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
   * Set Control Panel Module
   *
   * @param string Control Panel Module
   */
  public function setCPModule( $CPModule ) { $this->CPModule = $CPModule; }

  /**
   * Get Control Panel Module
   *
   * @return string Control panel module name
   */
  public function getCPModule() { return $this->CPModule; }

  /**
   * Get Hosting Service Purchases
   *
   * Returns an array of HostingServicePurchaseDBO's assigned to this server
   *
   * @return array Array of HostingServicePurchaseDBO's
   */
  function getPurchases()
  {
    try { return load_array_HostingServicePurchaseDBO( "serverid=" . $this->getID() ); }
    catch( DBNoRowsFoundException $e ) { return array(); }
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
    try { load_array_IPAddressDBO( "serverid=" . $this->getID() ); }
    catch( DBNoRowsFoundException $e ) { return array(); }
  }

  /**
   * Create Account
   *
   * Creates a new control panel account on the server
   *
   * @param HostingServiceDBO $serviceDBO The service package
   * @param string $domainName The primary domain name to use
   * @param string $username The account's control panel username
   * @param string $password The account's control panel password
   */
  public function createAccount( HostingServiceDBO $serviceDBO,
				 $domainName,
				 $username )
  {
    if( !isset( $this->CPModule ) )
      {
	throw new SWUserException( "[THERE_IS_NO_CONTROL_PANEL_MODULE_CONFIGURED_FOR_THIS_SERVER]" );
      }

    $CPModule = ModuleRegistry::getModuleRegistry()->getModule( $this->getCPModule() );
    $password = $CPModule->generatePassword();
    $CPModule->createAccount( $this, $serviceDBO, $domainName, $username, $password );

    return $password;
  }

  /**
   * Kill Account
   *
   * Terminate a control panel account on the server
   *
   * @param string $username The user ID of the account to be killed
   */
  public function killAccount( $username )
  {
    if( !isset( $this->CPModule ) )
      {
	throw new SWUserException( "[THERE_IS_NO_CONTROL_PANEL_MODULE_CONFIGURED_FOR_THIS_SERVER]" );
      }

    $CPModule = ModuleRegistry::getModuleRegistry()->getModule( $this->getCPModule() );
    $CPModule->killAccount( $this, $username );
  }

  /**
   * Suspend Account
   *
   * Suspend a control panel account on the server
   *
   * @param string $username The user ID of the account to be suspended
   */
  public function suspendAccount( $username )
  {
    if( !isset( $this->CPModule ) )
      {
	throw new SWUserException( "[THERE_IS_NO_CONTROL_PANEL_MODULE_CONFIGURED_FOR_THIS_SERVER]" );
      }

    $CPModule = ModuleRegistry::getModuleRegistry()->getModule( $this->getCPModule() );
    $CPModule->suspendAccount( $this, $username );
  }

  /**
   * Un-suspend Account
   *
   * Un-suspend a control panel account on the server
   *
   * @param string $username The user ID of the account to be un-suspended
   */
  public function unsuspendAccount( $username )
  {
    if( !isset( $this->CPModule ) )
      {
	throw new SWUserException( "[THERE_IS_NO_CONTROL_PANEL_MODULE_CONFIGURED_FOR_THIS_SERVER]" );
      }

    $CPModule = ModuleRegistry::getModuleRegistry()->getModule( $this->getCPModule() );
    $CPModule->unsuspendAccount( $this, $username );
  }
}

/**
 * Insert ServerDBO into database
 *
 * @param ServerDBO &$dbo ServerDBO to add to database
 */
function add_ServerDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "server",
				array( "hostname" => $dbo->getHostName(),
				       "location" => $dbo->getLocation(),
				       "cpmodule" => $dbo->getCPModule() ) );

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
 * Update ServerDBO in database
 *
 * @param ServerDBO &$dbo ServerDBO to update
 */
function update_ServerDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "server",
				"id = " . $dbo->getID(),
				array( "hostname" => $dbo->getHostName(),
				       "location" => $dbo->getLocation(),
				       "cpmodule" => $dbo->getCPModule() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete ServerDBO from database
 *
 * @param ServerDBO &$dbo ServerDBO to delete
 * @return boolean True on success
 */
function delete_ServerDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  if( $dbo->getPurchases() != null )
    {
      // Can not delete Server until all purchases are removed
      throw new DBException( "[SERVER_NOT_FREE]" );
    }

  // Delete all IP Addresses
  if( ($ip_dbo_array = $dbo->getIPAddresses() ) != null )
    {
      foreach( $ip_dbo_array as $ip_dbo )
	{
	  delete_IPAddressDBO( $ip_dbo );
	}
    }

  // Build DELETE query
  $sql = $DB->build_delete_sql( "server",
				"id = " . $dbo->getID() );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a ServerDBO from the database
 *
 * @param integer Server ID
 * @return ServerDBO ServerDBO, or null if not found
 */
function load_ServerDBO( $id )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = "SELECT COUNT(*) FROM server";

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