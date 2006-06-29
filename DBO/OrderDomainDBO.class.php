<?php
/**
 * OrderDomainDBO.class.php
 *
 * This file contains the definition for the OrderDomainDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "DBO/OrderItemDBO.class.php";

/**
 * OrderDomainDBO
 *
 * Represent an OrderDomain.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderDomainDBO extends OrderItemDBO
{
  /**
   * @var integer OrderDomain ID
   */
  var $id;

  /**
   * @var string Domain order type (New, Transfer, or Existing)
   */
  var $type;

  /**
   * @var string TLD
   */
  var $tld;

  /**
   * @var DomainServiceDBO Domain service this is being ordered
   */
  var $servicedbo;

  /**
   * @var string Domain Name (without TLD)
   */
  var $domainname;

  /**
   * @var string Term
   */
  var $term;

  /**
   * @var string Transfer secret
   */
  var $transferSecret;

  /**
   * @var string Contact name
   */
  var $contactname;

  /**
   * @var string Contact e-mail
   */
  var $contactemail;

  /**
   * @var string Business name
   */
  var $businessname;

  /**
   * @var string Address (line 1)
   */
  var $address1;

  /**
   * @var string Address (line 2)
   */
  var $address2;

  /**
   * @var string Address (line 3)
   */
  var $address3;

  /**
   * @var string Telephone number
   */
  var $phone;

  /**
   * @var string Fax number
   */
  var $fax;

  /**
   * @var string City
   */
  var $city;

  /**
   * @var string State
   */
  var $state;

  /**
   * @var string Country
   */
  var $country;

  /**
   * @var string Postal/zip code
   */
  var $postalcode;

  /**
   * Set OrderDomain ID
   *
   * @param integer $id OrderDomain ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get OrderDomain ID
   *
   * @return integer OrderDomain ID
   */
  function getID() { return $this->id; }

  /**
   * Set Business Name
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $name New Business Name
   */
  function setBusinessName( $type, $name ) { $this->businessname[$type] = $name; }

  /**
   * Get Business Name
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * return string Business Name
   */
  function getBusinessName( $type ) { return $this->businessname[$type]; }

  /**
   * Set Contact's Name
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $name New Contact Name
   */
  function setContactName( $type, $name ) { $this->contactname[$type] = $name; }

  /**
   * Get Contact's Name
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @return string Contact's name
   */
  function getContactName( $type ) { return $this->contactname[$type]; }

  /**
   * Set Contact's Email Address
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $email New contact email address
   */
  function setContactEmail( $type, $email ) { $this->contactemail[$type] = $email; }

  /**
   * Get Contact's Email Address
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @return string Contact's email address
   */
  function getContactEmail( $type ) { return $this->contactemail[$type]; }

  /**
   * Set Contact's Address (line 1)
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $address Contact's first address line
   */
  function setAddress1( $type, $address ) { $this->address1[$type] = $address; }

  /**
   * Get Contact's Address (line 1)
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * return string Contact's first address line
   */
  function getAddress1( $type ) { return $this->address1[$type]; }

  /**
   * Set Contact's Address (line 2)
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $address Contact's address line 2
   */
  function setAddress2( $type, $address ) { $this->address2[$type] = $address; }

  /**
   * Get Contac'ts Address (line 2)
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * return string Contact's address line 2
   */
  function getAddress2( $type ) { return $this->address2[$type]; }

  /**
   * Set Contact's Address (line 3)
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $address Contact's address line 3
   */
  function setAddress3( $type, $address ) { $this->address3[$type] = $address; }

  /**
   * Get Contac'ts Address (line 3)
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * return string Contact's address line 3
   */
  function getAddress3( $type ) { return $this->address3[$type]; }

  /**
   * Set Contact's City
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $city Contact's city
   */
  function setCity( $type, $city ) { $this->city[$type] = $city; }

  /**
   * Get Contact's City
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * return $string Contact's City
   */
  function getCity( $type ) { return $this->city[$type]; }

  /**
   * Set Contact's State
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $state Contact's State
   */
  function setState( $type, $state ) { $this->state[$type] = $state; }

  /**
   * Get Contact's State
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @return string Contact's State
   */
  function getState( $type ) { return $this->state[$type]; }

  /**
   * Set Contact's Country
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $country Contact's country code
   */
  function setCountry( $type, $country ) { $this->country[$type] = $country; }

  /**
   * Get Contact's Country
   *
   * @return string Contac'ts 2-digit country code
   */
  function getCountry( $type ) { return $this->country[$type]; }

  /**
   * Set Contact's Postal Code
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $zip Contact's postal code
   */
  function setPostalCode( $type, $zip ) { $this->postalcode[$type] = $zip; }

  /**
   * Get Contact's Postal Code
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @return string Contac'ts postal code
   */
  function getPostalCode( $type ) { return $this->postalcode[$type]; }

  /**
   * Set Contact's Phone Number
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $phone Contact's phone number
   */
  function setPhone( $type, $phone ) { $this->phone[$type] = $phone; }

  /**
   * Get Contact's Phone Number
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @return string Contact's phone number
   */
  function getPhone( $type ) { return $this->phone[$type]; }

  /**
   * Set Contact's Fax Number
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @param string $fax Contact's fax number
   */
  function setFax( $type, $fax ) { $this->fax[$type] = $fax; }

  /**
   * Get Contact's Fax Number
   *
   * @param string $type Contact information type (i.e. admin, billing, tech, etc.)
   * @return string Contact's fax number
   */
  function getFax( $type ) { return $this->fax[$type]; }

  /**
   * Has Contact Information
   *
   * @return boolean True if contact information has been supplied for this domain
   */
  function hasContactInformation()
  {
    return ($this->businessname != null ||
	    $this->contactname != null ||
	    $this->contactemail != null ||
	    $this->address1 != null ||
	    $this->address2 != null ||
	    $this->address3 != null ||
	    $this->city != null ||
	    $this->state != null ||
	    $this->country != null ||
	    $this->postalcode != null ||
	    $this->phone != null ||
	    $this->fax != null );
  }

  /**
   * Set Type
   *
   * @param string $type Domain order-type
   */
  function setType( $type )
  {
    if( !( $type == "New" || $type == "Transfer" || $type == "Existing" ) )
      {
	fatal_error( "OrderDomainDBO::setType()", "Invalid type: " . $type );
      }
    $this->type = $type;
  }

  /**
   * Get Type
   *
   * @return string Domain order-type
   */
  function getType() { return $this->type; }

  /**
   * Set Domain Service
   *
   * @param DomainServiceDBO $dbo Domain service being ordered
   */
  function setService( $dbo )
  {
    if( !isset( $dbo ) )
    {
      // Reset the TLD and Domain Service
      $this->servicedbo = null;
      $this->tld = null;
      return;
    }
    if( !is_a( $dbo, "DomainServiceDBO" ) )
      {
	fatal_error( "ORderDomainDBO::setService()", "DBO is not a DomainServiceDBO" );
      }
    $this->servicedbo = $dbo;
    $this->tld = $dbo->getTLD();
  }

  /**
   * Set TLD
   *
   * @param string $tld Domain TLD
   */
  function setTLD( $tld ) 
  { 
    if( ($this->servicedbo = load_DomainServiceDBO( $tld )) == null )
      {
	fatal_error( "OrderDomainDBO::setTLD()",
		     "Unable to load DomainServiceDBO with tld = " . $tld );
      }
    $this->tld = $tld; 
  }

  /**
   * Get TLD
   *
   * @return string TLD
   */
  function getTLD() { return $this->tld; }

  /**
   * Set Domain Name
   *
   * @param string $domainname Domain name (without TLD)
   */
  function setDomainName( $domainname ) { $this->domainname = $domainname; }

  /**
   * Get Domain Name
   *
   * @return string Domain Name (without TLD)
   */
  function getDomainName() { return $this->domainname; }

  /**
   * Get Full Domain Name
   *
   * @return string Full Domain Name
   */
  function getFullDomainName() { return $this->domainname . "." . $this->getTLD(); }

  /**
   * Set Registration Term
   *
   * @param string $term Registration term ("1 year", "2 year" ... "10 year")
   */
  function setTerm( $term )
  {
    if( !( $term == null ||
	   $term == "1 year" ||
	   $term == "2 year" ||
	   $term == "3 year" ||
	   $term == "4 year" ||
	   $term == "5 year" ||
	   $term == "6 year" ||
	   $term == "7 year" ||
	   $term == "8 year" ||
	   $term == "9 year" ||
	   $term == "10 year" ) )
      {
	fatal_error( "OrderDomainDBO::setTerm()", "Invalid term: " . $term );
      }
    $this->term = $term;
  }

  /**
   * Get Registration Term
   *
   * @return string Registration term ("1 year", "2 year" ... "10 year"")
   */
  function getTerm() { return $this->term; }

  /**
   * Get Description
   *
   * @return string Description of this order item
   */
  function getDescription()
  {
    switch( $this->getType() )
      {
      case "Existing": $desc = ""; break;
      case "New": $desc = "[DOMAIN_REGISTRATION]: "; break;
      case "Transfer": $desc = "[DOMAIN_TRANSFER]: "; break;
      }
    $desc .= $this->getFullDomainName();
    return translate_string( $this->conf['locale']['language'], $desc );
  }

  /**
   * Get Price
   *
   * @return double Price of this order item
   */
  function getPrice()
  {
    switch( $this->getTerm() )
      {
      case "1 year": return $this->servicedbo->getPrice1yr(); break;
      case "2 year": return $this->servicedbo->getPrice2yr(); break;
      case "3 year": return $this->servicedbo->getPrice3yr(); break;
      case "4 year": return $this->servicedbo->getPrice4yr(); break;
      case "5 year": return $this->servicedbo->getPrice5yr(); break;
      case "6 year": return $this->servicedbo->getPrice6yr(); break;
      case "7 year": return $this->servicedbo->getPrice7yr(); break;
      case "8 year": return $this->servicedbo->getPrice8yr(); break;
      case "9 year": return $this->servicedbo->getPrice9yr(); break;
      case "10 year": return $this->servicedbo->getPrice10yr(); break;
      }

    return 0;
  }

  /**
   * Get Price String
   *
   * @return string Price formatted with currency symbol
   */
  function getPriceString()
  {
    return smarty_modifier_currency( $this->getPrice() );
  }

  /**
   * Get Setup Fee
   *
   * @return double Always zero for a domain iem
   */
  function getSetupFee() { return 0.00; }

  /**
   * Get Setup Fee String
   *
   * @return string "-"
   */
  function getSetupFeeString()
  {
    return translate_string( $this->conf['locale']['language'], "[NA]" );
  }

  /**
   * Set Transfer Secret
   *
   * @param string $secret Transfer secret
   */
  function setTransferSecret( $secret ) { $this->transferSecret = $secret; }

  /**
   * Get Transfer Secret
   *
   * @return string Transfer secret
   */
  function getTransferSecret() { return $this->transferSecret; }

  /**
   * Is Taxable
   *
   * @return boolean True if this item is taxable
   */
  function isTaxable() { return $this->servicedbo->getTaxable() == "Yes"; }

  /**
   * Execute Domain Order
   *
   * Register or Transfer the domain and create a new Domain Service Purchase 
   * for this order item
   *
   * @param integer $accountID Account ID
   * @return boolean True for success
   */
  function execute( $accountID )
  {
    global $DB;

    switch( $this->getType() )
      {
      case "Existing":
	// Do nothing
	return true;
	break;

      case "New":
	return $this->registerDomain();
	break;

      case "Transfer":
      default:
	fatal_error( "OrderDomainDBO::execute()",
		     "Domain order type not supported: " . $this->getType() );
      }
  }

  /**
   * Register this Domain
   *
   * @return boolean True for success
   */
  function registerDomain()
  {
    $serviceDBO = load_DomainServiceDBO( $this->getTLD() );
    $module = $this->conf['modules'][$serviceDBO->getModuleName()];

    // Make sure the domain is available
    if( !$module->checkAvailability( $this->getFullDomainName() ) )
      {
	log_error( "OrderDomainDBO::registerDomain()",
		   "Attempted to register a domain that is not available: " . $this->getFullDomainName() );
	return false;
      }

    // Success
    return true;
  }

  /**
   * Load Member Data from Array
   */
  function load( $data )
  {
    parent::load( $data );
    $this->setID( $data['id'] );
    $this->setOrderID( $data['orderid'] );
    $this->setType( $data['type'] );
    $this->setTLD( $data['tld'] );
    $this->setDomainName( $data['domainname'] );
    $this->setTerm( $data['term'] );
  }
}

