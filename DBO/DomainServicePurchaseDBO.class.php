<?php
/**
 * DomainServicePurchaseDBO.class.php
 *
 * This file contains the definition for the DomainServicePurchaseDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once BASE_PATH . "DBO/PurchaseDBO.class.php";

require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";
require_once BASE_PATH . "DBO/AccountDBO.class.php";

/**
 * DomainServicePurchaseDBO
 *
 * Represents a domain name registration.  For each domain name registration
 * purchased by an account, a DomainServicePurchaseDBO is created.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServicePurchaseDBO extends PurchaseDBO
{
  /**
   * @var integer DomainServicePurchase ID
   */
  var $id;

  /**
   * @var integer Account ID
   */
  var $accountid;

  /**
   * @var AccountDBO Account that purchased this domain registration
   */
  var $accountdbo;

  /**
   * @var string TLD
   */
  var $tld;

  /**
   * @var DomainServiceDBO Domain registration service purchased
   */
  var $domainservicedbo;

  /**
   * @var string Domain name (minus tld)
   */
  var $domainname;

  /**
   * @var string Expiration date (MySQL DATETIME)
   */
  var $expiredate;

  /**
   * Convert to a String
   *
   * @return string The Domain Service Purchase ID
   */
  function __toString() { return $this->getID(); }

  /**
   * Set DomainServicePurchase ID
   *
   * @var integer $id DomainServicePurchase ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get DomainServicePurchase ID
   *
   * @return integer DomainServicePurchase ID
   */
  function getID() { return $this->id; }

  /**
   * Set Account ID
   *
   * @var integer $id Account ID
   */
  function setAccountID( $id )
  {
    $this->accountid = $id;
    if( ($this->accountdbo = load_AccountDBO( $id )) == null )
      {
	fatal_error( "DomainServicePurchaseDBO::setAccountID()",
		     "could not load AccountDBO for DomainServicePurchaseDBO, id = " . $id );
      }
  }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  function getAccountID() { return $this->accountid; }

  /**
   * Get Account Name
   *
   * @return string Account Name
   */
  function getAccountName() { return $this->accountdbo->getAccountName(); }

  /**
   * Set Top Level Domain
   *
   * @param string $tld Top Level Domain that this domain is being registered under
   */
  function setTLD( $tld )
  {
    $this->tld = $tld;
    if( ($this->domainservicedbo = load_DomainServiceDBO( $tld )) == null )
      {
	fatal_error( "DomainServicePurchaseDBO::setTLD()",
		     "could not load DomainServiceDBO for DomainServicePurchaseDBO, tld = " .$tld );
      }
  }

  /**
   * Get Top Level Domain
   *
   * @return string Top Level Domain
   */
  function getTLD() { return $this->tld; }

  /**
   * Set Registration Term
   *
   * @param string $term Registration term ("1 year", "2 year" ... "10 year")
   */
  function setTerm( $term )
  {
    if( $term != "1 year" &&
	$term != "2 year" &&
	$term != "3 year" &&
	$term != "4 year" &&
	$term != "5 year" &&
	$term != "6 year" &&
	$term != "7 year" &&
	$term != "8 year" &&
	$term != "9 year" &&
	$term != "10 year" )
      {
	echo "Invalid term: " . $term;
	exit();
      }
    parent::setTerm( $term );
    $this->generateExpireDate();
  }

  /**
   * Set Domain Name
   *
   * @param string $domainname Domain name without TLD
   */
  function setDomainName( $domainname ) { $this->domainname = $domainname; }

  /**
   * Get Domain Name
   *
   * @return string Domain name without TLD
   */
  function getDomainName() { return $this->domainname; }

  /**
   * Get Full Domain Name
   *
   * @return string Full domain name (with TLD)
   */
  function getFullDomainName() { return $this->domainname . "." . $this->tld; }

  /**
   * Set Registration Date
   *
   * Sets the purchase date and calculates the expiration date at the same time
   *
   * @param string $date Registration date (MySQL DATETIME)
   */
  function setDate( $date ) 
  { 
    parent::setDate( $date );
    $this->generateExpireDate();
  }

  /**
   * Generate Expiration Date
   *
   * Takes the registration date, and adds the registration terms to come up with
   * the expiration date.  The expiration date can then be accessed with
   * getExpireDate().
   */
  function generateExpireDate()
  {
    global $DB;

    // Break up the registration date
    $start_date = getdate( $DB->datetime_to_unix( $this->getDate() ) );

    // Add term-years to start date
    $expire_date = mktime( $start_date['hours'], 
			   $start_date['minutes'], 
			   $start_date['seconds'], 
			   $start_date['mon'], 
			   $start_date['mday'], 
			   $start_date['year'] + $this->getTermInt() );

    // Convert back to a datetime
    $this->setExpireDate( $DB->format_datetime( $expire_date ) );
  }

  /**
   * Get Expiration Date
   *
   * @return string Expiration date (MySQL DATETIME)
   */
  function getExpireDate()
  {
    return $this->expiredate;
  }

  /**
   * Set Expiration Date
   *
   * Sets the expiration date.  In most cases you would not want to call this
   * function explicitly to set the expiration date.  Instead, set the registration
   * term, then set the registration date and the correct expiration date will be
   * set for you.
   *
   * @param string $expiredate Expiration date
   */
  function setExpireDate( $expiredate )
  {
    $this->expiredate = $expiredate;
  }

  /**
   * Get Price
   *
   * According to the registration term, retrieves the price of this domain
   * service.
   *
   * @return double Price
   */
  function getPrice()
  {
    switch( $this->getTerm() )
      {
      case "1 year": return $this->domainservicedbo->getPrice1yr(); break;
      case "2 year": return $this->domainservicedbo->getPrice2yr(); break;
      case "3 year": return $this->domainservicedbo->getPrice3yr(); break;
      case "4 year": return $this->domainservicedbo->getPrice4yr(); break;
      case "5 year": return $this->domainservicedbo->getPrice5yr(); break;
      case "6 year": return $this->domainservicedbo->getPrice6yr(); break;
      case "7 year": return $this->domainservicedbo->getPrice7yr(); break;
      case "8 year": return $this->domainservicedbo->getPrice8yr(); break;
      case "9 year": return $this->domainservicedbo->getPrice9yr(); break;
      case "10 year": return $this->domainservicedbo->getPrice10yr(); break;

      default: 
	return 0; 
	break;
      }
  }

  /**
   * Get Registration Term as Number of Years
   *
   * @return integer Registration term (years)
   */
  function getTermInt()
  {
    switch( $this->getTerm() )
      {
      case "1 year": return 1; break;
      case "2 year": return 2; break;
      case "3 year": return 3; break;
      case "4 year": return 4; break;
      case "5 year": return 5; break;
      case "6 year": return 6; break;
      case "7 year": return 7; break;
      case "8 year": return 8; break;
      case "9 year": return 9; break;
      case "10 year": return 10; break;
      }
  }

  /**
   * Is Taxable
   *
   * @return boolean True if this purchase is taxable
   */
  function isTaxable() { return $this->domainservicedbo->getTaxable() == "Yes"; }

  /**
   * Get Module Name
   *
   * @return string Name of module that registered this domain name
   */
  function getModuleName() { return $this->domainservicedbo->getModuleName(); }

  /**
   * Get Domain Service Title
   *
   * @return string FQDN
   */
  function getTitle() { return $this->getFullDomainName(); }

  /**
   * Domain Service's do not automatically recur
   *
   * @return boolean Always false
   */
  function isRecurring() { return false; }

  /**
   * Is Expired
   *
   * @return boolean True if this domain is expired
   */
  public function isExpired()
  {
    global $DB;
    return $DB->datetime_to_unix( $this->getExpireDate() ) > time();
  }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setAccountID( $data['accountid'] );
    $this->setTLD( $data['tld'] );
    $this->setTerm( $data['term'] );
    $this->setDomainName( $data['domainname'] );
    $this->setDate( $data['date'] );
    $this->setExpireDate( $data['expiredate'] );
  }
}

