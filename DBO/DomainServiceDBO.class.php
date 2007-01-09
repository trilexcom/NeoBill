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

/**
 * DomainServiceDBO
 *
 * Represents a domain registration service.  Each Top Level Domain that the hosting
 * provider offers registration service for gets a DomainServiceDBO.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServiceDBO extends PurchasableDBO
{
  /**
   * @var string Top Level Domain
   */
  protected $tld;

  /**
   * @var string Name of the domain_registrar module that handles this TLD
   */
  protected $modulename;

  /**
   * @var string Service description
   */
  protected $description;

  /**
   * Convert to a String
   *
   * @return string The TLD this service is for
   */
  public function __toString() { return $this->getTLD(); }

  /**
   * Set Top Level Domain (key field)
   *
   * @param string $tld Top Level Domain
   */
  public function setTLD( $tld ) { $this->tld = $tld; }

  /**
   * Get Top Level Domain (key field)
   *
   * @return string Top Level Domain
   */
  public function getTLD() { return $this->tld; }

  /**
   * Get ID (same as get TLD)
   *
   * @return string Top Level Domain
   */
  public function getID() { return $this->getTLD(); }
  
  /**
   * Set Module Name
   *
   * @param string $module Module name
   */
  public function setModuleName( $modulename ) { $this->modulename = $modulename; }

  /**
   * Get Module Name
   *
   * @return string Module name
   */
  public function getModuleName() { return $this->modulename; }

  /**
   * Set Description
   *
   * @param string $description Description
   */
  public function setDescription( $description ) { $this->description = $description; }

  /**
   * Get Description
   *
   * @return string Description
   */
  public function getDescription() { return $this->description; }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  public function load( $data )
  {
    // Load the record date
    parent::load( $data );

    // Load service pricing
    try
      {
	$this->prices = load_array_DomainServicePriceDBO( sprintf( "tld='%s'", 
								   $this->getTLD() ) );
      }
    catch( DBNoRowsFoundException $e )
      {
	$this->prices = array();
      }
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
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "domainservice",
				array( "tld" => $dbo->getTLD(),
				       "modulename" => $dbo->getModuleName(),
				       "description" => $dbo->getDescription(),
				       "public" => $dbo->getPublic() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }

  // Add all the PriceDBO's for this object
  foreach( $dbo->getPricing() as $price )
    {
      add_DomainServicePriceDBO( $price );
    }

  return true;
}

/**
 * Update DomainServiceDBO in database
 *
 * @param DomainServiceDBO &$dbo DomainServiceDBO to update
 * @return boolean True on success
 */
function update_DomainServiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "domainservice",
				"tld = " . $DB->quote_smart( $dbo->getTLD() ),
				array( "modulename" => $dbo->getModuleName(),
				       "description" => $dbo->getDescription(),
				       "public" => $dbo->getPublic() ) );
				
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete DomainServiceDBO from database
 *
 * @param DomainServiceDBO &$dbo DomainServiceDBO to delete
 * @return boolean True on success
 */
function delete_DomainServiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Verify that no purchases exist
  try 
    { 
      load_array_DomainServicePurchaseDBO( "tld=" . $tld ); 
      
      // Can not delete domain service if any purchases exist
      throw new DBException( "[PURCHASES_EXIST]" );
    }
    catch( DBNoRowsFoundException $e ) {}

  // Build SQL
  $sql = $DB->build_delete_sql( "domainservice",
				"tld = " . $DB->quote_smart( $dbo->getTLD() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a DomainServiceDBO from the database
 *
 * @param string Top Level Domain
 * @return DomainServiceDBO DomainServiceDBO, or null if not found
 */
function load_DomainServiceDBO( $tld )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = "SELECT COUNT(*) FROM domainservice";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      throw new DBException();
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      throw new DBException();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}
?>
