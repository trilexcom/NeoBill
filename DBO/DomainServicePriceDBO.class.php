<?php
/**
 * DomainServicePriceDBO.class.php
 *
 * This file contains the definition for the DomainServicePriceDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DomainServicePriceDBO
 *
 * Represents a single price for a domain service.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServicePriceDBO extends PriceDBO
{
  /**
   * @var string The tld of the domain service that this price applies to
   */
  protected $tld = null;

  /**
   * Get Concatenated ID
   *
   * @return string The concatenated ID of this price (tld-type-termlength)
   */
  public function getID()
  {
    return sprintf( "%s-%s-%d", 
		    $this->getTLD(), 
		    $this->getType(), 
		    $this->getTermLength() );
  }

  /**
   * Get Domain TLD
   *
   * @return string Domain TLD
   */
  public function getTLD() { return $this->tld; }

  /**
   * Set Domain TLD
   *
   * @param string $tld The TLD of the domain service that this price applies to
   */
  public function setTLD( $tld ) { $this->tld = $tld; }
}

/**
 * Insert DomainServicePriceDBO into database
 *
 * @param DomainServicePriceDBO &$dbo DomainServicePriceDBO to add to database
 * @return boolean True on success
 */
function add_DomainServicePriceDBO( DomainServicePriceDBO $dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "domainserviceprice",
				array( "tld" => $dbo->getTLD(),
				       "type" => $dbo->getType(),
				       "termlength" => $dbo->getTermLength(),
				       "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      return false;
    }

  // Success!
  return true;
}

/**
 * Update DomainServicePriceDBO in database
 *
 * @param DomainServicePriceDBO $dbo DomainServicePriceDBO to update
 * @return boolean True on success
 */
function update_DomainServicePriceDBO( DomainServicePriceDBO $dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "domainserviceprice",
				sprintf( "tld='%s' AND type='%s' AND termlength=%d",
					 $dbo->getTLD(),
					 $dbo->getType(),
					 $dbo->getTermLength() ),
				array( "price" => $dbo->getPrice(),
				       "taxable" => $dbo->getTaxable() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete DomainServicePriceDBO from database
 *
 * @param DomainServicePriceDBO $dbo DomainServicePriceDBO to delete
 */
function delete_DomainServicePriceDBO( DomainServicePriceDBO $dbo )
{
  global $DB;

  // Build DELETE query
  $sql = $DB->build_delete_sql( "domainserviceprice",
				sprintf( "tld='%s' AND type='%s' AND termlength=%d",
					 $dbo->getTLD(),
					 $dbo->getType(),
					 $dbo->getTermLength() ) );
  
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new SWUserException( "[FAILED_TO_DELETE_PRICE]: " . $dbo->getPrice() );
    }
}

/**
 * Load a DomainServicePriceDBO from the database
 *
 * @param integer Domain Service ID
 * @param string Payment type
 * @param integer Term length
 * @return DomainServicePriceDBO DomainServicePriceDBO, or null if not found
 */
function load_DomainServicePriceDBO( $tld, $type, $termLength )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "domainserviceprice",
				"*",
				sprintf( "tld='%s' AND type='%s' AND termlength=%d",
					 $tld,
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
      fatal_error( "load_DomainServicePriceDBO", 
		   "Attempt to load DBO failed on SELECT: " . mysql_error() );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new DomainServicePriceDBO
  $dbo = new DomainServicePriceDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple DomainServicePriceDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of DomainServiceDBO's
 */
function load_array_DomainServicePriceDBO( $filter = null,
					   $sortby = null,
					   $sortdir = null,
					   $limit = null,
					   $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "domainserviceprice",
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
      fatal_error( "load_array_DomainServicePriceDBO", "SELECT failure:" .
		   mysql_error() );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      return array();
    }

  // Build an array of DomainServicePriceDBOs from the result set
  $price_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DomainServiceDBO with the data from the DB
      $dbo =& new DomainServicePriceDBO();
      $dbo->load( $data );

      // Add DomainServiceDBO to array
      $price_dbo_array[] = $dbo;
    }

  return $price_dbo_array;
}
?>