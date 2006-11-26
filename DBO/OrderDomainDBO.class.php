<?php
/**
 * OrderDomainDBO.class.php
 *
 * This file contains the definition for the OrderDomainDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * OrderDomainDBO
 *
 * Represent an OrderDomain.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderDomainDBO extends OrderItemDBO
{
  /**
   * @var ContactDBO Admin contact
   */
  protected $adminContactDBO = null;

  /**
   * @var ContactDBO Billing contact
   */
  protected $billingContactDBO = null;

  /**
   * @var string Domain Name (without TLD)
   */
  protected $domainname;

  /**
   * @var integer OrderDomain ID
   */
  protected $id;

  /**
   * @var ContactDBO Technical contact
   */
  protected $techContactDBO = null;

  /**
   * @var string Transfer secret
   */
  protected $transferSecret;

  /**
   * @var string Domain order type (New, Transfer, or Existing)
   */
  protected $type;

  /**
   * Set Purchasable
   *
   * @param DomainServiceDBO The domain service to be purchased
   */
  public function setPurchasable( DomainServiceDBO $purchasable )
  {
    // The purpose of this function is to forc the purchasable to be a DomainServiceDBO
    parent::setPurchasable( $purchasable );
  }

  /**
   * Set Admin Contact
   *
   * @param ContactDBO $contactDBO Admin contact
   */
  function setAdminContact( $contactDBO ) { $this->adminContactDBO = $contactDBO; }

  /**
   * Set Billing Contact
   *
   * @param ContactDBO $contactDBO Billing contact
   */
  function setBillingContact( $contactDBO ) 
  { 
    $this->billingContactDBO = $contactDBO; 
  }

  /**
   * Set Technical Contact
   *
   * @param ContactDBO $contactDBO Technical contact
   */
  function setTechContact( $contactDBO ) { $this->techContactDBO = $contactDBO; }

  /**
   * Get Admin Contact
   *
   * @return ContactDBO Admin contact
   */
  function getAdminContact() { return $this->adminContactDBO; }

  /**
   * Get Billing Contact
   *
   * @return ContactDBO Billing contact
   */
  function getBillingContact() { return $this->billingContactDBO; }

  /**
   * Get Technical Contact
   *
   * @return ContactDBO Technical contact
   */
  function getTechContact() { return $this->techContactDBO; }

  /**
   * Set OrderDomain ID
   *
   * @param integer $id OrderDomain ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get OrderDomain ID
   *
   * @return integer OrderDomain ID
   */
  function getID() { return $this->id; }

  /**
   * Has Contact Information
   *
   * @return boolean True if contact information has been supplied for this domain
   */
  function hasContactInformation()
  {
    return ( $this->adminContactDBO != null || 
	     $this->billingContactDBO != null || 
	     $this->techContactDBO != null );
  }

  /**
   * Set Type
   *
   * @param string $type Domain order-type
   */
  function setType( $type )
  {
    if( !( $type == "New" || $type == "Transfer" || $type == "Existing" ) )
      {
	fatal_error( "OrderDomainDBO::setType()", "Invalid type: " . $type );
      }
    $this->type = $type;
  }

  /**
   * Get Type
   *
   * @return string Domain order-type
   */
  function getType() { return $this->type; }

  /**
   * Set TLD
   *
   * @param string $tld Domain TLD
   */
  function setTLD( $tld ) 
  { 
    $this->setPurchasable( load_DomainServiceDBO( $tld ) );
  }

  /**
   * Get TLD
   *
   * @return string TLD
   */
  function getTLD() { return $this->purchasable->getTLD(); }

  /**
   * Set Domain Name
   *
   * @param string $domainname Domain name (without TLD)
   */
  function setDomainName( $domainname ) { $this->domainname = $domainname; }

  /**
   * Get Domain Name
   *
   * @return string Domain Name (without TLD)
   */
  function getDomainName() { return $this->domainname; }

  /**
   * Get Full Domain Name
   *
   * @return string Full Domain Name
   */
  function getFullDomainName() { return $this->domainname . "." . $this->getTLD(); }

  /**
   * Get Description
   *
   * @return string Description of this order item
   */
  function getDescription()
  {
    switch( $this->getType() )
      {
      case "Existing": $desc = ""; break;
      case "New": $desc = "[DOMAIN_REGISTRATION]: "; break;
      case "Transfer": $desc = "[DOMAIN_TRANSFER]: "; break;
      }
    return $desc . $this->getFullDomainName();
  }

  /**
   * Set Transfer Secret
   *
   * @param string $secret Transfer secret
   */
  function setTransferSecret( $secret ) { $this->transferSecret = $secret; }

  /**
   * Get Transfer Secret
   *
   * @return string Transfer secret
   */
  function getTransferSecret() { return $this->transferSecret; }

  /**
   * Execute Domain Order
   *
   * Register or Transfer the domain and create a new Domain Service Purchase 
   * for this order item
   *
   * @param AccountDBO $accountDBO Account object
   * @return boolean True for success
   */
  function execute( $accountDBO )
  {
    global $DB;

    switch( $this->getType() )
      {
      case "Existing":
	// Do nothing
	return true;
	break;

      case "New":
	if( !$this->registerDomain( $accountDBO ) )
	  {
	    return false;
	  }
	break;

      case "Transfer":
	if( !$this->transferDomain( $accountDBO ) )
	  {
	    return false;
	  }
	break;

      default:
	fatal_error( "OrderDomainDBO::execute()",
		     "Domain order type not supported: " . $this->getType() );
      }

    // Create a new domain service purchase record
    $purchaseDBO = new DomainServicePurchaseDBO();
    $purchaseDBO->setAccountID( $accountDBO->getID() );
    $purchaseDBO->setTLD( $this->getTLD() );
    $purchaseDBO->setTerm( $this->getTerm() );
    $purchaseDBO->setDomainName( $this->getDomainName() );
    $purchaseDBO->setDate( $DB->format_datetime( time() ) );
    $purchaseDBO->setPrevInvoiceID( -1 );
    $purchaseDBO->incrementNextBillingDate();
    if( !add_DomainServicePurchaseDBO( $purchaseDBO ) )
      {
	log_error( "OrderDomainDBO::execute()",
		   "Failed to add domain service purchase to DB" );
	return false;
      }

    // Fulfill this order item
    $this->setStatus( "Fulfilled" );
    if( !update_OrderDomainDBO( $this ) )
      {
	log_error( "OrderDomainDBO::execute()",
		   "Failed to update OrderDomainDBO" );
	return false;
      }

    // Success
    return true;
  }

  /**
   * Register this Domain
   *
   * @param AccountDBO $accountDBO The account registering this domain
   * @return boolean True for success
   */
  function registerDomain( $accountDBO )
  {
    global $DB, $conf;

    // Verify that the registrar module is enabled
    $serviceDBO = load_DomainServiceDBO( $this->getTLD() );

    $registry = ModuleRegistry::getModuleRegistry();
    $module = $registry->getModule( $serviceDBO->getModuleName() );

    // Make sure the domain is available
    if( !$module->checkAvailability( $this->getFullDomainName() ) )
      {
	log_error( "OrderDomainDBO::registerDomain()",
		   "Attempted to register a domain that is not available: " . $this->getFullDomainName() );
	return false;
      }

    // Prepare contact info
    $contacts['admin'] = $this->getAdminContact();
    $contacts['billing'] = $this->getBillingContact();
    $contacts['tech'] = $this->getTechContact();

    // Register the domain
    $module->registerNewDomain( $this->getDomainName(),
				$this->getTLD(),
				intval( $this->getTerm() / 12 ),
				$contacts,
				$accountDBO );

    return true;
  }

  /**
   * Transfer this Domain
   *
   * @param AccountDBO $accountDBO The account registering this domain
   * @return boolean True for success
   */
  function transferDomain( $accountDBO )
  {
    global $conf;

    $serviceDBO = load_DomainServiceDBO( $this->getTLD() );
    $module = $conf['modules'][$serviceDBO->getModuleName()];

    // Verify that the domain is transferable
    if( !$module->isTransferable( $this->getFullDomainName() ) )
      {
	log_error( "OrderDomainDBO::transferDomain()",
		   "Attempted to transfer a domain that is not eligible for transfer: " .
		   $this->getFullDomainName() );
	return false;
      }

    // Prepare contact info
    $contacts['admin'] = $this->getAdminContact();
    $contacts['billing'] = $this->getBillingContact();
    $contacts['tech'] = $this->getTechContact();

    // Transfer the domain
    $module->transferDomain( $this->getDomainName(),
			     $this->getTLD(),
			     intval( $this->getTerm() / 12 ),
			     $this->getTransferSecret(),
			     $contacts,
			     $accountDBO );

    return true;
  }

  /**
   * Load Member Data from Array
   */
  function load( $data )
  {
    parent::load( $data );
    $this->setID( $data['id'] );
    $this->setOrderID( $data['orderid'] );
    $this->setOrderItemID( $data['orderitemid'] );
    $this->setType( $data['type'] );
    $this->setTLD( $data['tld'] );
    $this->setDomainName( $data['domainname'] );
    $this->setTerm( $data['term'] );
    $this->setTransferSecret( $data['transfersecret'] );
    $this->setAdminContact( ContactDBO_load( $data['admincontactid'] ) );
    $this->setBillingContact( ContactDBO_load( $data['billingcontactid'] ) );
    $this->setTechContact( ContactDBO_load( $data['techcontactid'] ) );
  }
}

