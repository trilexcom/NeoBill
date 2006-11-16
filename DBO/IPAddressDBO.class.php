<?php
/**
 * IPAddressDBO.class.php
 *
 * This file contains the definition for the IPAddressDBO class.
 * 
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * IPAddressDBO
 *
 * Represents a single IP Address in the address pool
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IPAddressDBO extends DBO
{
  /**
   * @var integer IP Address (32-bit integer form)
   */
  var $ip;

  /**
   * @var integer Server ID - the server that owns this IP
   */
  var $serverid;

  /**
   * @var ServerDBO The server that owns this IP
   */
  var $serverdbo;

  /**
   * @var integer HostingServicePurchase ID
   */
  var $purchaseid;

  /**
   * @var HostingServicePurchaseDBO The hosting service purchase that this IP address is assigned to
   */
  var $purchasedbo;

  /**
   * Convert to a String
   *
   * @return string IP String
   */
  function __toString() { return $this->getIPString(); }

  /**
   * Set IP
   *
   * @param integer $ip IP Address (32-bit integer form)
   */
  function setIP( $ip )
  {
    $this->ip = $ip;
  }

  /**
   * Get IP
   *
   * @return integer IP Address (32-bit integer form)
   */
  function getIP()
  {
    return $this->ip;
  }

  /**
   * Set IP Address String
   *
   * Takes the IP address as a dotted-quad
   *
   * @param string $id IP Address (dotted-quad, i.e.: 192.168.0.1)
   */
  function setIPString( $ip )
  {
    // Convert from dotted-quad to long integer
    $long_ip = ip2long( $ip );
    if( $long_ip === false )
      {
	$this->ip = 0;
      }
    else
      {
	$this->ip = $long_ip;
      }
  }

  /**
   * Get IP Address String
   *
   * Returns the IP Address as a dotted-quad
   *
   * @return string IP Address (dotted-quad, i.e.: "192.168.0.1")
   */
  function getIPString()
  {
    return long2ip( $this->ip );
  }

  /**
   * Set Server ID
   *
   * Set the Server that owns this IP address
   *
   * @param integer $id Server ID
   */
  function setServerID( $id ) 
  {
    if( ($this->serverdbo = load_ServerDBO( $id )) == null )
      {
	fatal_error( "IPAddressDBO::setServerID()",
		     "error, could not load ServerDBO for server id = " . $id );
      }
    $this->serverid = $id; 
  }

  /**
   * Get Server ID
   *
   * Returns the ID of the Server that owns this IP address
   *
   * @return integer Server ID
   */
  function getServerID() { return $this->serverid; }

  /**
   * Set Purchase ID
   *
   * Assign this IP Address to a hosting service purchase
   *
   * @param integer $id HostingServicePurchaseID
   */
  function setPurchaseID( $id )
  {
    $id = intval( $id );
    if( $id < 1 )
      {
	// Not assigned to a purchase
	unset( $this->purchaseid );
	unset( $this->purchasedbo );
	return;
      }

    // Load HostingServicePurchaseDBO
    if( ($this->purchasedbo = load_HostingServicePurchaseDBO( $id )) == null )
      {
	fatal_error( "IPAddressDBO::setPurchaseID()",
		     "error, could not load HostingServicePurchase. id = " . $id );
      }
    $this->purchaseid = $id;
  }

  /**
   * Get Purchase ID
   *
   * @return integer HostingServicePurchase ID
   */
  function getPurchaseID() { return $this->purchaseid; }

  /**
   * Get Account Name
   *
   * Returns the name of the Account this IP address is assigned to, 
   * or "Available" if not assigned
   *
   * @return string Account name
   */
  function getAccountName() 
  { 
    if( !isset( $this->purchasedbo ) )
      {
	// This IP is available
	return "Available";
      }

    return $this->purchasedbo->getAccountName();
  }

  /**
   * Get Account ID
   *
   * Returns the ID of the Account this IP address is assigned to, 
   * or 0 if not assigned
   *
   * @return string Account name
   */
  function getAccountID() 
  { 
    if( !isset( $this->purchaseid ) )
      {
	// This IP is available
	return 0;
      }
    return $this->purchasedbo->getAccountID();
  }

  /**
   * Get Hostname
   *
   * Returns the hostname of the Server that owns this IP address
   *
   * @return string Hostname
   */
  function getHostName() { return $this->serverdbo->getHostName(); }

  /**
   * Get Hostname and IP
   *
   * Returns the hostname of the server and the IP address 
   * like so: 10.0.0.1 (host.name.com)
   *
   * @return string Hostname and IP address
   */
  function getHostNameIP()
  {
    return $this->getIPString() . " (" . $this->serverdbo->getHostName() . ")";
  }

  /**
   * Get Service Title
   *
   * Returns the title of the Hosting Service this IP address is assigned to, 
   * or "n/a" if it is avaialable.
   *
   * @return string Service name
   */
  function getServiceTitle()
  {
    if( !isset( $this->purchasedbo ) )
      {
	return "n/a";
      }
    return $this->purchasedbo->getTitle();
  }

  /**
   * Is Available?
   *
   * Returns true if this IP address is available (if there's not purchase DBO)
   *
   * @return boolean True if IP is not in use
   */
  function isAvailable() { return $this->purchasedbo == null; }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setIP( $data['ipaddress'] );
    $this->setServerID( $data['serverid'] );
    $this->setPurchaseID( $data['purchaseid'] );
  }
}

