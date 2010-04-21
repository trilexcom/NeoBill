<?php
/**
 * HostingServicePriceDBO.class.php
 *
 * This file contains the definition for the HostingServicePriceDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * HostingServicePriceDBO
 *
 * Represents a single price for a hosting service.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingServicePriceDBO extends PriceDBO
{
  /**
   * @var integer The ID of the hosting service that this price applies to
   */
  protected $serviceID = null;

  /**
   * Get Concatenated ID
   *
   * @return string The concatenated ID of this price (serviceid-type-termlength)
   */
  public function getID()
  {
    return sprintf( "%d-%s-%d", 
		    $this->getServiceID(), 
		    $this->getType(), 
		    $this->getTermLength() );
  }

  /**
   * Get Hosting Service ID
   *
   * @return integer Hosting service ID
   */
  public function getServiceID() { return $this->serviceID; }

  /**
   * Set Hosting Service ID
   *
   * @param integer $serviceID The ID of the hosting service that this price applies to
   */
  public function setServiceID( $serviceID ) { $this->serviceID = $serviceID; }
}

/**
 * Insert HostingServicePriceDBO into database
 *
 * @param HostingServicePriceDBO &$dbo HostingServicePriceDBO to add to database
 * @return boolean True on success
 */
function add_HostingServicePriceDBO( HostingServicePriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "hostingserviceprice",
				array( "serviceid" => $dbo->getServiceID(),
				       "type" => $dbo->getType(),
				       "termlength" => $dbo->getTermLength(),
				       "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }

  // Success!
  return true;
}

/**
 * Update HostingServicePriceDBO in database
 *
 * @param HostingServicePriceDBO $dbo HostingServicePriceDBO to update
 * @return boolean True on success
 */
function update_HostingServicePriceDBO( HostingServicePriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "hostingserviceprice",
				sprintf( "serviceid=%d AND type='%s' AND termlength=%d",
					 $dbo->getServiceID(),
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
 * Delete HostingServicePriceDBO from database
 *
 * @param HostingServicePriceDBO $dbo HostingServicePriceDBO to delete
 */
function delete_HostingServicePriceDBO( HostingServicePriceDBO $dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build DELETE query
  $sql = $DB->build_delete_sql( "hostingserviceprice",
				sprintf( "serviceid=%d AND type='%s' AND termlength=%d",
					 $dbo->getServiceID(),
					 $dbo->getType(),
					 $dbo->getTermLength() ) );
  
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a HostingServicePriceDBO from the database
 *
 * @param integer Hosting Service ID
 * @param string Payment type
 * @param integer Term length
 * @return HostingServicePriceDBO HostingServicePriceDBO, or null if not found
 */
function load_HostingServicePriceDBO( $serviceID, $type, $termLength )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "hostingserviceprice",
				"*",
				sprintf( "serviceid=%d AND type='%s' AND termlength=%d",
					 $serviceID,
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

  // Load a new HostingServicePriceDBO
  $dbo = new HostingServicePriceDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple HostingServicePriceDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of HostingServiceDBO's
 */
function load_array_HostingServicePriceDBO( $filter = null,
					    $sortby = null,
					    $sortdir = null,
					    $limit = null,
					    $start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "hostingserviceprice",
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

  // Build an array of HostingServicePriceDBOs from the result set
  $price_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new HostingServiceDBO with the data from the DB
      $dbo = new HostingServicePriceDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $price_dbo_array[] = $dbo;
    }

  return $price_dbo_array;
}
?>