/**
 * Insert OrderDomainDBO into database
 *
 * @param OrderDomainDBO &$dbo OrderDomainDBO to add to database
 * @return boolean True on success
 */
function add_OrderDomainDBO( &$dbo )
{
  global $DB;

  // Initialize contact ID's to 0
  $adminID = $billingID = $techID = 0;
  if( $dbo->getType() != "Existing" )
    {
      // Save contacts
      $adminContactDBO = $dbo->getAdminContact();
      if( !ContactDBO_add( $adminContactDBO ) )
	{
	  log_error( "add_OrderDomainDBO", "Failed to add admin contact to database!" );
	  return false;
	}
      $adminID = $adminContactDBO->getID();

      $billingContactDBO = $dbo->getBillingContact();
      if( !ContactDBO_add( $billingContactDBO ) )
	{
	  log_error( "add_OrderDomainDBO", "Failed to add billing contact to database!" );
	  return false;
	}
      $billingID = $billingContactDBO->getID();

      $techContactDBO = $dbo->getTechContact();
      if( !ContactDBO_add( $techContactDBO ) )
	{
	  log_error( "add_OrderDomainDBO", "Failed to add technical contact to database!" );
	  return false;
	}
      $techID = $techContactDBO->getID();
    }

  // Build SQL
  $sql = 
    $DB->build_insert_sql( "orderdomain",
			   array( "orderid" => intval( $dbo->getOrderID() ),
				  "orderitemid" => intval( $dbo->getOrderItemID() ),
				  "type" => $dbo->getType(),
				  "tld" => $dbo->getTLD(),
				  "status" => $dbo->getStatus(),
				  "domainname" => $dbo->getDomainName(),
				  "term" => $dbo->getTerm(),
				  "transfersecret" => $dbo->getTransferSecret(),
				  "admincontactid" => $adminID, 
				  "billingcontactid" => $billingID,
				  "techcontactid" => $techID ) );

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
      fatal_error( "add_OrderDomainDBO()", 
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_OrderDomainDBO()", 
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );
  return true;
}

