<?php
/**
 * ContactDBO.class.php
 *
 * This file contains the definition for the ContactDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ContactDBO
 *
 * Represent a Contact
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ContactDBO extends DBO
{
  /**
   * @var string Address1
   */
  var $address1;

  /**
   * @var string Address2
   */
  var $address2;

  /**
   * @var string Address3
   */
  var $address3;

  /**
   * @var string Business Name
   */
  var $businessname;

  /**
   * @var string City
   */
  var $city;

  /**
   * @var string Country
   */
  var $country;

  /**
   * @var string Email
   */
  var $email;

  /**
   * @var integer Contact ID
   */
  var $id;

  /**
   * @var string Contact name
   */
  var $name;

  /**
   * @var string Phone 1
   */
  var $phone;

  /**
   * @var string Phone 2
   */
  var $mobilephone;

  /**
   * @var string Phone 3
   */
  var $fax;

  /**
   * @var string Postal code
   */
  var $postalcode;

  /**
   * @var string State
   */
  var $state;

  /**
   * Convert to a String
   *
   * @return string The contact ID
   */
  function __toString() { return $this->getID(); }

  /**
   * Constructor
   *
   * @param string $contactName Contact name
   * @param string $businessname Contact name
   * @param string $email Contact name
   * @param string $address1 Contact name
   * @param string $address2 Contact name
   * @param string $address3 Contact name
   * @param string $city Contact name
   * @param string $state Contact name
   * @param string $postalcode Postal code
   * @param string $country Contact name
   * @param string $phone Contact name
   * @param string $mobilePhone Contact name
   * @param string $fax Contact name
   */
  function ContactDBO( $contactName = null,
		       $businessName = null,
		       $email = null,
		       $address1 = null,
		       $address2 = null,
		       $address3 = null,
		       $city = null,
		       $state = null,
		       $postalcode = null,
		       $country = null,
		       $phone = null,
		       $mobilePhone = null,
		       $fax = null )
  {
    $this->setName( $contactName );
    $this->setBusinessName( $businessName );
    $this->setEmail( $email );
    $this->setAddress1( $address1 );
    $this->setAddress2( $address2 );
    $this->setAddress3( $address3 );
    $this->setCity( $city );
    $this->setState( $state );
    $this->setPostalCode( $postalcode );
    $this->setCountry( $country );
    $this->setPhone( $phone );
    $this->setMobilePhone( $mobilePhone );
    $this->setFax( $fax );
  }

  /**
   * Get Address1
   *
   * @return string Address 1
   */
  function getAddress1() { return $this->address1; }

  /**
   * Get Address1
   *
   * @return string Address 2
   */
  function getAddress2() { return $this->address2; }

  /**
   * Get Address3
   *
   * @return string Address 3
   */
  function getAddress3() { return $this->address3; }

  /**
   * Get Business Name
   *
   * @return string Business name
   */
  function getBusinessName() { return $this->businessname; }

  /**
   * Get City
   *
   * @return string City
   */
  function getCity() { return $this->city; }

  /**
   * Get Country
   *
   * @return string Country
   */
  function getCountry() { return $this->country; }

  /**
   * Get Phone 3
   *
   * @return string Phone 3
   */
  function getFax() { return $this->fax; }

  /**
   * Get Contact E-Mail
   *
   * @param string $email Contact e-mail
   */
  function getEmail() { return $this->email; }

  /**
   * Get Contact ID
   *
   * @return integer Contact ID
   */
  function getID() { return $this->id; }

  /**
   * Get Phone 2
   *
   * @return string Phone 2
   */
  function getMobilePhone() { return $this->mobilephone; }

  /**
   * Get Contact Name
   *
   * @return string Contact name
   */
  function getName() { return $this->name; }

  /**
   * Get Phone 1
   *
   * @return string Phone 1
   */
  function getPhone() { return $this->phone; }

  /**
   * Get Postal Code
   *
   * @return string Postal code
   */
  function getPostalCode() { return $this->postalcode; }

  /**
   * Get State
   *
   * @return string State
   */
  function getState() { return $this->state; }

  /**
   * Set Address 1
   *
   * @param string $address Address 1
   */
  function setAddress1( $address ) { $this->address1 = $address; }

  /**
   * Set Address 2
   *
   * @param string $address Address 2
   */
  function setAddress2( $address ) { $this->address2 = $address; }

  /**
   * Set Address 3
   *
   * @param string $address Address 3
   */
  function setAddress3( $address ) { $this->address3 = $address; }

  /**
   * Set Business Name
   *
   * @param string $businessname Business name
   */
  function setBusinessName( $businessname ) { $this->businessname = $businessname; }

  /**
   * Set City
   *
   * @param string $city City
   */
  function setCity( $city ) { $this->city = $city; }

  /**
   * Set Country
   *
   * @param string $country Country
   */
  function setCountry( $country ) { $this->country = $country; }

  /**
   * Set Contact E-Mail
   *
   * @param string $email Contact e-mail
   */
  function setEmail( $email ) { $this->email = $email; }

  /**
   * Set Fax Number
   *
   * @param string $phone Fax number
   */
  function setFax( $phone ) { $this->fax = $phone; }

  /**
   * Set Contact ID
   *
   * @param integer $id Contact ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Set Mobile Phone
   *
   * @param string $phone Mobile phone number
   */
  function setMobilePhone( $phone ) { $this->mobilephone = $phone; }

  /**
   * Set Contact Name
   *
   * @param string $name Contact name
   */
  function setName( $name ) { $this->name = $name; }

  /**
   * Set Phone
   *
   * @param string $phone Phone
   */
  function setPhone( $phone ) { $this->phone = $phone; }

  /**
   * Set Postal Code
   *
   * @param string $postalcode Postal code
   */
  function setPostalCode( $postalcode ) { $this->postalcode = $postalcode; }

  /**
   * Set State
   *
   * @param string $state State
   */
  function setState( $state ) { $this->state = $state; }
}

