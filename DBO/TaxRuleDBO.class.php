<?php
/**
 * TaxRuleDBO.class.php
 *
 * This file contains the definition for the TaxRuleDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * TaxRuleDBO
 *
 * Represent a tax rule.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TaxRuleDBO extends DBO {
	/**
	 * @var integer Tax rule ID
	 */
	var $id;

	/**
	 * @var string Country code
	 */
	var $country;

	/**
	 * @var string State
	 */
	var $state;

	/**
	 * @var string All-states flag
	 */
	var $allstates;

	/**
	 * @var string Description
	 */
	var $description;

	/**
	 * Convert to a String
	 *
	 * @return string Tax Rule ID
	 */
	function __toString() {
		return $this->getID();
	}

	/**
	 * Set Tax Rule ID
	 *
	 * @param integer $id Tax Rule ID
	 */
	function setID( $id ) {
		$this->id = $id;
	}

	/**
	 * Get Tax Rule ID
	 *
	 * @return integer Tax Rule ID
	 */
	function getID() {
		return $this->id;
	}

	/**
	 * Set Country Code
	 *
	 * @param string $cc Country Code
	 */
	function setCountry( $country ) {
		global $cc;

		if( !isset( $cc[$country] ) ) {
			fatal_error( "TaxRuleDBO::setCountry()", "Invalid country code: " . $cc );
		}
		$this->country = $country;
	}

	/**
	 * Get Country Code
	 *
	 * @return string Country Code
	 */
	function getCountry() {
		return $this->country;
	}

	/**
	 * Set State
	 *
	 * @param string $state State
	 */
	function setState( $state ) {
		$this->state = $state;
	}

	/**
	 * Get State
	 *
	 * @return string State
	 */
	function getState() {
		return $this->state;
	}

	/**
	 * Set Tax Rate
	 *
	 * @param double $rate Tax rate
	 */
	function setRate( $rate ) {
		if( $rate >= 100.00 || $rate <= 0.00 ) {
			fatal_error( "TaxRuleDBO::setRate", "Invalid value: " . $rate );
		}
		$this->rate = $rate;
	}

	/**
	 * Get Tax Rate
	 *
	 * @return double Tax rate
	 */
	function getRate() {
		return $this->rate;
	}

	/**
	 * Set All-states Flag
	 *
	 * @param string $allstate 'Yes' if all states are affected by this tax rule, 'Specific' if otherwise
	 */
	function setAllStates( $allstates ) {
		if( !($allstates == "Yes" || $allstates == "Specific") ) {
			fatal_error( "TaxRuleDBO::setAllState", "Invalid value: " . $allstates );
		}
		$this->allstates = $allstates;
	}

	/**
	 * Get All-states Flag
	 *
	 * @return string All-states flag
	 */
	function getAllStates() {
		return $this->allstates;
	}

	/**
	 * Set Description
	 *
	 * @param string $description Description
	 */
	function setDescription( $description ) {
		$this->description = $description;
	}

	/**
	 * Get Description
	 *
	 * @return string Description
	 */
	function getDescription() {
		return $this->description;
	}

	/**
	 * Load Member Data from Array
	 *
	 * @param array $data Data to load
	 */
	function load( $data ) {
		$this->setID( $data['id'] );
		$this->setCountry( $data['country'] );
		$this->setState( $data['state'] );
		$this->setRate( $data['rate'] );
		$this->setAllStates( $data['allstates'] );
		$this->setDescription( $data['description'] );
	}
}

/**
 * Add TaxRuleDBO to Database
 *
 * @param TaxRuleDBO &$dbo TaxRuleDBO to be added to database
 */
