<?php
/**
 * HostingServicePurchaseDBO.class.php
 *
 * This file contains the definition for the HostingServicePurchaseDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "DBO/PurchaseDBO.class.php";

require_once $base_path . "DBO/AccountDBO.class.php";
require_once $base_path . "DBO/HostingServiceDBO.class.php";
require_once $base_path . "DBO/ServerDBO.class.php";

/**
 * HostingServicePurchaseDBO
 *
 * Represents a hosting service purchase by a customer.  Each time a customer is
 * assigned a hosting servic, a HostingServicePurchaseDBO is created.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingServicePurchaseDBO extends PurchaseDBO
{
  /**
   * @var integer HostingServicePurchase ID
   */
  var $id;

  /**
   * @var integer Account ID
   */
  var $accountid;

  /**
   * @var AccountDBO Account that purchased this hosting service
   */
  var $accountdbo;

  /**
   * @var integer Hosting service ID
   */
  var $hostingserviceid;

  /**
   * @var HostingServiceDBO Hosting service purchased
   */
  var $hostingservicedbo;

  /**
   * @var integer Server ID
   */
  var $serverid;

  /**
   * @var ServerDBO Server this hosting service purchase is assigned to
   */
  var $serverdbo;

  /**
   * Set Hosting Service Purchase ID
   *
   * @param integer $id Hosting service purchase ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Hosting Service Purchase ID
   *
   * @return integer Hosting service purchase ID
   */
  function getID() { return $this->id; }

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
	fatal_error( "HostingServicePurchaseDBO::setAccountID()",
		     "could not load AccountDBO for HostingServicePurchaseDBO, id = " . $id );
      }
  }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  function getAccountID() { return $this->accountid; }

  /**
   * Set Hosting Service ID
   *
   * @param integer $id Hosting Service ID
   */
  function setHostingServiceID( $id )
  {
    $this->hostingserviceid = $id;
    if( ($this->hostingservicedbo = load_HostingServiceDBO( $id )) == null )
      {
	fatal_error( "HostingServicePurchaseDBO::setHostingServiceID()",
		     "could not load HostingServiceDBO for HostingServicePurchaseDBO, id = " . $id );
      }
  }

  /**
   * Get Hosting Service ID
   *
   * @return integer Hosting service ID
   */
  function getHostingServiceID() { return $this->hostingserviceid; }

  /**
   * Set Server ID
   *
   * @param integer $id Server ID
   */
  function setServerID( $id )
  {
    $id = intval( $id );
    if( $id < 1 )
      {
	// Not assigned to a server
	$serverid = null;
	$serverdbo = null;
	return;
      }

    $this->serverid = $id;
    if( ($this->serverdbo = load_ServerDBO( $id )) == null )
      {
	fatal_error( "HostingServicePurchaseDBO::setServerID()",
		     "could not load ServerDBO for HostingServicePurchaseDBO, id = " . $id );
      }
  }

  /**
   * Get Server ID
   *
   * @return integer Server ID
   */
  function getServerID() { return $this->serverid; }

  /**
   * Get Server Hostname
   *
   * @return string Server hostname, or "Not Assigned" if there is no assigned server
   */
  function getHostName()
  {
    if( !isset( $this->serverdbo ) )
      {
	return "Not Assigned";
      }
    return $this->serverdbo->getHostName();
  }

  /**
   * Set Purchase Term
   *
   * @param string $term Purchase term ("1 month", "3 month", "6 month", "12 month")
   */
  function setTerm( $term )
  {
    if( $term != "1 month" &&
	$term != "3 month" && 
	$term != "6 month" &&
	$term != "12 month" )
      {
	fatal_error( "HostingServicePurchaseDBO::setTerm()",
		     "Invalid term: " . $term );
      }
    parent::setTerm( $term );
  }

  /**
   * Get Hosting Service Title
   *
   * @return string Hosting service title
   */
  function getTitle() { return $this->hostingservicedbo->getTitle(); }

  /**
   * Get Price
   *
   * @return double Price
   */
  function getPrice()
  {
    switch( $this->getTerm() )
      {

      case "1 month":
	return $this->hostingservicedbo->getPrice1mo();
	break;

      case "3 month":
	return $this->hostingservicedbo->getPrice3mo();
	break;

      case "6 month":
	return $this->hostingservicedbo->getPrice6mo();
	break;

      case "12 month":
	return $this->hostingservicedbo->getPrice12mo();
	break;

      default:
	return 0;
	break;

      }
  }

  /**
   * Get Setup Fee
   *
   * @return float Setup fee
   */
  function getSetupFee() 
  { 
    switch( $this->getTerm() )
      {
      case "1 month": return $this->hostingservicedbo->getSetupPrice1mo();
      case "3 month": return $this->hostingservicedbo->getSetupPrice3mo();
      case "6 month": return $this->hostingservicedbo->getSetupPrice6mo();
      case "12 month": return $this->hostingservicedbo->getSetupPrice12mo();
      default: return 0;
      }
  }

  /**
   * Is Taxable
   *
   * @return boolean True if this service is taxable
   */
  function isTaxable() { return $this->hostingservicedbo->getTaxable() == "Yes"; }

  /**
   * Get Account Name
   *
   * @return string Name of Account that this purchase belongs to
   */
  function getAccountName() { return $this->accountdbo->getAccountName(); }

  /**
   * Load member data from an array
   *
   * @param array $data Date to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setAccountID( $data['accountid'] );
    $this->setHostingServiceID( $data['hostingserviceid'] );
    $this->setServerID( $data['serverid'] );
    $this->setTerm( $data['term'] );
    $this->setDate( $data['date'] );
  }
}

/**
 * Insert HostingServicePurchaseDBO into database
 *
 * @param HostingServicePurchaseDBO &$dbo HostingServicePurchaseDBO to add to database
 * @return boolean True on success
 */