/**
 * Insert DomainServicePurchaseDBO into database
 *
 * @param DomainServicePurchaseDBO &$dbo DomainServicePurchaseDBO to add to database
 * @return boolean True on success
 */
function add_DomainServicePurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "domainservicepurchase",
				array( "accountid" => intval( $dbo->getAccountID() ),
				       "tld" => $dbo->getTLD(),
				       "term" => $dbo->getTerm(),
				       "domainname" => $dbo->getDomainName(),
				       "date" => $dbo->getDate(),
				       "expiredate" => $dbo->getExpireDate(),
				       "accountname" => $dbo->getAccountName() ) );

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
      fatal_error( "add_DomainServicePurchaseDBO",
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_DomainServicePurchaseDBO()",
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update DomainServicePurchaseDBO in database
 *
 * @param DomainServicePurchaseDBO &$dbo DomainServicePurchaseDBO to update
 * @return boolean True on success
 */
function update_DomainServicePurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "domainservicepurchase",
				"id = " . intval( $dbo->getID() ),
				array( "term" => $dbo->getTerm(),
				       "domainname" => $dbo->getDomainName(),
				       "date" => $dbo->getDate(),
				       "expiredate" => $dbo->getExpireDate(),
				       "accountname" => $dbo->getAccountName() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete DomainServicePurchaseDBO from database
 *
 * @param DomainServicePurchaseDBO &$dbo DomainServicePurchaseDBO to delete
 * @return boolean True on success
 */
function delete_DomainServicePurchaseDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "domainservicepurchase",
				"id = " . $dbo->getID() );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a DomainServicePurchaseDBO from the database
 *
 * @param integer DomainServicePurchase ID
 * @return DomainServicePurchaseDBO DomainServicePurchaseDBO, or null if not found
 */
function load_DomainServicePurchaseDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "domainservicepurchase",
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
      fatal_error( "load_DomainServicePurchaseDBO()",
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new HostingServiceDBO
  $dbo = new DomainServicePurchaseDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple DomainServicePurchaseDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of DomainServicePurchaseDBO's
 */
function &load_array_DomainServicePurchaseDBO( $filter = null,
					       $sortby = null,
					       $sortdir = null,
					       $limit = null,
					       $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "domainservicepurchase",
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
      fatal_error( "load_array_DomainServicePurchaseDBO()", "SELECT failure" );
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
      $dbo =& new DomainServicePurchaseDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count DomainServicePurchaseDBO's
 *
 * Same as load_array_DomainServicePurchaseDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of DomainServicePurchase records
 */
function count_all_DomainServicePurchaseDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "domainservicepurchase",
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
      fatal_error( "count_all_DomainServicePurchaseDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_DomainServicePurchaseDBO()", 
		   "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>