function add_TaxRuleDBO( &$dbo ) {
	$DB = DBConnection::getDBConnection();

	// Build SQL
	$sql = $DB->build_insert_sql( "taxrule",
			array( "country" => $dbo->getCountry(),
			"state" => $dbo->getState(),
			"rate" => $dbo->getRate(),
			"allstates" => $dbo->getAllStates(),
			"description" => $dbo->getDescription() ) );
	// Run query
	if( !mysql_query( $sql, $DB->handle() ) ) {
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	// Get auto-increment ID
	$id = mysql_insert_id( $DB->handle() );

	// Validate ID
	if( $id === false ) {
		// DB error
		throw new DBException( "Could not retrieve ID from previous INSERT!" );
	}
	if( $id == 0 ) {
		// No ID?
		throw new DBException( "Previous INSERT did not generate an ID" );
	}

	// Store ID in DBO
	$dbo->setID( $id );
}

/**
 * Update TaxRuleDBO
 *
 * @param TaxRuleDBO &$dbo TaxRuleDBO to be updated
 */
function update_TaxRuleDBO( &$dbo ) {
	$DB = DBConnection::getDBConnection();

	// Build SQL
	$sql = $DB->build_update_sql( "taxrule",
			"id = " . intval( $dbo->getID() ),
			array( "country" => $dbo->getCountry(),
			"state" => $dbo->getState(),
			"rate" => $dbo->getRate(),
			"allstates" => $dbo->getAllStates(),
			"description" => $dbo->getDescription() ) );

	// Run query
	if( !mysql_query( $sql, $DB->handle() ) ) {
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	return true;
}

/**
 * Delete TaxRuleDBO from Database
 *
 * @param TaxRuleDBO &$dbo TaxRuleDBO to be deleted
 * @return boolean True on success
 */
function delete_TaxRuleDBO( &$dbo ) {
	$DB = DBConnection::getDBConnection();

	// Build SQL
	$sql = $DB->build_delete_sql( "taxrule",
			"id = " . intval( $dbo->getID() ) );

	// Run query
	if( !mysql_query( $sql, $DB->handle() ) ) {
		throw new DBException( mysql_error( $DB->handle() ) );
	}
}

/**
 * Load TaxRuleDBO from Database
 *
 * @param integer $id TaxRule ID
 * @return TaxRuleDBO Tax rule or null if not found
 */
function load_TaxRuleDBO( $id ) {
	$DB = DBConnection::getDBConnection();

	// Build query
	$sql = $DB->build_select_sql( "taxrule",
			"*",
			"id=" . intval( $id ),
			null,
			null,
			null,
			null );

	// Run query
	if( !($result = @mysql_query( $sql, $DB->handle() ) ) ) {
		// Query error
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	if( mysql_num_rows( $result ) == 0 ) {
		// No rows found
		throw new DBNoRowsFoundException();
	}

	// Load a new HostingServiceDBO
	$dbo = new TaxRuleDBO();
	$data = mysql_fetch_array( $result );
	$dbo->load( $data );

	// Return the new UserDBO
	return $dbo;
}

/**
 * Load multiple TaxRuleDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of TaxRuleDBO's
 */
function &load_array_TaxRuleDBO( $filter = null,
		$sortby = null,
		$sortdir = null,
		$limit = null,
		$start = null ) {
	$DB = DBConnection::getDBConnection();

	// Build query
	$sql = $DB->build_select_sql( "taxrule",
			"*",
			$filter,
			$sortby,
			$sortdir,
			$limit,
			$start );

	// Run query
	if( !( $result = @mysql_query( $sql, $DB->handle() ) ) ) {
		// Query error
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	if( mysql_num_rows( $result ) == 0 ) {
		// No services found
		throw new DBNoRowsFoundException();
	}

	// Build an array of DBOs from the result set
	$dbo_array = array();
	while( $data = mysql_fetch_array( $result ) ) {
		// Create and initialize a new DBO with the data from the DB
		$dbo = new TaxRuleDBO();
		$dbo->load( $data );

		// Add TaxRuleDBO to array
		$dbo_array[] = $dbo;
	}

	return $dbo_array;
}

/**
 * Count TaxRuleDBO's
 *
 * Same as load_array_TaxRuleDBO, except this function just COUNTs the
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of TaxRule records
 */
function count_all_TaxRuleDBO( $filter = null ) {
	$DB = DBConnection::getDBConnection();

	// Build query
	$sql = $DB->build_select_sql( "taxrule",
			"COUNT(*)",
			$filter,
			null,
			null,
			null,
			null );

	// Run query
	if( !( $result = @mysql_query( $sql, $DB->handle() ) ) ) {
		// SQL error
		throw new DBException( mysql_error( $DB->handle() ) );
	}

	// Make sure the number of rows returned is exactly 1
	if( mysql_num_rows( $result ) != 1 ) {
		// This must return 1 row
		throw new DBException( "Expected exactly one row from count query" );
	}

	$data = mysql_fetch_array( $result );
	return $data[0];
}
?>