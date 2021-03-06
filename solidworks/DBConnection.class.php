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

require_once dirname(__FILE__).'/../config/config.inc.php';
require_once BASE_PATH . "solidworks/DBO.class.php";
require_once BASE_PATH . "solidworks/SWException.class.php";

// Database Exceptions
class DBException extends SWUserException {
	public function __construct( $message = null ) {
		$this->message = isset( $message ) ?
				$message :
				sprintf( "A database error has occured:\n\t " . mysql_error() );
	}
}

class DBNoRowsFoundException extends DBException {
	public function __construct( $message = null ) {
		$this->message = 'No rows found' . (!is_null( $message ) ? ' - ' . $message : '');
	}
}

/**
 * DBConnection
 *
 * Handles interaction with a MySQL database for the framework.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DBConnection {
	/**
	 * @var static DBConnection Singleton instance
	 */
	protected static $instance = null;

	/**
	 * MySQL DATETIME to UNIX timestamp
	 *
	 * Convert a MySQL DATETIME into a UNIX timestamp
	 *
	 * @param string $datetime MySQL DATETIME
	 * @return integer UNIX timestamp
	 */
	public static function datetime_to_unix( $datetime ) {
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
	 * MySQL DATE to UNIX timestamp
	 *
	 * Convert a MySQL DATE into a UNIX timestamp
	 *
	 * @param string $datetime MySQL DATE
	 * @return integer UNIX timestamp
	 */
	public static function date_to_unix( $datetime ) {
		// Parse the datetime
		$year   = intval( substr( $datetime, 0, 4 ) );
		$month  = intval( substr( $datetime, 5, 2 ) );
		$day    = intval( substr( $datetime, 8, 2 ) );

		// Convert to a timestamp a la Unix
		return mktime( 0, 0, 1, $month, $day, $year );
	}

	/**
	 * Format DATETIME
	 *
	 * Convert a UNIX timestamp into a MySQL DATETIME
	 *
	 * @param integer $timestamp UNIX timestamp
	 * @return string MySQL DATETIME
	 */
	public static function format_datetime( $timestamp ) {
		return date( "Y-m-d H:i:s", $timestamp );
	}

	/**
	 * Format DATE
	 *
	 * Convert a UNIX timestamp into a MySQL DATE
	 *
	 * @param integer $timestamp UNIX timestamp
	 * @return string MySQL DATE
	 */
	public static function format_date( $timestamp ) {
		return date( "Y-m-d", $timestamp );
	}

	/**
	 * Get DB Connection Instance
	 *
	 * The DBConnection class is a singleton.  You may only construct one
	 * DBConnection object and it must be done by calling this static method.
	 *
	 * @return DBConnection DBConnection instance
	 */
	public static function getDBConnection() {

		if ( self::$instance == null ) {
			self::$instance = new DBConnection();
		}

		return self::$instance;
	}

	/**
	 * @var object Database handle
	 */
	protected $dbh = null;

	/**
	 * Default constructor
	 *
	 * Initializes the database handle
	 */
	protected function __construct() {
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
	public function handle() {
		if ( $this->dbh == null ) {
			// Not connected.  Yet.
			$this->connect();
		}

		return $this->dbh;
	}

	/**
	 * Connect to the database server
	 */
	public function connect() {
		global $db;

		// Open a connection to the database server
		$this->dbh = @mysql_connect( $db['hostname'],
				$db['username'],
				base64_decode( $db['password'] ) );
		if ( $this->dbh == null ) {
			// Connection failed
			throw new DBException( "DB Connection failure: " . mysql_error() );
		}

		// Open the Solid-State database
		if ( !@mysql_select_db( $db['database'], $this->dbh ) ) {
			// Failed to open Solid-State database
			throw new DBException( "DB Select Database failure: " . mysql_error() );
		}
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
	public function build_insert_sql( $table_name, $cols_vals ) {
		// Extract the column names
		$cols = array_keys( $cols_vals );

		// Validate table name
		if ( !isset( $table_name ) || !$this->validate_table( $table_name ) ) {
			// Table name not provided or invalid
			throw new DBException( "Invalid table: " . $table_name );
		}
		
		//$stmt = mysqli_prepare($link, "SELECT District FROM City WHERE Name=?"
		// Begin building SQL
		$sql = "INSERT INTO `" . $table_name . "` (";

		// Build column list
		foreach( $cols as $column_name ) {
			// Put this column name in the list
			$sql .= $column_name;
			$sql .= $column_name == end( $cols ) ? ") " : ", ";
		}

		$sql .= "VALUES (";

		// Build values list
		foreach( $cols_vals as $column_name => $value ) {
			// Put this value in the list
			$sql .= is_numeric( $value ) ? $value : $this->quote_smart( $value );
			$sql .= $column_name == end( $cols ) ? ")" : ", ";
		}

		return $sql;
	}
	
	public function build_insert_sql_secure( $table_name, $cols_vals ) {
		// Extract the column names
		$cols = array_keys( $cols_vals );

		// Validate table name
		if ( !isset( $table_name ) || !$this->validate_table( $table_name ) ) {
			// Table name not provided or invalid
			throw new DBException( "Invalid table: " . $table_name );
		}
		
		
		// Begin building SQL
		$sql = "INSERT INTO `" . $table_name . "` (";

		// Build column list
		foreach( $cols as $column_name ) {
			// Put this column name in the list
			$sql .= $column_name;
			$sql .= $column_name == end( $cols ) ? ") " : ", ";
		}

		$sql .= "VALUES (";

		// Build values list
		foreach( $cols_vals as $column_name => $value ) {
			// Put this value in the list
			$sql .= "?"; //is_numeric( $value ) ? $value : $this->quote_smart( $value );
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
	public function build_delete_sql( $table_name, $where ) {
		// Validate table name
		if ( !isset( $table_name ) || !$this->validate_table( $table_name ) ) {
			// Table name not provided or invalid - return nothing
			throw new DBException( "Invalid table: " . $table_name );
		}

		// Begin building SQL
		$sql = sprintf( "DELETE FROM `%s`", $table_name );

		if ( isset( $where ) ) {
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
	public function build_update_sql( $table_name, $where, $cols_vals ) {
		// Validate table name
		if ( !isset( $table_name ) || !$this->validate_table( $table_name ) ) {
			// Table name not provided or invalid - return nothing
			throw new DBException( "Invalid table: " . $table_name );
		}

		// Begin building SQL
		$sql = sprintf( "UPDATE `%s` SET ", $table_name );

		// Build & validate column & value pairs
		foreach( $cols_vals as $column => $value ) {
			// Validate this column
			if ( !$this->validate_column( $column, $table_name ) ) {
				throw new DBException( "Invalid table column: " . $column );
			}

			$sql .= $column . " = ";

			if ( is_numeric( $value ) ) {
				// Numeric - don't use quotes
				$sql .= $value;
			}
			else {
				// Not numeric - use quotes
				$sql .= $this->quote_smart( $value );
			}

			if ( !($column == end( array_keys( $cols_vals ) ) ) ) {
				// Add a comma after every value except the last
				$sql .= ", ";
			}
		}

		// Validate & build WHERE clause
		if ( !isset( $where ) ) {
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
	public function build_select_sql( $table_name,
			$columns,
			$filter = null,
			$sortby = null,
			$sortdir = null,
			$limit = null,
			$start = null ) {
		// Validate table name
		if ( !isset( $table_name ) || !$this->validate_table( $table_name ) ) {
			// Table name not provided or invalid - return nothing
			throw new DBException( "Invalid table: " . $table_name );
		}

		// Validate columns
		if ( !isset( $columns ) ) {
			// No columns provided - default to all
			$columns = "*";
		}

		// Begin building SELECT statement
		$sql = sprintf( "SELECT %s FROM `%s`", $columns, $table_name );

		if ( strlen( $filter ) > 0 ) {
			// A filter is provided - add a WHERE clause to the SQL
			$sql .= " WHERE " . $filter;
		}

		// Validate sortby
		if ( strlen( $sortby ) > 0 && $this->validate_column( $sortby, $table_name ) ) {
			// A field to sort on is provided - add an ORDER BY clause
			$sql .= " ORDER BY " . $sortby;
			if ( strlen( $sortdir ) > 0 && ($sortdir == "ASC" || $sortdir == "DESC") ) {
				// While we're at it, add a direction to the ORDER BY clause
				$sql .= " " . $sortdir;
			}
		}

		if ( strlen( $limit ) > 0 ) {
			// Limit the amount of records returned
			if ( !(strlen( $start ) > 0) ) {
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
	public function validate_column( $column_name, $table_name ) {
		if ( !$db['schema_validation'] ) {
			return true;
		}

		// Validate table name
		if ( !$this->validate_table( $table_name ) ) {
			return false;
		}

		// Query DB for a list of columns in this table
		$sql = sprintf( "SHOW COLUMNS FROM `%s`", $table_name );
		if ( !($result = @mysql_query( $sql, $this->handle() ) ) ) {
			// Query error
			throw new DBException( sprintf( "Attempt to query table columns failed.  Table = %s, column = %s",
			$table_name,
			$column_name ) );
		}

		// Search result set for the column name provided
		while( $data = mysql_fetch_array( $result ) ) {
			if ( $data[0] == $column_name ) {
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
	public function validate_table( $table_name ) {
		if ( !$db['schema_validation'] ) {
			return true;
		}

		// Query DB for a list of tables
		$sql = "SHOW TABLES";
		if ( !($result = @mysql_query( $sql, $this->handle() ) ) ) {
			// Query error
			throw new DBException( "Attempt to validate table failed" );
		}

		// Search result set for the table name provided
		while( $data = mysql_fetch_array( $result ) ) {
			if ( $data[0] == $table_name ) {
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
	public function quote_smart( $value ) {
		// Stripslashes
		if ( get_magic_quotes_gpc() ) {
			$value = stripslashes( $value );
		}

		// Quote if not integer
		if ( !is_numeric( $value ) ) {
			$value = "'" . mysql_real_escape_string( $value, $this->handle() ) . "'";
		}

		return $value;
	}
	
	public function mysqli_connect(){
	
		global $db;
		$mysqli = mysqli_connect($db['hostname'],
				$db['username'],
				base64_decode( $db['password']),
				$db['database']
				);		
		/* check connection */
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}
		return $mysqli;
	}
}
?>