/**
 * Insert IPAddressDBO into database
 *
 * @param IPAddressDBO &$dbo IPAddressDBO to add to database
 * @return boolean True on success
 */
function add_IPAddressDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "ipaddress",
				array( "ipaddress" => intval( $dbo->getIP() ),
				       "serverid" => intval( $dbo->getServerID() ),
				       "purchaseid" => intval( $dbo->getPurchaseID() ) ) );

  // Run Query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Update IPAddressDBO in database
 *
 * @param IPAddressDBO &$dbo IPAddressDBO to update
 * @return boolean True on success
 */
function update_IPAddressDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "ipaddress",
				"ipaddress = " . intval( $dbo->getIP() ),
				array( "serverid" => intval( $dbo->getServerID() ),
				       "purchaseid" => intval( $dbo->getPurchaseID() ) ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete IPAddressDBO from database
 *
 * @param IPAddressDBO &$dbo IPAddressDBO to delete
 * @return boolean True on success
 */
function delete_IPAddressDBO( &$dbo )
{
  global $DB;

  if( !$dbo->isAvailable() )
    {
      // Can not remove an IP Address when it is assigned to a service
      return false;
    }

  // Build SQL
  $sql = $DB->build_delete_sql( "ipaddress",
				"ipaddress = " . intval( $dbo->getIP() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load IPAddress from Database
 *
 * @param integer $ip IP Address (32-bit integer form)
 * @return IPAddressDBO IP Address if found, null if not found
 */
function load_IPAddressDBO( $ip )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "ipaddress",
				"*",
				"ipaddress=" . intval( $ip ),
				null,
				null,
				null,
				null );

  // Run query
  if( !($result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatal_error( "load_IPAddressDBO()", "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new IPAddressDBO
  $dbo = new IPAddressDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple IPAddressDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of InvoiceDBO's
 */
function &load_array_IPAddressDBO( $filter = null,
				   $sortby = null,
				   $sortdir = null,
				   $limit = null,
				   $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "ipaddress",
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
      fatal_error( "load_array_IPAddressDBO()", "SELECT failure" );
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
      $dbo =& new IPAddressDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count IPAddressDBO's
 *
 * Same as load_array_IPAddressDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of Invoice records
 */
function count_all_IPAddressDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "ipaddress",
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
      fatal_error( "count_all_IPAddressDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_IPAddressDBO()", "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>