/**
 * Insert ContactDBO into database
 *
 * @param ContactDBO &$dbo ContactDBO to add to database
 */
function ContactDBO_add( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "contact",
				array( "name" => $dbo->getName(),
				       "businessname" => $dbo->getBusinessName(),
				       "email" => $dbo->getEmail(),
				       "address1" => $dbo->getAddress1(),
				       "address2" => $dbo->getAddress2(),
				       "address3" => $dbo->getAddress3(),
				       "city" => $dbo->getCity(),
				       "state" => $dbo->getState(),
				       "country" => $dbo->getCountry(),
				       "postalcode" => $dbo->getPostalCode(),
				       "phone" => $dbo->getPhone(),
				       "mobilephone" => $dbo->getMobilePhone(),
				       "fax" => $dbo->getFax() ) );

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
 * Delete ContactDBO from database
 *
 * @param ContactDBO &$dbo ContactDBO to delete
 * @return boolean True on success
 */
function ContactDBO_delete( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_delete_sql( "contact",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load a ContactDBO from the database
 *
 * @param integer $id Contact ID
 * @return ContactDBO Contact
 */
function ContactDBO_load( $id )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "contact",
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

  // Load a new OrderDBO
  $dbo = new ContactDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple ContactDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of ContactDBO's
 */
function &ContactDBO_loadArray( $filter = null,
				$sortby = null,
				$sortdir = null,
				$limit = null,
				$start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "contact",
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
      $dbo =& new ContactDBO();
      $dbo->load( $data );

      // Add OrderDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Update ContactDBO in database
 *
 * @param ContactDBO &$dbo ContactDBO to update
 */
function ContactDBO_update( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "contact",
				"id = " . intval( $dbo->getID() ),
				array( "name" => $dbo->getName(),
				       "businessname" => $dbo->getBusinessName(),
				       "email" => $dbo->getEmail(),
				       "address1" => $dbo->getAddress1(),
				       "address2" => $dbo->getAddress2(),
				       "address3" => $dbo->getAddress3(),
				       "city" => $dbo->getCity(),
				       "state" => $dbo->getState(),
				       "country" => $dbo->getCountry(),
				       "postalcode" => $dbo->getPostalCode(),
				       "phone" => $dbo->getPhone(),
				       "mobilephone" => $dbo->getMobilePhone(),
				       "fax" => $dbo->getFax() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}