/**
 * Update OrderDomainDBO in database
 *
 * @param OrderDomainDBO &$dbo OrderDomainDBO to update
 * @return boolean True on success
 */
function update_OrderDomainDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "orderdomain",
				"id = " . intval( $dbo->getID() ),
				array( "orderid" => intval( $dbo->getOrderID() ),
				       "type" => $dbo->getType(),
				       "tld" => $dbo->getTLD(),
				       "status" => $dbo->getStatus(),
				       "domainname" => $dbo->getDomainName(),
				       "term" => $dbo->getTerm(),
				       "transfersecret" => $dbo->getTransferSecret() ) );
				
  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete OrderDomainDBO from database
 *
 * @param OrderDomainDBO &$dbo OrderDomainDBO to delete
 * @return boolean True on success
 */
function delete_OrderDomainDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "orderdomain",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load a OrderDomainDBO from the database
 *
 * @param integer $id OrderDomain ID
 * @return OrderDomainDBO OrderDomainDBO, or null if not found
 */
function load_OrderDomainDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "orderdomain",
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
      fatel_error( "load_OrderDomainDBO", 
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new OrderDBO
  $dbo = new OrderDomainDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple OrderDomainDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function &load_array_OrderDomainDBO( $filter = null,
				     $sortby = null,
				     $sortdir = null,
				     $limit = null,
				     $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "orderdomain",
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
      fatal_error( "load_array_OrderDomainDBO", "SELECT failure" );
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
      $dbo =& new OrderDomainDBO();
      $dbo->load( $data );

      // Add OrderDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count OrderDomainDBO's
 *
 * Same as load_array_OrderDomainDBO, except this function just COUNTs the number
 * of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of OrderDBO's
 */
function count_all_OrderDomainDBO( $filter = null )
{
  global $DB;

  // Build query
  $sql = "SELECT COUNT(*) FROM orderdomain";

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_OrderDomainDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_OrderDomainDBO()",
		   "Expected SELECT to return 1 row" );
      exit();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>