function add_HostingServicePurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "hostingservicepurchase",
				array( "accountid" => intval( $dbo->getAccountID() ),
				       "hostingserviceid" => intval( $dbo->getHostingServiceID() ),
				       "serverid" => intval( $dbo->getServerID() ),
				       "term" => $dbo->getTerm(),
				       "date" => $dbo->getDate() ) );

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
      fatal_error( "add_HostingServicePurchaseDBO()", 
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_HostingServicePurchaseDBO()",
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/** 
 * Update HostingServicePurchaseDBO in database
 *
 * @param HostingServicePurchaseDBO &$dbo HostingServicePurchaseDBO to update
 * @return boolean True on success
 */
function update_HostingServicePurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "hostingservicepurchase",
				"id = " . intval( $dbo->getID() ),
				array( "term" => $dbo->getTerm(),
                                       "serverid" => intval( $dbo->getServerID() ),
				       "date" => $dbo->getDate() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete HostingServicePurchaseDBO from database
 *
 * @param HostingServicePurchaseDBO &$dbo HostingServicePurchaseDBO to delete
 * @return True on success
 */
function delete_HostingServicePurchaseDBO( &$dbo )
{
  global $DB;

  // Release any IP Addresses assigned to this purchase
  if( ($ip_dbo_array = load_array_IPAddressDBO( "purchaseid = " . $dbo->getID() )) != null )
    {
      foreach( $ip_dbo_array as $ip_dbo )
	{
	  // Remove IP address from this purchase
	  $ip_dbo->setPurchaseID( 0 );
	  if( !update_IPAddressDBO( $ip_dbo ) )
	    {
	      // DB Error
	      return false;
	    }
	}
    }

  // Build DELETE query
  $sql = $DB->build_delete_sql( "hostingservicepurchase",
				"id = " . $dbo->getID() );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a HostingServicePurchaseDBO from the database
 *
 * @param integer HostingServicePurchase ID
 * @return HostingServicePurchaseDBO HostingServicePurchase, or null if not found
 */
function load_HostingServicePurchaseDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "hostingservicepurchase",
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
      fatal_error( "load_HostingServicePurchaseDBO()",
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new HostingServiceDBO
  $dbo = new HostingServicePurchaseDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple HostingServicePurchaseDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of HostingServicePurchaseDBO's
 */
function &load_array_HostingServicePurchaseDBO( $filter = null,
						$sortby = null,
						$sortdir = null,
						$limit = null,
						$start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "hostingservicepurchase",
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
      fatal_error( "load_array_HostingServicePurchaseDBO()",
		   "SELECT failure" );
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
      $dbo =& new HostingServicePurchaseDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count HostingServicePurchaseDBO's
 *
 * Same as load_array_HostingServicePurchaseDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of HostingServicePurchase records
 */
function count_all_HostingServicePurchaseDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "hostingservicepurchase",
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
      fatal_error( "count_all_HostingServicePurchaseDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_HostingServicePurchaseDBO()",
		   "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>