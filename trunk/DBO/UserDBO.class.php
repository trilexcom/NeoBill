<?php
/**
 * UserDBO.class.php
 *
 * This file contains the definition for the UserDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

/**
 * UserDBO
 *
 * Represents a Solid-State User
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class UserDBO extends DBO
{
  /**
   * @var string Username
   */
  var $username;

  /**
   * @var integer Account ID
   */
  var $accountid;

  /**
   * @var string Password (MD5)
   */
  var $password;

  /**
   * @var string First name
   */
  var $firstname;

  /**
   * @var string Last name
   */
  var $lastname;

  /**
   * @var string Email
   */
  var $email;

  /**
   * @var string Type (Administrator, Account Manager)
   */
  var $type;

  /**
   * @var string Language preference
   */
  var $language;

  /**
   * Set Username
   *
   * @param string $username Username
   */
  function setUsername( $username ) { $this->username = $username; }

  /**
   * Get Username
   *
   * @return string Username
   */
  function getUsername() { return $this->username; }

  /**
   * Set Account ID
   *
   * @param integer $accountid Account ID
   */
  function setAccountID( $accountid ) { $this->accountid = $accountid; }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  function getAccountID() { return $this->accountid; }

  /**
   * Set Password
   *
   * @param string $password Password (should be MD5'd before passing!)
   */
  function setPassword( $password ) { $this->password = $password; }

  /**
   * Get Password
   *
   * @return string Password (should be MD5'd)
   */
  function getPassword() { return $this->password; }

  /**
   * Set First Name
   *
   * @param string $firstname First name
   */
  function setFirstName( $firstname ) { $this->firstname = $firstname; }

  /**
   * Get First Name
   *
   * @return string First name
   */
  function getFirstName() { return $this->firstname; }

  /**
   * Set Last Name
   *
   * @param string $lastname Last name
   */
  function setLastName( $lastname ) { $this->lastname = $lastname; }

  /**
   * Get Last Name
   *
   * @return string Last name
   */
  function getLastName() { return $this->lastname; }

  /**
   * Set Email
   *
   * @param string $email Email
   */
  function setEmail( $email ) { $this->email = $email; }

  /**
   * Get Email
   *
   * @return string Email
   */
  function getEmail() { return $this->email; }

  /**
   * Set User Type
   *
   * @param string $type User type (Administrator, Account Manager)
   */
  function setType( $type )
  {
    if( !($type == "Account Manager" || $type == "Administrator" || $type == "Client" ) )
      {
	// Bad value
	fatal_error( "UserDBO::setType()",
		     "bad value supplied for setType: " . $type );
      }

    $this->type = $type;
  }

  /**
   * Get User Type
   *
   * @return string User type (Administrator, Account Manager)
   */
  function getType() { return $this->type; }

  /**
   * Set Language Preference
   *
   * @param string $language Language preference
   */
  function setLanguage( $language ) { $this->language = $language; }

  /** 
   * Get Language Preference
   *
   * @return string Language preference
   */
  function getLanguage() { return $this->language; }

  /**
   * Load Memeber Data from Array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setUsername( $data['username'] );
    $this->setAccountID( $data['accountid'] );
    $this->setPassword( $data['password'] );
    $this->setFirstName( $data['firstname'] );
    $this->setLastName( $data['lastname'] );
    $this->setEmail( $data['email'] );
    $this->setType( $data['type'] );
    $this->setLanguage( $data['language'] );
  }
}

/**
 * Load UserDBO from Database
 *
 * @param string $username Username
 * @return UserDBO User, null if not found
 */
function &load_UserDBO( $username )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "user",
				"*",
				"username=" . $DB->quote_smart( $username ),
				null,
				null,
				null,
				null );

  // Run query
  if( !($result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatal_error( "load_UserDBO()", "Attempt to load UserDBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // User not found
      return null;
    }

  // Load a new UserDBO
  $dbo = new UserDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Count UserDBO's
 *
 * Same as load_array_UserDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @return integer Number of User records
 */
function count_all_UserDBO( $filter = null )
{
  global $DB;

  // Build Query
  $sql = "SELECT COUNT(*) FROM user";

  // Run Query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatal_error( "count_all_UserDBO()", "SELECT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_UserDBO()", 
		   "SELECT expected 1 row, but got more (or none)" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

/**
 * Load multiple UserDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of UserDBO's
 */
function &load_array_UserDBO( $filter  = null, 
			      $sortby  = null, 
			      $sortdir = null,
			      $limit   = null, 
			      $start   = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "user",
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
      fatal_error( "load_array_UserDBO()", "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No Users found
      return null;
    }

  // Build an array of UserDBOs from the result set
  $user_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
      {
	// Create and initialize a new UserDBO with the data from the DB
	$dbo =& new UserDBO();
	$dbo->load( $data );

	// Add UserDBO to array
	$user_dbo_array[] = $dbo;
      }

  // Return the UserDBO array
  return $user_dbo_array;
}

/**
 * Insert UserDBO into Database
 *
 * @param UserDBO &$dbo UserDBO to be added to database
 * @return boolean True on success
 */
function add_UserDBO( &$dbo )
{
  global $DB;

  // Prepare to insert into the User table
  $sql = $DB->build_insert_sql( "user",
				array( "username" => $dbo->getUsername(),
				       "password" => $dbo->getPassword(),
				       "accountid" => $dbo->getAccountID(),
				       "type" => $dbo->getType(),
				       "firstname" => $dbo->getFirstName(),
				       "lastname" => $dbo->getLastName(),
				       "email" => $dbo->getEmail(),
				       "language" => $dbo->getLanguage() ) );

  // Execute
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Update UserDBO
 *
 * @param UserDBO &$dbo UserDBO to update
 * @return boolean True on success
 */
function update_UserDBO( &$dbo )
{
  global $DB;

  // Build UPDATE query
  $sql = $DB->build_update_sql( "user",
				"username = " . 
				$DB->quote_smart( $dbo->getUsername() ),
				array( "password" => $dbo->getPassword(),
				       "accountid" => $dbo->getAccountID(),
				       "firstname" => $dbo->getFirstName(),
				       "lastname" => $dbo->getLastName(),
				       "email" => $dbo->getEmail(),
				       "type" => $dbo->getType(),
				       "language" => $dbo->getLanguage() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete UserDBO from Database
 *
 * @param UserDBO &$dbo UserDBO to be deleted
 * @return boolean True on success
 */
function delete_UserDBO( &$dbo )
{
  global $DB;

  // Build DELETE query
  $sql = $DB->build_delete_sql( "user", 
				"username = " . 
				$DB->quote_smart( $dbo->getUsername() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

?>