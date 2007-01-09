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

/**
 * HostingServiceDBO
 * 
 * Represents a web hosting service offered by the provider.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingServiceDBO extends PurchasableDBO
{
  /** 
   * @var string Hosting service description
   */
  protected $description;

  /**
   * @var string Domain Requirement
   */
  protected $domainRequirement;

  /**
   * @var integer HostingService ID
   */
  protected $id;

  /**
   * @var string Hosting service title
   */
  protected $title;

  /**
   * @var string Unique IP Requirement
   */
  protected $uniqueip;

  /**
   * Convert to a String
   *
   * @return string Hosting service ID
   */
  public function __toString() { return $this->getID(); }

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
   * Set Domain Requirement
   *
   * @param string $required 'Required' or 'Not Required'
   */
  public function setDomainRequirement( $required )
  {
    if( !($required == "Required" || $required == "Not Required") )
      {
	throw new SWException( "Invalid setting for domain requirement: " . $required );
      }

    $this->domainRequirement = $required;
  }

  /**
   * Get Domain Required
   *
   * @return string Domain requirement ("Required" or "Not Required")
   */
  public function getDomainRequirement() { return $this->domainRequirement; }

  /**
   * Is Domain Required
   *
   * @return boolean True if a domain is required to purchase this service
   */
  public function isDomainRequired() { return $this->domainRequirement == "Required"; }

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
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  public function load( $data )
  {
    // Load the record data
    parent::load( $data );

    // Load service pricing
    try
      {
	$this->prices = load_array_HostingServicePriceDBO( "serviceid=" . $this->getID() );
      }
    catch( DBNoRowsFoundException $e )
      {
	$this->prices = array();
      }
  }
}

/**
 * Insert HostingServiceDBO into database
 *
 * @param HostingServiceDBO &$dbo HostingServiceDBO to add to database
 */
function add_HostingServiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "hostingservice",
				array( "title" => $dbo->getTitle(),
				       "description" => $dbo->getDescription(),
				       "uniqueip" => $dbo->getUniqueIP(),
				       "domainrequirement" => $dbo->getDomainRequirement(),
				       "public" => $dbo->getPublic() ) );

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

  // Add all the PriceDBO's for this object
  foreach( $dbo->getPricing() as $price )
    {
      add_HostingServicePriceDBO( $price );
    }
}

/**
 * Update HostingServiceDBO in database
 *
 * @param HostingServiceDBO &$dbo HostingServiceDBO to update
 * @return boolean True on success
 */
function update_HostingServiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "hostingservice",
				"id = " . $dbo->getID(),
				array( "title" => $dbo->getTitle(),
				       "description" => $dbo->getDescription(),
				       "uniqueip" => $dbo->getUniqueIP(),
				       "domainrequirement" => $dbo->getDomainRequirement(),
				       "public" => $dbo->getPublic() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete HostingServiceDBO from database
 *
 * @param HostingServiceDBO &$dbo HostingServiceDBO to delete
 * @return boolean True on success
 */
function delete_HostingServiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  $id = $dbo->getID();
  try
    {
      load_array_HostingServicePurchaseDBO( "hostingserviceid=" . $id );
      
      // Can not delete service if any purchases exist
      throw new DBException( "[PURCHASES_EXIST]" );
    }
  catch( DBNoRowsFoundException $e ) {}

  // Build DELETE query
  $sql = $DB->build_delete_sql( "hostingservice",
				"id = " . $dbo->getID() );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a HostingServiceDBO from the database
 *
 * @param integer $id HostingService ID
 * @return HostingServiceDBO HostingServiceDBO, or null if not found
 */
function load_HostingServiceDBO( $id )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = "SELECT COUNT(*) FROM hostingservice";

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
      throw new DBException( "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>