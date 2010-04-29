<?php
/**
 * HostingServicePurchaseDBO.class.php
 *
 * This file contains the definition for the HostingServicePurchaseDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * HostingServicePurchaseDBO
 *
 * Represents a hosting service purchase by a customer.  Each time a customer is
 * assigned a hosting servic, a HostingServicePurchaseDBO is created.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingServicePurchaseDBO extends PurchaseDBO {
    /**
     * @var integer HostingServicePurchase ID
     */
    protected $id;

    /**
     * @var integer Account ID
     */
    protected $accountid;

    /**
     * @var AccountDBO Account that purchased this hosting service
     */
    protected $accountdbo;

    /**
     * @var string Domain Name
     */
    protected $domainName;

    /**
     * @var integer Hosting service ID
     */
    protected $hostingserviceid;

    /**
     * @var integer Server ID
     */
    protected $serverid;

    /**
     * @var ServerDBO Server this hosting service purchase is assigned to
     */
    protected $serverdbo;

    /**
     * Convert to a String
     *
     * @return string Hosting service ID
     */
    public function __toString() {
        return $this->getID();
    }

    /**
     * Set Hosting Service Purchase ID
     *
     * @param integer $id Hosting service purchase ID
     */
    public function setID( $id ) {
        $this->id = $id;
    }

    /**
     * Get Hosting Service Purchase ID
     *
     * @return integer Hosting service purchase ID
     */
    public function getID() {
        return $this->id;
    }

    /**
     * Set Account ID
     *
     * @param integer $id Account ID
     */
    public function setAccountID( $id ) {
        $this->accountid = $id;
        $this->accountdbo = load_AccountDBO( $id );
    }

    /**
     * Get Account ID
     *
     * @return integer Account ID
     */
    public function getAccountID() {
        return $this->accountid;
    }

    /**
     * Get Account Name
     *
     * @return string Account name
     */
    public function getAccountName() {
        return $this->accountdbo->getAccountName();
    }

    /**
     * Get Account DBO
     *
     * @return AccountDBO The account this purchase belongs to
     */
    public function getAccountDBO() {
        return $this->accountdbo;
    }

    /**
     * Set Purchasable
     *
     * @param HostingServiceDBO The hosting service that is/was purchased
     */
    public function setPurchasable( HostingServiceDBO $serviceDBO ) {
        // This function is meant to force purchasable to be a HostingServiceDBO
        parent::setPurchasable( $serviceDBO );
    }

    /**
     * Set Hosting Service ID
     *
     * @param integer $id Hosting Service ID
     */
    public function setHostingServiceID( $id ) {
        $this->setPurchasable( load_HostingServiceDBO( $id ) );
    }

    /**
     * Get Hosting Service ID
     *
     * @return integer Hosting service ID
     */
    public function getHostingServiceID() {
        return $this->purchasable->getID();
    }

    /**
     * Set Domain Name
     *
     * @param string $domainName The primary hosted domain
     */
    public function setDomainName( $domainName ) {
        $this->domainName = $domainName;
    }

    /**
     * Get Domain Name
     *
     * @return string Primary hosted domain name
     */
    public function getDomainName() {
        return $this->domainName;
    }

    /**
     * Is Domain Required
     *
     * @return boolean True when the service requires a domain to be assigned
     */
    public function isDomainRequired() {
        return $this->purchasable->isDomainRequired();
    }

    /**
     * Set Server ID
     *
     * @param integer $id Server ID
     */
    public function setServerID( $id ) {
        $id = intval( $id );
        if( $id < 1 ) {
            // Not assigned to a server
            $serverid = null;
            $serverdbo = null;
            return;
        }

        $this->serverid = $id;
        $this->serverdbo = load_ServerDBO( $id );
    }

    /**
     * Get Server ID
     *
     * @return integer Server ID
     */
    public function getServerID() {
        return $this->serverid;
    }

    /**
     * Get Server DBO
     *
     * @return ServerDBO The server DBO configured for this purchase
     */
    public function getServerDBO() {
        return $this->serverdbo;
    }

    /**
     * Get Server Hostname
     *
     * @return string Server hostname, or "Not Assigned" if there is no assigned server
     */
    public function getHostName() {
        if( !isset( $this->serverdbo ) ) {
            return "Not Assigned";
        }
        return $this->serverdbo->getHostName();
    }

    /**
     * Get Hosting Service Title
     *
     * @return string Hosting service title
     */
    public function getTitle() {
        return $this->purchasable->getTitle();
    }

    /**
     * Get Description for "Recurring" Line Item
     *
     * @return string The text that should appear on the invoice for this purchase
     */
    public function getLineItemTextRecurring() {
        $domain = $this->getDomainName();
        $term = $this->getTerm();
        return sprintf( "%s%s ([TERM]: %d %s)",
                $this->getTitle(),
                $domain != null ? ": " . $domain : null,
                $term,
                $term > 1 ? "[MONTHS]" : "[MONTH]" );
    }
}

