<?php
/**
 * LogDBO.class.php
 *
 * This file contains the definition of the LogDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * LogDBO
 *
 * Represents a log entry.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LogDBO extends DBO
{
  /**
   * @var integer Log ID
   */
  var $id;

  /**
   * @var string Type of log message
   */
  var $type;

  /**
   * @var string Code module this action occured in
   */
  var $module;

  /**
   * @var string Message text
   */
  var $text;

  /**
   * @var string User that caused this log message
   */
  var $username;

  /**
   * @var integer Remote IP address that caused this log message (long integer form)
   */
  var $remoteip;

  /**
   * @var string Date of action (MySQL DATETIME)
   */
  var $date;

  /**
   * Convert to a String
   *
   * @return string Log ID
   */
  function __toString() { return $this->getID(); }

  /**
   * Set ID
   *
   * @param integer $id Log ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get ID
   *
   * @return integer Log ID
   */
  function getID() { return $this->id; }

  /**
   * Set Type
   *
   * Sets the type of log message: notice, warning, error, critical, or security
   *
   * @param string $type Log message type (notice, warning, error, critical, or security)
   */
  function setType( $type )
  {
    if( !($type == "notice" ||
	  $type == "warning" ||
	  $type == "error" ||
	  $type == "critical" ||
	  $type == "security" ) )
      {
	echo "error, bad log type!";
	exit();
      }
    $this->type = $type;
  }

  /**
   * Get Type
   *
   * @return string Log message type
   */
  function getType() { return $this->type; }

  /**
   * Set Module
   *
   * Set the code module that this log message originates from (i.e.: LogDBO::getType() )
   *
   * @param string $module Module name
   */
  function setModule( $module ) { $this->module = $module; }

  /**
   * Get Module
   *
   * @return string Module name
   */
  function getModule() { return $this->module; }

  /**
   * Set Text
   *
   * @param string $text The log message
   */
  function setText( $text ) { $this->text = $text; }

  /**
   * Get Text
   *
   * @return string The log message
   */
  function getText() { return $this->text; }

  /**
   * Set Username
   *
   * Sets the User who caused this log message
   *
   * @param string $username User
   */
  function setUsername( $username )
  {
    $this->username = $username;
  }

  /**
   * Get Username
   *
   * @return string User
   */
  function getUsername() { return $this->username; }

  /**
   * Set Remote IP
   *
   * @param string $ip IP address of the remote user who caused this log message (long integer form)
   */
  function setRemoteIP( $ip ) { $this->remoteip = $ip; }

  /**
   * Get Remote IP
   *
   * @return intger IP address of the remote user who caused this log message (long integer form)
   */
  function getRemoteIP() { return $this->remoteip; }

  /**
   * Set Date
   *
   * @param string $date Date this log message occured (MySQL DATETIME)
   */
  function setDate( $date ) { $this->date = $date; }

  /**
   * Get Date
   *
   * @return string Date this log message occured (MySQL DATETIME)
   */
  function getDate() { return $this->date; }

  /**
   * Get Remote IP String
   *
   * @return string Remote IP address in string form
   */
  function getRemoteIPString() { return long2ip( $this->remoteip ); }

  /**
   * Load Member Data from Array
   *
   * @param array $data Member data
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setType( $data['type'] );
    $this->setModule( $data['module'] );
    $this->setText( $data['text'] );
    $this->setUsername( $data['username'] );
    $this->setRemoteIP( $data['remoteip'] );
    $this->setDate( $data['date'] );
  }
}


/**
 * Insert LogDBO into database
 *
 * @param LogDBO &$dbo LogDBO to add
 * @return boolean True on success
 */
function add_LogDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_insert_sql( "log",
				array( "type" => $dbo->getType(),
				       "module" => $dbo->getModule(),
				       "text" => $dbo->getText(),
				       "username" => $dbo->getUsername(),
				       "remoteip" => intval( $dbo->getRemoteIP() ),
				       "date" => $dbo->getDate() ) );

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
      echo "Could not retrieve ID from previous INSERT!";
      exit();
    }
  if( $id == 0 )
    {
      // No ID?
      echo "Previous INSERT did not generate an ID";
      exit();
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update LogDBO in database
 *
 * @param LogDBO &$dbo Log DBO to update
 * @return boolean True on success
 */
function update_LogDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "log",
				"id = " . intval( $dbo->getID() ),
				array( "type" => $dbo->getType(),
				       "module" => $dbo->getModule(),
				       "text" => $dbo->getText(),
				       "username" => $dbo->getUsername(),
				       "remoteip" => intval( $dbo->getRemoteIP() ),
				       "date" => $dbo->getDate() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete LogDBO from database
 *
 * @param LogDBO &$dbo Log DBO to delete
 * @return boolean True on success
 */
function delete_LogDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  $id = intval( $dbo->getID() );

  // Build SQL
  $sql = $DB->build_delete_sql( "log",
				"id = " . $id );
  // Delete the LogDBO
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load an LogDBO from the database
 *
 * @param integer $id ID of Log DBO to retrieve
 * @return LogDBO Log DBO, null if not found
 */
function load_LogDBO( $id )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "log",
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
      echo "Attempt to load DBO failed on SELECT";
      exit();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }
  
  // Load a new LogDBO
  $dbo = new LogDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new LogDBO
  return $dbo;
}

/**
 * Load multiple Log DBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param integer $limit Limit the number of results
 * @param integer $start Record number to start the results at
 * @return array Array of LogDBO's
 */
function &load_array_LogDBO( $filter = null,
			     $sortby = null,
			     $sortdir = null,
			     $limit = null,
			     $start = null )
{
  $DB = DBConnection::getDBConnection();

  // Build query
  $sql = $DB->build_select_sql( "log",
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
      echo "SELECT failure";
      exit();
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
      $dbo =& new LogDBO();
      $dbo->load( $data );

      // Add DomainServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Same as load_array_LogDBO, except this function just COUNTs the number
 * of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param integer $limit Limit the number of results
 * @param integer $start Record number to start the results at
 * @return integer Number of LogDBOs in database matching the criteria
 */
function count_all_LogDBO( $filter = null )
{
  $DB = DBConnection::getDBConnection();
  
  // Build query
  $sql = $DB->build_select_sql( "log",
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
      echo "SELECT COUNT failure";
      exit();
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      echo "Expected SELECT to return 1 row";
      exit();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>