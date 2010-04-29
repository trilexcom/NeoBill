<?php
/**
 * CPanelServerDBO.class.php
 *
 * This file contains the definition for the CPanelServerDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * CPanelServerDBO
 *
 * Represents a server configuration for the cPanel module.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CPanelServerDBO extends DBO {
    /**
     * @var string WHM Acccess Hash
     */
    protected $accessHash = null;

    /**
     * @var integer Server ID
     */
    protected $serverID = null;

    /**
     * @var string WHM Username
     */
    protected $username = null;

    /**
     * Convert to a String
     *
     * @return string Server ID
     */
    public function __toString() {
        return $this->getServerID();
    }

    /**
     * Get Access Hash
     *
     * @return string CPanel Access Hash
     */
    public function getAccessHash() {
        return $this->accessHash;
    }

    /**
     * Get Server ID
     *
     * @return integer Server ID
     */
    public function getServerID() {
        return $this->serverID;
    }

    /**
     * Get WHM Username
     *
     * @return string WHM Username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set WHM Access Hash
     *
     * @param string $accessHash WHM Access Hash for this server
     */
    public function setAccessHash( $accessHash ) {
        $this->accessHash = $accessHash;
    }

    /**
     * Set Server ID
     *
     * @param integer Server ID
     */
    public function setServerID( $serverID ) {
        $this->serverID = $serverID;
    }

    /**
     * Set WHM Username
     *
     * @param string $username WHM Username
     */
    public function setUsername( $username ) {
        $this->username = $username;
    }
}

/**
 * Inser or Update a CPanelServerDBO
 *
 * @param CPanelServerDBO $dbo CPanelServerDBO to be added/updated
 * @return boolean True on success
 */
function addOrUpdate_CPanelServerDBO( CPanelServerDBO $dbo ) {
    try {
        load_CPanelServerDBO( $dbo->getServerID() );

        // Update
        update_CPanelServerDBO( $dbo );
    }
    catch( DBNoRowsFoundException $e ) {
        // Add
        add_CPanelServerDBO( $dbo );
    }
}

/**
 * Insert CPanelServerDBO into database
 *
 * @param CPanelServerDBO $dbo CPanelServerDBO to add to database
 */
function add_CPanelServerDBO( CPanelServerDBO $dbo ) {
    $DB = DBConnection::getDBConnection();

    // Build SQL
    $sql = $DB->build_insert_sql( "cpanelserver",
            array( "serverid" => $dbo->getServerID(),
            "username" => $dbo->getUsername(),
            "accesshash" => $dbo->getAccessHash() ) );

    // Run query
    if( !mysql_query( $sql, $DB->handle() ) ) {
        throw new DBException( mysql_error( $DB->handle() ) );
    }
}

/**
 * Update CPanelServerDBO in database
 *
 * @param CPanelServerDBO $dbo CPanelServerDBO to update
 */
function update_CPanelServerDBO( CPanelServerDBO $dbo ) {
    $DB = DBConnection::getDBConnection();

    // Build SQL
    $sql = $DB->build_update_sql( "cpanelserver",
            "serverid = " . $dbo->getServerID(),
            array( "username" => $dbo->getUsername(),
            "accesshash" => $dbo->getAccessHash() ) );

    // Run query
    if( !mysql_query( $sql, $DB->handle() ) ) {
        throw new DBException( mysql_error( $DB->handle() ) );
    }
}

/**
 * Delete CPanelServerDBO from database
 *
 * @param CPanelServerDBO $dbo CPanelServerDBO to delete
 * @return boolean True on success
 */
function delete_CPanelServerDBO( CPanelServerDBO $dbo ) {
    $DB = DBConnection::getDBConnection();

    // Build DELETE query
    $sql = $DB->build_delete_sql( "cpanelserver",
            "serverid = " . $dbo->getServerID() );

    // Run query
    if( !mysql_query( $sql, $DB->handle() ) ) {
        throw new DBException( mysql_error( $DB->handle() ) );
    }
}

/**
 * Load a CPanelServerDBO from the database
 *
 * @param integer Server ID
 * @return CPanelServerDBO CPanelServerDBO, or null if not found
 */
function load_CPanelServerDBO( $serverID ) {
    $DB = DBConnection::getDBConnection();

    // Build query
    $sql = $DB->build_select_sql( "cpanelserver",
            "*",
            "serverid=" . intval( $serverID ),
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

    // Load a new CPanelServerDBO
    $dbo = new CPanelServerDBO();
    $data = mysql_fetch_array( $result );
    $dbo->load( $data );

    // Return the new UserDBO
    return $dbo;
}

/**
 * Load multiple CPanelServerDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of HostingServiceDBO's
 */
function &load_array_CPanelServerDBO( $filter = null,
        $sortby = null,
        $sortdir = null,
        $limit = null,
        $start = null ) {
    $DB = DBConnection::getDBConnection();

    // Build query
    $sql = $DB->build_select_sql( "cpanelserver",
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

    // Build an array of HostingServiceDBOs from the result set
    $server_dbo_array = array();
    while( $data = mysql_fetch_array( $result ) ) {
        // Create and initialize a new ServerDBO with the data from the DB
        $dbo = new CPanelServerDBO();
        $dbo->load( $data );

        // Add ServerDBO to array
        $server_dbo_array[] = $dbo;
    }

    return $server_dbo_array;
}
?>