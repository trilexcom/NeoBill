<?php
/**
 * DBConnection.class.php
 *
 * This file contains a definition for the DBConnection class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DBConnection
 *
 * Handles interaction with a MySQL database for the framework.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DBConnection
{
  /**
   * @var object Database handle
   */
  var $dbh = null;

  /**
   * Default constructor
   *
   * Initializes the database handle
   */
  function DBConnection()
  {
    $this->dbh = null;
  }

  /**
   * Database Handle
   *
   * Access the database handle.  If no handle exists, open a connection to the
   * database.
   *
   * @return object Database handle
   */
  function handle()
  {
    global $conf;

    if( $this->dbh == null )
      {
	// Not connected.  Yet.
	$this->connect();
      }

    return $this->dbh;
  }

  /**
   * Connect to the database server
   */
  function connect()
  {
    global $conf;

    // Open a connection to the database server
    $this->dbh = @mysql_connect( $conf['db']['host'],
				 $conf['db']['user'],
				 $conf['db']['pass'] );
    if( $this->dbh == null )
      {
	// Connection failed
	echo "Failed to establish database connection.";
	exit();
      }
    
    // Open the Solid-State database
    if( !@mysql_select_db( $conf['db']['database'], $this->dbh ) )
      {
	// Failed to open Solid-State database
	echo "Failed to open database " . $conf['db']['database'];
	exit();
      }
  }

  /**
   * Format DATETIME
   *
   * Convert a UNIX timestamp into a MySQL DATETIME
   *
   * @param integer $timestamp UNIX timestamp
   * @return string MySQL DATETIME
   */
  function format_datetime( $timestamp )
  {
    return date( "Y-m-d H:i:s",
		 $timestamp );
  }

  /**
   * MySQL DATETIME to UNIX timestamp
   *
   * Convert a MySQL DATETIME into a UNIX timestamp
   *
   * @param string $datetime MySQL DATETIME
   * @return integer UNIX timestamp
   */
  function datetime_to_unix( $datetime )
  {
    // Parse the datetime
    $year   = intval( substr( $datetime, 0, 4 ) );
    $month  = intval( substr( $datetime, 5, 2 ) );
    $day    = intval( substr( $datetime, 8, 2 ) );
    $hour   = intval( substr( $datetime, 11, 2 ) );
    $minute = intval( substr( $datetime, 14, 2 ) );
    $second = intval( substr( $datetime, 17, 2 ) );

    // Convert to a timestamp a la Unix
    return mktime( $hour, $minute, $second, $month, $day, $year );
  }

  /**
   * Build INSERT SQL
   *
   * Builds a straight-forward INSERT command from a list of columns & values
   *
   * @param string $table_name Table to INSERT into
   * @param array $cols_vals An array with column names as keys and data as values
   * @return string SQL
   */
  function build_insert_sql( $table_name, $cols_vals )
  {
    // Extract the column names
    $cols = array_keys( $cols_vals );

    // Validate table name
    if( !isset( $table_name ) || !$this->validate_table( $table_name ) )
      {
	// Table name not provided or invalid - return nothing
	return null;
      }

    // Begin building SQL
    $sql = "INSERT INTO `" . $table_name . "` (";

    // Build column list
    foreach( $cols as $column_name )
      {
	// Put this column name in the list
	$sql .= $column_name;
	$sql .= $column_name == end( $cols ) ? ") " : ", ";
      }

    $sql .= "VALUES (";

    // Build values list
    foreach( $cols_vals as $column_name => $value )
      {
	// Put this value in the list
	$sql .= is_numeric( $value ) ? $value : $this->quote_smart( $value );
	$sql .= $column_name == end( $cols ) ? ")" : ", ";
      }

    return $sql;
  }

  /**
   * Build Delete SQL
   *
   * Build a DELETE query
   *
   * @param string $table_name Table to delete from
   * @param string $where WHERE clause (must be valid SQL)
   * @return string SQL
   */
  function build_delete_sql( $table_name, $where )
  {
    // Validate table name
    if( !isset( $table_name ) || !$this->validate_table( $table_name ) )
      {
	// Table name not provided or invalid - return nothing
	return null;
      }

    // Begin building SQL
    $sql = sprintf( "DELETE FROM `%s`", $table_name );

    if( isset( $where ) )
      {
	$sql .= " WHERE " . $where;
      }

    return $sql;
  }

  /**
   * Build Update SQL
   *
   * Builds a straight-forward UPDATE command from a list of columns & values.
   *
   * @param string $table_name Table to UPDATE
   * @param string $where WHERE clause (must be valid SQL)
   * @param array $cols_vals An array that maps columns (key) and values
   * @return string SQL
   */
  function build_update_sql( $table_name, $where, $cols_vals )
  {
    // Validate table name
    if( !isset( $table_name ) || !$this->validate_table( $table_name ) )
      {
	// Table name not provided or invalid - return nothing
	return null;
      }

    // Begin building SQL
    $sql = sprintf( "UPDATE `%s` SET ", $table_name );

    // Build & validate column & value pairs
    foreach( $cols_vals as $column => $value )
      {
	// Validate this column
	if( !$this->validate_column( $column, $table_name ) )
	  {
	    echo "Invalid column " . $column;
	    exit();
	  }

	$sql .= $column . " = ";

	if( is_numeric( $value ) )
	  {
	    // Numeric - don't use quotes
	    $sql .= $value;
	  }
	else
	  {
	    // Not numeric - use quotes
	    $sql .= $this->quote_smart( $value );
	  }

	if( !($column == end( array_keys( $cols_vals ) ) ) )
	  {
	    // Add a comma after every value except the last
	    $sql .= ", ";
	  }
      }
    
    // Validate & build WHERE clause
    if( !isset( $where ) )
      {
	// No where class provided, return nothing
	return null;
      }
    $sql .= " WHERE " . $where;

    return $sql;
  }

  /**
   * Build Select SQL
   *
   * Build a SELECT command using specific parameters
   *
   * @param string $table_name Table to query
   * @param array $columns An array of column to be returned by the query
   * @param string $filter A WHERE clause, minus the WHERE
   * @param string $sortby Name of a column to sort the results by
   * @param string $sortdir Direction to sort the resuts in (ASEC or DESC)
   * @param integer $limit Number of rows to limit the results to
   * @param integer $start Starting position for the result set to be returned
   * @return string SQL
   */
  function build_select_sql( $table_name, 
			     $columns, 
			     $filter = null, 
			     $sortby = null, 
			     $sortdir = null, 
			     $limit = null, 
			     $start = null )
  {
    // Validate table name
    if( !isset( $table_name ) || !$this->validate_table( $table_name ) )
      {
	// Table name not provided or invalid - return nothing
	return null;
      }
    
    // Validate columns
    if( !isset( $columns ) )
      {
	// No columns provided - default to all
	$columns = "*";
      }
    
    // Begin building SELECT statement
    $sql = sprintf( "SELECT %s FROM `%s`", $columns, $table_name );
    
    if( strlen( $filter ) > 0 )
      {
	// A filter is provided - add a WHERE clause to the SQL
	$sql .= " WHERE " . $filter;
      }

    // Validate sortby
    if( strlen( $sortby ) > 0 && $this->validate_column( $sortby, $table_name ) )
      {
	// A field to sort on is provided - add an ORDER BY clause
	$sql .= " ORDER BY " . $sortby;
	if( strlen( $sortdir ) > 0 && ($sortdir == "ASC" || $sortdir == "DESC") )
	  {
	    // While we're at it, add a direction to the ORDER BY clause
	    $sql .= " " . $sortdir;
	  }
      }

    if( strlen( $limit ) > 0 )
      {
	// Limit the amount of records returned
	if( !(strlen( $start ) > 0) )
	  {
	    // No starting position is supplied - default to 0
	    $start = 0;
	  }
	$sql .= " LIMIT " . intval( $start ) . "," . intval( $limit );
      }
    
    return $sql;
  }

  /**
   * Validate Column
   *
   * Verify that a column exists in a given table
   *
   * @param string $column_name Column
   * @param string $table_name Table
   * @return boolean True if column exists
   */
  function validate_column( $column_name, $table_name )
  {
    // Validate table name
    if( !$this->validate_table( $table_name ) )
      {
	return false;
      }
    
    // Query DB for a list of columns in this table
    $sql = sprintf( "SHOW COLUMNS FROM `%s`", $table_name );
    if( !($result = @mysql_query( $sql, $this->handle() ) ) )
      {
	// Query error
	fatal_error( "DBConnection::validate_column()",
		     sprintf( "Attempt to query table columns failed.  Table = %s, column = %s",
			      $table_name,
			      $column_name ) );
      }

    // Search result set for the column name provided
    while( $data = mysql_fetch_array( $result ) )
      {
	if( $data[0] == $column_name )
	  {
	    // Match!
	    return true;
	  }
      }
    
    // No match
    return false;
  }

  /**
   * Validate Table
   *
   * Verify that a given table exists in the database
   *
   * @param string $table_name Table name
   * @return boolean True if table exists
   */
  function validate_table( $table_name )
  {
    // Query DB for a list of tables
    $sql = "SHOW TABLES";
    if( !($result = @mysql_query( $sql, $this->handle() ) ) )
      {
	// Query error
	echo "Attempt to query database tables failed.";
	exit();
      }
    
    // Search result set for the table name provided
    while( $data = mysql_fetch_array( $result ) )
      {
	if( $data[0] == $table_name )
	  {
	    // Match!
	    return true;
	  }
      }
    
    // No match
    return false;
  }

  /**
   * Quote Smart
   *
   * Adds the proper escape sequences to a string about to be inserted into the
   * database.
   *
   * @param string $value Value to quote
   * @return string Safe value with quotes
   */
  function quote_smart( $value )
  {
    // Stripslashes
    if( get_magic_quotes_gpc() ) 
      {
	$value = stripslashes( $value );
      }

    // Quote if not integer
    if( !is_numeric( $value ) ) 
      {
	$value = "'" . mysql_real_escape_string( $value, $this->handle() ) . "'";
      }

    return $value;
  }

}
?>
