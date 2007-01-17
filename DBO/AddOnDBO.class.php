<?php
/**
 * AddOnDBO.class.php
 *
 * This file contains the definition for the AddOn Database Object class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * AddOnDBO
 *
 * Represents a product or service that supplements another product or service
 *
 * @pacakge DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddOnDBO extends PurchasableDBO
{
  /**
   * @var string Add-On description
   */
  protected $description;

  /**
   * @var integer Add-On ID
   */
  protected $id;

  /**
   * @var string Add-On name
   */
  protected $name;

  /**
   * Convert to a String
   *
   * @return string Add-On ID
   */
  public function __toString() { return $this->getID(); }

  /**
   * Get Add-On Description
   *
   * @return string Add-On description
   */
  public function getDescription() { return $this->description; }

  /**
   * Get Add-On ID
   *
   * @return integer Product ID
   */
  public function getID() { return $this->id; }

  /**
   * Get Add-On Name
   *
   * @return string Product name
   */
  public function getName() { return $this->name; }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  public function load( $data )
  {
    // Load the record data
    parent::load( $data );

    // Load pricing
    try { $this->prices = load_array_AddOnPriceDBO( "addonid=" . $this->getID() ); }
    catch( DBNoRowsFoundException $e ) { $this->prices = array(); }
  }

  /**
   * Set Add-On Description
   *
   * @var string $description Add-On description
   */
  public function setDescription( $description ) { $this->description = $description; }

  /**
   * Set Add-On ID
   *
   * @param integer $id Product ID
   */
  public function setID( $id ) { $this->id = $id; }

  /**
   * Set Add-On Name
   *
   * @param string $name Product name
   */
  public function setName( $name ) { $this->name = $name; }
}

/**
 * Add AddOnDBO to Database
 *
 * @param AddOnDBO &$dbo AddOnDBO to be added to database
 * @return boolean True on success
 */
function add_AddOnDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "addon",
				array( "name" => $dbo->getName(),
				       "description" => $dbo->getDescription(),
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
}

/**
 * Update AddOnDBO
 *
 * @param AddOnDBO &$dbo AddOnDBO to be updated
 * @return boolean True on success
 */
function update_AddOnDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "addon",
				"id = " . intval( $dbo->getID() ),
				array( "name" => $dbo->getName(),
				       "description" => $dbo->getDescription(),
				       "public" => $dbo->getPublic() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete AddOnDBO
 *
 * @param AddOnDBO &$dbo AddOnDBO to be deleted
 * @return boolean True on success
 */
function delete_AddOnDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_delete_sql( "addon",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load AddOnDBO from Database
 *
 * @param integer $id AddOn ID
 * @return AddOnDBO AddOn, or null if not found
 */
function load_AddOnDBO( $id )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "addon",
				"*",
				"id = " . intval( $id ),
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
  $dbo = new AddOnDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple AddOnDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of ProdutDBO's
 */
function &load_array_AddOnDBO( $filter = null,
			       $sortby = null,
			       $sortdir = null,
			       $limit = null,
			       $start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "addon",
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
      $dbo =& new AddOnDBO();
      $dbo->load( $data );

      // Add DomainServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}
?>