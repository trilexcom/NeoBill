<?php
/**
 * AddOnPriceDBO.class.php
 *
 * This file contains the definition for the AddOnPriceDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * AddOnPriceDBO
 *
 * Represents a single price for a addon
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddOnPriceDBO extends PriceDBO
{
  /**
   * @var integer The ID of the addon this price belongs to
   */
  protected $addonid = null;

  /**
   * Get Concatenated ID
   *
   * @return string The concatenated ID of this price (id-type-termlength)
   */
  public function getID()
  {
    return sprintf( "%d-%s-%d", 
		    $this->getAddOnID(), 
		    $this->getType(), 
		    $this->getTermLength() );
  }

  /**
   * Get AddOn ID
   *
   * @return integer AddOn ID
   */
  public function getAddOnID() { return $this->addonid; }

  /**
   * Set AddOn ID
   *
   * @param integer The ID of the addon that this price is for
   */
  public function setAddOnID( $id ) { $this->addonid = $id; }
}

/**
 * Insert AddOnPriceDBO into database
 *
 * @param AddOnPriceDBO &$dbo AddOnPriceDBO to add to database
 * @return boolean True on success
 */
function add_AddOnPriceDBO( AddOnPriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "addonprice",
				array( "addonid" => $dbo->getAddOnID(),
				       "type" => $dbo->getType(),
				       "termlength" => $dbo->getTermLength(),
				       "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Update AddOnPriceDBO in database
 *
 * @param AddOnPriceDBO $dbo AddOnPriceDBO to update
 * @return boolean True on success
 */
function update_AddOnPriceDBO( AddOnPriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "addonprice",
				sprintf( "addonid=%d AND type='%s' AND termlength=%d",
					 $dbo->getAddOnID(),
					 $dbo->getType(),
					 $dbo->getTermLength() ),
				array( "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete AddOnPriceDBO from database
 *
 * @param AddOnPriceDBO $dbo AddOnPriceDBO to delete
 */
function delete_AddOnPriceDBO( AddOnPriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build DELETE query
  $sql = $DB->build_delete_sql( "addonprice",
				sprintf( "addonid=%d AND type='%s' AND termlength=%d",
					 $dbo->getAddOnID(),
					 $dbo->getType(),
					 $dbo->getTermLength() ) );
  
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a AddOnPriceDBO from the database
 *
 * @param integer AddOn ID
 * @param string Payment type
 * @param integer Term length
 * @return AddOnPriceDBO AddOnPriceDBO, or null if not found
 */
function load_AddOnPriceDBO( $addonid, $type, $termLength )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "addonprice",
				"*",
				sprintf( "addonid=%d AND type='%s' AND termlength=%d",
					 $addonid,
					 $type,
					 $termLength ),
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

  // Load a new AddOnPriceDBO
  $dbo = new AddOnPriceDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple AddOnPriceDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of AddOnDBO's
 */
function load_array_AddOnPriceDBO( $filter = null,
				     $sortby = null,
				     $sortdir = null,
				     $limit = null,
				     $start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "addonprice",
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

  // Build an array of AddOnPriceDBOs from the result set
  $price_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new AddOnDBO with the data from the DB
      $dbo =& new AddOnPriceDBO();
      $dbo->load( $data );

      // Add AddOnDBO to array
      $price_dbo_array[] = $dbo;
    }

  return $price_dbo_array;
}
?>