/**
 * Insert HostingServicePurchaseDBO into database
 *
 * @param HostingServicePurchaseDBO &$dbo HostingServicePurchaseDBO to add to database
 */
function add_HostingServicePurchaseDBO( &$dbo ) {
    $DB = DBConnection::getDBConnection();

    // Build SQL
    $sql = $DB->build_insert_sql( "hostingservicepurchase",
            array( "accountid" => intval( $dbo->getAccountID() ),
            "hostingserviceid" => intval( $dbo->getHostingServiceID() ),
            "serverid" => intval( $dbo->getServerID() ),
            "term" => $dbo->getTerm(),
            "domainname" => $dbo->getDomainName(),
            "date" => $dbo->getDate(),
            "nextbillingdate" => $dbo->getNextBillingDate(),
            "previnvoiceid" => $dbo->getPrevInvoiceID(),
            "note" => $dbo->getNote() ) );

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
 * Update HostingServicePurchaseDBO in database
 *
 * @param HostingServicePurchaseDBO &$dbo HostingServicePurchaseDBO to update
 */
function update_HostingServicePurchaseDBO( &$dbo ) {
    $DB = DBConnection::getDBConnection();

    // Build SQL
    $sql = $DB->build_update_sql( "hostingservicepurchase",
            "id = " . intval( $dbo->getID() ),
            array( "term" => $dbo->getTerm(),
            "serverid" => intval( $dbo->getServerID() ),
            "domainname" => $dbo->getDomainName(),
            "date" => $dbo->getDate(),
            "nextbillingdate" => $dbo->getNextBillingDate(),
            "previnvoiceid" => $dbo->getPrevInvoiceID(),
            "note" => $dbo->getNote() ) );

    // Run query
    if( !mysql_query( $sql, $DB->handle() ) ) {
        throw new DBException( mysql_error( $DB->handle() ) );
    }
}

/**
 * Delete HostingServicePurchaseDBO from database
 *
 * @param HostingServicePurchaseDBO &$dbo HostingServicePurchaseDBO to delete
 * @return True on success
 */
function delete_HostingServicePurchaseDBO( &$dbo ) {
    $DB = DBConnection::getDBConnection();

    // Release any IP Addresses assigned to this purchase
    try {
        $ip_dbo_array = load_array_IPAddressDBO( "purchaseid = " . $dbo->getID() );
        foreach( $ip_dbo_array as $ip_dbo ) {
            // Remove IP address from this purchase
            $ip_dbo->setPurchaseID( 0 );
            update_IPAddressDBO( $ip_dbo );
        }
    }
    catch( DBNoRowsFoundException $e ) {

    }

    // Build DELETE query
    $sql = $DB->build_delete_sql( "hostingservicepurchase",
            "id = " . $dbo->getID() );

    // Run query
    if( !mysql_query( $sql, $DB->handle() ) ) {
        throw new DBException( mysql_error( $DB->handle() ) );
    }
}

/**
 * Load a HostingServicePurchaseDBO from the database
 *
 * @param integer HostingServicePurchase ID
 * @return HostingServicePurchaseDBO HostingServicePurchase, or null if not found
 */
function load_HostingServicePurchaseDBO( $id ) {
    $DB = DBConnection::getDBConnection();

    // Build query
    $sql = $DB->build_select_sql( "hostingservicepurchase",
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
    $dbo = new HostingServicePurchaseDBO();
    $data = mysql_fetch_array( $result );
    $dbo->load( $data );

    // Return the new UserDBO
    return $dbo;
}

/**
 * Load multiple HostingServicePurchaseDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of HostingServicePurchaseDBO's
 */
function &load_array_HostingServicePurchaseDBO( $filter = null,
        $sortby = null,
        $sortdir = null,
        $limit = null,
        $start = null ) {
    $DB = DBConnection::getDBConnection();

    // Build query
    $sql = $DB->build_select_sql( "hostingservicepurchase",
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
        $dbo = new HostingServicePurchaseDBO();
        $dbo->load( $data );

        // Add HostingServiceDBO to array
        $dbo_array[] = $dbo;
    }

    return $dbo_array;
}

/**
 * Count HostingServicePurchaseDBO's
 *
 * Same as load_array_HostingServicePurchaseDBO, except this function just COUNTs the
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of HostingServicePurchase records
 */
function count_all_HostingServicePurchaseDBO( $filter = null ) {
    $DB = DBConnection::getDBConnection();

    // Build query
    $sql = $DB->build_select_sql( "hostingservicepurchase",
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
        throw new DBException( "Expected exactly one row for count query");
    }

    $data = mysql_fetch_array( $result );
    return $data[0];
}

?>