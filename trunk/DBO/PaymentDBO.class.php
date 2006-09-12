<?php
/**
 * PaymentDBO.class.php
 *
 * This file contains the definition for the PaymentDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

require_once "InvoiceDBO.class.php";

/**
 * PaymentDBO
 *
 * Represent a payment.  Each payment must belong to an invoice.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentDBO extends DBO
{
  /**
   * @var integer Payment ID
   */
  var $id;

  /**
   * @var integer Invoice ID
   */
  var $invoiceid;

  /**
   * @var integer Order ID
   */
  var $orderid;

  /**
   * @var string Date of payment (MySQL DATETIME)
   */
  var $date;

  /**
   * @var string Misc. transaction field
   */
  var $transaction1;

  /**
   * @var string Another misc. transaction field
   */
  var $transaction2;

  /**
   * @var string Type of payment (Cash, Check, Credit Card, Paypal, Account Credit, Other)
   */
  var $type;

  /**
   * @var double Payment amount
   */
  var $amount;

  /**
   * @var string Module that processed this payment
   */
  var $module;

  /**
   * @var string Status of payment
   */
  var $status;

  /**
   * @var string Status message, usually provided by the payment module
   */
  var $statusMessage;

  /**
   * Set Payment ID
   *
   * @param integer $id Payment ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Payment ID
   *
   * @return integer Payment ID
   */
  function getID() { return $this->id; }

  /**
   * Set Invoice ID
   *
   * @param integer $id Invoice ID
   */
  function setInvoiceID( $id ) { $this->invoiceid = $id; }

  /**
   * Get Invoice ID
   *
   * @return intger Invoice ID
   */
  function getInvoiceID() { return $this->invoiceid; }

  /**
   * Set Order ID
   *
   * @param integer $id Order ID
   */
  function setOrderID( $id ) { $this->orderid = $id; }

  /**
   * Get Order ID
   *
   * @return intger Order ID
   */
  function getOrderID() { return $this->orderid; }

  /**
   * Set Payment Date
   *
   * @param string $date Payment date (MySQL DATETIME)
   */
  function setDate( $date ) { $this->date = $date; }

  /**
   * Get Payment Date
   *
   * @return string Payment date (MySQL DATETIME)
   */
  function getDate() { return $this->date; }

  /**
   * Set Payment Amount
   *
   * @param double $amount Payment amount
   */
  function setAmount( $amount ) { $this->amount = $amount; }

  /**
   * Get Payment Amount
   *
   * @return double Payment amount
   */
  function getAmount() { return $this->amount; }

  /**
   * Set Transaction Data #1
   *
   * @param string $transaction Transaction data
   */
  function setTransaction1( $transaction ) { $this->transaction1 = $transaction; }

  /**
   * Get Transaction Data #1
   *
   * @return string Transaction data
   */
  function getTransaction1() { return $this->transaction1; }

  /**
   * Set Transaction Data #2
   *
   * @param string $transaction Transaction data
   */
  function setTransaction2( $transaction ) { $this->transaction2 = $transaction; }

  /**
   * Get Transaction Data #2
   *
   * @return string Transaction data
   */
  function getTransaction2() { return $this->transaction2; }

  /**
   * Set Payment Type
   *
   * @param string $type Payment type (Cash, Check, Credit Card, Paypal, Account Credit, Other)
   */
  function setType( $type )
  {
    if( !( $type == "Cash" ||
	   $type == "Check" ||
	   $type == "Module" ||
	   $type == "Other" ) )
      {
	fatal_error( "PaymentDBO::setType()", "Invalid Payment type: " . $type );
      }
    $this->type = $type;
  }

  /**
   * Get Payment Type
   *
   * @return string Payment type
   */
  function getType() { return $this->type; }

  /**
   * Set Module
   *
   * @param string $module Name of module that processed this payment
   */
  function setModule( $module ) { $this->module = $module; }

  /**
   * Get Module
   *
   * @return string The module that processed this payment
   */
  function getModule() { return $this->module; }

  /**
   * Get Module Type
   *
   * @return string The type of module that processed this payment
   */
  function getModuleType()
  {
    global $conf;

    return $this->getModule() == null ?
      null : $conf['modules'][$this->getModule()]->getType();
  }

  /**
   * Set Payment Status
   *
   * @param string $status Payment status
   */
  function setStatus( $status )
  {
    if( !( $status == "Declined" ||
	   $status == "Completed" || 
	   $status == "Pending" || 
	   $status == "Authorized" ||
	   $status == "Refunded" ||
	   $status == "Reversed" ||
	   $status == "Voided" ) )
      {
	fatal_error( "PaymentDBO::setStatus()", "Invalid status: " . $status );
      }

    $this->status = $status;
  }

  /**
   * Get Payment Status
   *
   * @return string Payment status
   */
  function getStatus() { return $this->status; }

  /**
   * Set Status Message
   *
   * @param string $message Payment status message
   */
  function setStatusMessage( $message ) { $this->statusMessage = $message; }

  /**
   * Get Status Message
   *
   * @return string Payment status message
   */
  function getStatusMessage() { return $this->statusMessage; }

  /**
   * Get Account Name
   *
   * @return string Account Name
   */
  function getAccountName() 
  { 
    if( ($invoice_dbo = load_InvoiceDBO( $this->invoiceid )) == null )
      {
	fatal_error( "PaymentDBO::getAccountName()",
		     "Invoice ID is invalid: " . $this->invoiceid );
      }
    return $invoice_dbo->getAccountName(); 
  }

  /**
   * Process Credit Card
   *
   * Contacts the payment gateway and authorizes the provided credit card for
   * $this->amount.  $this->status will be set with the result of the transaction
   * (either Authorized, Completed, or Declined).  If there is an error contacting
   * the payment gateway, or if no payment gateway is installed, then false is
   * returned and $this->status is not altered.
   *
   * @param ContactDBO $billingContact The CC billing contact
   * @param string $cardNumber The credit cardnumber, just numbers, no spaces or -'s
   * @param string $expireDate Expiration date in MMYY format
   * @param string $cardCode Credit card security code
   * @param string $method Transaction method ("Authroze Only" or "Authorize and Capture"
   * @return boolean True for success
   */
  function processCreditCard( $billingContact,
			      $cardNumber,
			      $expireDate,
			      $cardCode,
			      $method )
  {
    global $conf;
    if( !($module = $conf['modules'][$this->getModule()] ) )
      {
	log_error( "PaymentDBO::processCreditCard()", 
		   "Could not access a payment gateway module! " );
	return false;
      }

    switch( $method )
      {
      case "Authorize Only":
	return $module->authorize( $billingContact, 
				   $cardNumber, 
				   $expireDate,
				   $cardCode,
				   $this );

      case "Authorize and Capture":
	return $module->authorizeAndCapture( $billingContact, 
					     $cardNumber, 
					     $expireDate,
					     $cardCode,
					     $this );

      default: 
      }

    // Invalid method
    log_error( "PaymentDBO::processCreditCard()", 
	       "Invalid transaction method: " . $method );
    return false;
  }

  /**
   * Capture Payment
   *
   * This method can only be used on payment's authorized through a payment_gateway
   * module.  It attempts to contact the gateway and finalize payment for a
   * previously authorized transaction.
   *
   * @return boolean True for success
   */
  function capture()
  {
    global $conf;

    if( !($this->getModuleType() == "payment_gateway" &&
	  $this->getStatus() == "Authorized" ) )
      {
	// This payment cannot be captured
	return false;
      }

    $module = $conf['modules'][$this->getModule()];
    return $module->capture( $this );
  }

  /**
   * Refund Payment
   *
   * This method can only be used on payment's authorized through a payment_gateway
   * module.  It attempts to contact the gateway and refund payment for a previously
   * captured transaction.
   *
   * @return boolean True for success
   */
  function refund()
  {
    global $conf;

    if( !($this->getModuleType() == "payment_gateway" &&
	  $this->getStatus() == "Completed" ) )
      {
	// This payment cannot be voided
	return false;
      }

    $module = $conf['modules'][$this->getModule()];
    return $module->refund( $this );
  }

  /**
   * Void Payment
   *
   * This method can only be used on payment's authorized through a payment_gateway
   * module.  It attempts to contact the gateway and void payment for a previously
   * authorized transaction.
   *
   * @return boolean True for success
   */
  function void()
  {
    global $conf;

    if( !($this->getModuleType() == "payment_gateway" &&
	  $this->getStatus() == "Authorized" ) )
      {
	// This payment cannot be voided
	return false;
      }

    $module = $conf['modules'][$this->getModule()];
    return $module->void( $this );
  }

  /**
   * Load Member Data from Array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setInvoiceID( $data['invoiceid'] );
    $this->setOrderID( $data['orderid'] );
    $this->setDate( $data['date'] );
    $this->setAmount( $data['amount'] );
    $this->setTransaction1( $data['transaction1'] );
    $this->setTransaction2( $data['transaction2'] );
    $this->setType( $data['type'] );
    $this->setStatus( $data['status'] );
    $this->setStatusMessage( $data['statusmessage'] );
    $this->setModule( $data['module'] );
  }

  /**
   * Touch Invoice
   *
   * When a line item is added to an Invoice we must "touch" the Invoice to make
   * sure it's oustanding flag gets set properly.
   */
  function touchInvoice()
  {
    if( !( $this->invoiceid > 0 ) )
      {
	// No invoice to touch!
	return;
      }

    // Load invoice DBO
    if( ($invoicedbo = load_InvoiceDBO( $this->invoiceid )) == null )
      {
	fatal_error( "PaymentDBO::touchInvoice()",
		     "PaymentDBO::touchInvoice(), error: could not load InvoiceDBO" );
      }

    // Update the Invoice record
    update_InvoiceDBO( $invoicedbo );
  }
}

