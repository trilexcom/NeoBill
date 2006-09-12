<?php
/**
 * NoteDBO.class.php
 *
 * This file contains the definition for the NoteDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

/**
 * NoteDBO
 *
 * Represent an Account Note
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NoteDBO extends DBO
{
  /**
   * @var integer Note IB
   */
  var $id;

  /**
   * @var string Date (MySQL DATETIME)
   */
  var $date;

  /**
   * @var string Updated date (MySQL DATETIME)
   */
  var $updated;

  /**
   * @var integer Account ID
   */
  var $accountid;

  /**
   * @var string Solid-State user who authored this note
   */
  var $username;

  /**
   * @var string Note text
   */
  var $text;

  /**
   * Set Note ID
   *
   * @param integer $id Note ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Note ID
   *
   * @return integer Note ID
   */
  function getID() { return $this->id; }

  /**
   * Set Date
   *
   * @param string $date Date (MySQL DATETIME)
   */
  function setDate( $date ) { $this->date = $date; }

  /**
   * Get Date
   *
   * @return string Date (MySQL DATETIME)
   */
  function getDate() { return $this->date; }

  /**
   * Set Update Date
   *
   * @param string Update date (MySQL DATETIME)
   */
  function setUpdated( $date ) { $this->updated = $date; }

  /**
   * Get Update Date
   *
   * @return string Update date (MySQL DATETIME)
   */
  function getUpdated() { return $this->updated; }

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
   * Set Username
   *
   * @param string $username Solid-State username
   */
  function setUsername( $username ) { $this->username = $username; }

  /**
   * Get Username
   *
   * @return string Solid-State username
   */
  function getUsername() { return $this->username; }

  /**
   * Set Note Text
   *
   * @param string $test Note text
   */
  function setText( $text ) { $this->text = $text; }

  /**
   * Get Note Text
   *
   * @return string Note text
   */
  function getText() { return $this->text; }

  /**
   * Load Member Data from Array
   *
   * @param array $data Date to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setDate( $data['date'] );
    $this->setUpdated( $data['date'] );
    $this->setAccountID( $data['accountid'] );
    $this->setUsername( $data['username'] );
    $this->setText( $data['text'] );
  }
}

/**
 * Insert NoteDBO into Database
 *
 * @param NoteDBO &$dbo NoteDBO to add to database
 * @return boolean True on success
 */
function add_NoteDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "note",
				array( "date" => $DB->format_datetime( time() ),
				       "updated" => $DB->format_datetime( time() ),
				       "accountid" => $dbo->getAccountID(),
				       "username" => $dbo->getUsername(),
				       "text" => $dbo->getText() ) );

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
      fatal_error( "add_NoteDBO()", "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_NoteDBO()", "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;

}

/**
 * Update NoteDBO
 *
 * @param NoteDBO &$dbo NoteDBO to update
 * @return boolean True on success
 */
function update_NoteDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "note",
				"id = " . intval( $dbo->getID() ),
				array( "updated" => $DB->format_datetime( time() ),
				       "username" => $dbo->getUsername(),
				       "text" => $dbo->getText() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete NoteDBO from Database
 * 
 * @param NoteDBO &$dbo NoteDBO to delete
 * @return boolean True on success
 */
function delete_NoteDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "note",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load NoteDBO from Database
 *
 * @param integer $id Note ID
 * @return NoteDBO Note, or null if not found
 */
function load_NoteDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "note",
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
      fatal_error( "load_NoteDBO()", "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }
  
  // Load a new NoteDBO
  $dbo = new NoteDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new AccountDBO
  return $dbo;
}

/**
 * Load multiple NoteDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of NoteDBO's
 */
function &load_array_NoteDBO( $filter = null,
			      $sortby = null,
			      $sortdir = null,
			      $limit = null,
			      $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "note",
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
      fatal_error( "load_array_NoteDBO()", "SELECT failure" );
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
      $dbo =& new NoteDBO();
      $dbo->load( $data );

      // Add DomainServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count NoteDBO's
 *
 * Same as load_array_NoteDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of Note records
 */
function count_all_NoteDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "note",
				"COUNT(*)",
				$filter,
				null,
				null,
				null,
				null );

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_NoteDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_NoteDBO()", "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}


?>