/**
 * Insert OrderDomainDBO into database
 *
 * @param OrderDomainDBO &$dbo OrderDomainDBO to add to database
 * @return boolean True on success
 */
function add_OrderDomainDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "orderdomain",
				array( "orderid" => intval( $dbo->getOrderID() ),
				       "orderitemid" => intval( $dbo->getOrderItemID() ),
				       "type" => $dbo->getType(),
				       "tld" => $dbo->getTLD(),
				       "status" => $dbo->getStatus(),
				       "domainname" => $dbo->getDomainName(),
				       "term" => $dbo->getTerm() ) );

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
      fatal_error( "add_OrderDomainDBO()", 
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_OrderDomainDBO()", 
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );
  return true;
}

/**
 * Update OrderDomainDBO in database
 *
 * @param OrderDomainDBO &$dbo OrderDomainDBO to update
 * @return boolean True on success
 */
function update_OrderDomainDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "orderdomain",
				"id = " . intval( $dbo->getID() ),
				array( "orderid" => intval( $dbo->getOrderID() ),
				       "type" => $dbo->getType(),
				       "tld" => $dbo->getTLD(),
				       "status" => $dbo->getStatus(),
				       "domainname" => $dbo->getDomainName(),
				       "term" => $dbo->getTerm() ) );
				
  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete OrderDomainDBO from database
 *
 * @param OrderDomainDBO &$dbo OrderDomainDBO to delete
 * @return boolean True on success
 */
function delete_OrderDomainDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "orderdomain",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a OrderDomainDBO from the database
 *
 * @param integer $id OrderDomain ID
 * @return OrderDomainDBO OrderDomainDBO, or null if not found
 */
function load_OrderDomainDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "orderdomain",
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
      fatel_error( "load_OrderDomainDBO", 
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new OrderDBO
  $dbo = new OrderDomainDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple OrderDomainDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function &load_array_OrderDomainDBO( $filter = null,
				     $sortby = null,
				     $sortdir = null,
				     $limit = null,
				     $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "orderdomain",
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
      fatal_error( "load_array_OrderDomainDBO", "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Build an array of DBOs from the result set
  $dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DBO with the data from the DB
      $dbo =& new OrderDomainDBO();
      $dbo->load( $data );

      // Add OrderDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count OrderDomainDBO's
 *
 * Same as load_array_OrderDomainDBO, except this function just COUNTs the number
 * of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function count_all_OrderDomainDBO( $filter = null )
{
  global $DB;

  // Build query
  $sql = "SELECT COUNT(*) FROM orderdomain";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_OrderDomainDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_OrderDomainDBO()",
		   "Expected SELECT to return 1 row" );
      exit();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>