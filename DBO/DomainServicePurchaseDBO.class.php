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
  protected $id;

  /**
   * @var string TLD
   */
  protected $tld;

  /**
   * @var DomainServiceDBO Domain registration service purchased
   */
  protected $domainservicedbo;

  /**
   * @var string Domain name (minus tld)
   */
  protected $domainname;

  /**
   * @var string Expiration date (MySQL DATETIME)
   */
  protected $expiredate;

  /**
   * @var string Domain secret (For transfer purchases)
   */
  protected $secret;

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
   * Set Top Level Domain
   *
   * @param string $tld Top Level Domain that this domain is being registered under
   */
  function setTLD( $tld )
  {
    $this->setPurchasable( load_DomainServiceDBO( $tld ) );
  }

  /**
   * Get Top Level Domain
   *
   * @return string Top Level Domain
   */
  function getTLD() { return $this->purchasable->getTLD(); }

  /**
   * Set Purchasable
   *
   * @param DomainServiceDBO The domain service that is/was purchased
   */
  public function setPurchasable( DomainServiceDBO $serviceDBO )
  {
    // This function is meant to force purchasable to be a DomainServiceDBO
    parent::setPurchasable( $serviceDBO );
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
  function getFullDomainName() { return $this->domainname . "." . $this->getTLD(); }

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
    // Break up the registration date
    $start_date = getdate( DBConnection::datetime_to_unix( $this->getDate() ) );

    // Add term-years to start date
    $expire_date = mktime( $start_date['hours'], 
			   $start_date['minutes'], 
			   $start_date['seconds'], 
			   $start_date['mon'], 
			   $start_date['mday'], 
			   $start_date['year'] + ($this->getTerm() / 12) );

    // Convert back to a datetime
    $this->setExpireDate( DBConnection::format_datetime( $expire_date ) );
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
   * Get Module Name
   *
   * @return string Name of module that registered this domain name
   */
  function getModuleName() { return $this->purchasable->getModuleName(); }

  /**
   * Get Domain Service Title
   *
   * @return string FQDN
   */
  function getTitle() { return "[DOMAIN_REGISTRATION]: " . $this->getFullDomainName(); }

  /**
   * Set Domain Secret (for transfer purchases)
   *
   * @param string $secret Domain secret
   */
  public function setSecret( $secret ) { $this->secret = $secret; }

  /**
   * Get Domain Secret (for transfer purchases)
   *
   * @return string Domain secret
   */
  public function getSecret() { return $this->secret; }

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
    return DBConnection::datetime_to_unix( $this->getExpireDate() ) > time();
  }

  /**
   * Get Description for "Recurring" Line Item
   *
   * @return string The text that should appear on the invoice for this purchase
   */
  public function getLineItemTextRecurring()
  {
    $term = intval( $this->getTerm() / 12 );
    return sprintf( "%s ([TERM]: %d %s, [EXPIRES] %s)", 
		    $this->getTitle(),
		    $term,
		    $term > 1 ? "[YEARS]" : "[YEAR]",
		    date( "m/d/y", DBConnection::datetime_to_unix( $this->getExpireDate() ) ) );
			      
  }
}

/**
 * Insert DomainServicePurchaseDBO into database
 *
 * @param DomainServicePurchaseDBO &$dbo DomainServicePurchaseDBO to add to database
 */
function add_DomainServicePurchaseDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "domainservicepurchase",
				array( "accountid" => intval( $dbo->getAccountID() ),
				       "tld" => $dbo->getTLD(),
				       "term" => $dbo->getTerm(),
				       "domainname" => $dbo->getDomainName(),
				       "date" => $dbo->getDate(),
				       "expiredate" => $dbo->getExpireDate(),
				       "secret" => $dbo->getSecret(),
				       "nextbillingdate" => $dbo->getNextBillingDate(),
				       "previnvoiceid" => $dbo->getPrevInvoiceID(),
				       "note" => $dbo->getNote() ) );

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
      throw new DBException();
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
 * Update DomainServicePurchaseDBO in database
 *
 * @param DomainServicePurchaseDBO &$dbo DomainServicePurchaseDBO to update
 * @return boolean True on success
 */
function update_DomainServicePurchaseDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "domainservicepurchase",
				"id = " . intval( $dbo->getID() ),
				array( "term" => $dbo->getTerm(),
				       "domainname" => $dbo->getDomainName(),
				       "date" => $dbo->getDate(),
				       "expiredate" => $dbo->getExpireDate(),
				       "secret" => $dbo->getSecret(),
				       "nextbillingdate" => $dbo->getNextBillingDate(),
				       "previnvoiceid" => $dbo->getPrevInvoiceID(),
				       "note" => $dbo->getNote() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete DomainServicePurchaseDBO from database
 *
 * @param DomainServicePurchaseDBO &$dbo DomainServicePurchaseDBO to delete
 * @return boolean True on success
 */
function delete_DomainServicePurchaseDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_delete_sql( "domainservicepurchase",
				"id = " . $dbo->getID() );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a DomainServicePurchaseDBO from the database
 *
 * @param integer DomainServicePurchase ID
 * @return DomainServicePurchaseDBO DomainServicePurchaseDBO, or null if not found
 */
function load_DomainServicePurchaseDBO( $id )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      throw new DBNoRowsFoundException();
    }

  // Build an array of DBOs from the result set
  $dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DBO with the data from the DB
      $dbo = new DomainServicePurchaseDBO();
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
  $DB = DBConnection::getDBConnection();
  
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