/**
 * Add PaymentDBO to Database
 *
 * @param PaymentDBO &$dbo PaymentDBO to be added to database
 * @return boolean True on success
 */
function add_PaymentDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "payment",
				array( "invoiceid" => intval( $dbo->getInvoiceID() ),
				       "orderid" => intval( $dbo->getOrderID() ),
				       "date" => $dbo->getDate(),
				       "amount" => $dbo->getAmount(),
				       "transaction1" => $dbo->getTransaction1(),
				       "transaction2" => $dbo->getTransaction2(),
				       "type" => $dbo->getType(), 
				       "module" => $dbo->getModule(),
				       "status" => $dbo->getStatus() ) );
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      echo mysql_error( $DB->handle() );
      return false;
    }

  // Get auto-increment ID
  $id = mysql_insert_id( $DB->handle() );

  // Validate ID
  if( $id == false )
    {
      // DB error
      fatal_error( "add_PaymentDBO()", "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_PaymentDBO()", "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );
  $dbo->touchInvoice();
  return true;
}

/**
 * Update PaymentDBO
 *
 * @param PaymentDBO &$dbo PaymentDBO to be updated
 * @return boolean True on success
 */
function update_PaymentDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "payment",
				"id = " . intval( $dbo->getID() ),
				array( "invoiceid" => intval( $dbo->getInvoiceID() ),
				       "orderid" => intval( $dbo->getOrderID() ),
				       "date" => $dbo->getDate(),
				       "amount" => $dbo->getAmount(),
				       "transaction1" => $dbo->getTransaction1(),
				       "transaction2" => $dbo->getTransaction2(),
				       "type" => $dbo->getType(),
				       "module" => $dbo->getModule(),
				       "status" => $dbo->getStatus() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      return false;
    }
  $dbo->touchInvoice();
  return true;
}

/**
 * Delete PaymentDBO from Database
 *
 * @param PaymentDBO &$dbo PaymentDBO to be deleted
 * @return boolean True on success
 */
function delete_PaymentDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "payment",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      return false;
    }
  $dbo->touchInvoice();
  return true;
}

/**
 * Load PaymentDBO from Database
 *
 * @param integer $id Payment ID
 * @return PaymentDBO Payment or null if not found
 */
function load_PaymentDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "payment",
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
      fatal_error( "load_PaymentDBO()", "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new HostingServiceDBO
  $dbo = new PaymentDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;  
}

/**
 * Load multiple PaymentDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of PaymentDBO's
 */
function &load_array_PaymentDBO( $filter = null,
				 $sortby = null,
				 $sortdir = null,
				 $limit = null,
				 $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "payment",
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
      fatal_error( "load_array_PaymentDBO()", "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      return null;
    }

  // Build an array of DBOs from the result set
  $dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DBO with the data from the DB
      $dbo =& new PaymentDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count PaymentDBO's
 *
 * Same as load_array_PaymentDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of Payment records
 */
function count_all_PaymentDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "payment",
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
      fatal_error( "count_all_PaymentDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_PaymentDBO()", "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>