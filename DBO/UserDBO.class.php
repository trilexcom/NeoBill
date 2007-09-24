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
   * @var string Contact name
   */
  protected $contactName;

  /**
   * @var string Email
   */
  protected $email;

  /**
   * @var string Language preference
   */
  protected $language;

  /**
   * @var string Password (MD5)
   */
  protected $password;

  /**
   * @var string The user's theme preference
   */
  protected $theme = "default";

  /**
   * @var string Type (Administrator, Account Manager)
   */
  protected $type;

  /**
   * @var string Username
   */
  protected $username;

  /**
   * Convert to a String
   *
   * @return string Username
   */
  public function __toString() { return $this->getUsername(); }

  /**
   * Set Username
   *
   * @param string $username Username
   */
  public function setUsername( $username ) { $this->username = $username; }

  /**
   * Get Username
   *
   * @return string Username
   */
  public function getUsername() { return $this->username; }

  /**
   * Set Password
   *
   * @param string $password Password (should be MD5'd before passing!)
   */
  public function setPassword( $password ) { $this->password = $password; }

  /**
   * Get Password
   *
   * @return string Password (should be MD5'd)
   */
  public function getPassword() { return $this->password; }

  /**
   * Set Contact Name
   *
   * @param string $contactName Contact name
   */
  function setContactName( $contactName ) { $this->contactName = $contactName; }

  /**
   * Get Contact Name
   *
   * @return string Contact name
   */
  function getContactName() { return $this->contactName; }

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
   * Set Theme
   *
   * @param string $theme User's theme preference
   */
  public function setTheme( $theme ) { $this->theme = $theme; }

  /**
   * Get Theme
   *
   * @return string User's theme preference
   */
  public function getTheme() { return $this->theme; }

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
	throw new SWException( "Invalid User type: " . $type );
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
}

/**
 * Load UserDBO from Database
 *
 * @param string $username Username
 * @return UserDBO User, null if not found
 */
function load_UserDBO( $username )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // User not found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();;

  // Build Query
  $sql = "SELECT COUNT(*) FROM user";

  // Run Query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
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
function load_array_UserDBO( $filter  = null, 
			      $sortby  = null, 
			      $sortdir = null,
			      $limit   = null, 
			      $start   = null )
{
  $DB = DBConnection::getDBConnection();;

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No Users found
      throw new DBNoRowsFoundException();
    }

  // Build an array of UserDBOs from the result set
  $user_dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
      {
	// Create and initialize a new UserDBO with the data from the DB
	$dbo = new UserDBO();
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
function add_UserDBO( UserDBO $dbo )
{
  $DB = DBConnection::getDBConnection();;

  // Prepare to insert into the User table
  $sql = $DB->build_insert_sql( "user",
				array( "username" => $dbo->getUsername(),
				       "password" => $dbo->getPassword(),
				       "type" => $dbo->getType(),
				       "contactname" => $dbo->getContactName(),
				       "email" => $dbo->getEmail(),
				       "language" => $dbo->getLanguage(),
				       "theme" => $dbo->getTheme() ) );

  // Execute
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Update UserDBO
 *
 * @param UserDBO &$dbo UserDBO to update
 * @return boolean True on success
 */
function update_UserDBO( UserDBO $dbo )
{
  $DB = DBConnection::getDBConnection();;

  // Build UPDATE query
  $sql = $DB->build_update_sql( "user",
				"username = " . 
				$DB->quote_smart( $dbo->getUsername() ),
				array( "password" => $dbo->getPassword(),
				       "contactname" => $dbo->getContactName(),
				       "email" => $dbo->getEmail(),
				       "type" => $dbo->getType(),
				       "language" => $dbo->getLanguage(),
				       "theme" => $dbo->getTheme() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete UserDBO from Database
 *
 * @param UserDBO &$dbo UserDBO to be deleted
 * @return boolean True on success
 */
function delete_UserDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();;

  // Build DELETE query
  $sql = $DB->build_delete_sql( "user", 
				"username = " . 
				$DB->quote_smart( $dbo->getUsername() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}
?>
