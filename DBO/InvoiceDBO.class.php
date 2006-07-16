<?php
/**
 * InvoiceDBO.class.php
 *
 * This file contains the definition for the InvoiceDBO class.
 * 
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once $base_path . "solidworks/DBO.class.php";

require_once "AccountDBO.class.php";
require_once "InvoiceItemDBO.class.php";

/**
 * InvoiceDBO
 *
 * Represents an Invoice, assigned to a customer Account.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvoiceDBO extends DBO
{
  /**
   * @var integer Invoice ID
   */
  var $id;

  /**
   * @var integer Account ID
   */
  var $accountid;

  /**
   * @var AccountDBO The Account this Invoice is assigned to
   */
  var $accountdbo;

  /**
   * @var string Invoice date (MySQL DATETIME)
   */
  var $date;

  /**
   * @var string Beginning of invoice period (MySQL DATETIME)
   */
  var $periodbegin;

  /**
   * @var string End of invoice period (MySQL DATETIME)
   */
  var $periodend;

  /**
   * @var string Note to customer
   */
  var $note;

  /**
   * @var integer Invoice terms (number of days)
   */
  var $terms;

  /**
   * @var array Invoice items (InvoiceItemDBO)
   */
  var $invoiceitemdbo_array = array();

  /**
   * @var array Payments (PaymentDBO)
   */
  var $paymentdbo_array = array();

  /**
   * Set Invoice ID
   *
   * @param integer $id Invoice ID
   */
  function setID( $id ) 
  { 
    $this->id = $id; 

    // Load any line-items for this Invoice
    $this->invoiceitemdbo_array = load_array_InvoiceItemDBO( "invoiceid=" . intval( $id ) );

    // Load any payments for this Invoice
    $this->paymentdbo_array = load_array_PaymentDBO( "invoiceid=" . intval( $id ) );
  }

  /**
   * Get Invoice ID
   *
   * @return integer Invoice ID
   */
  function getID() { return $this->id; }

  /**
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  function setAccountID( $id )
  {
    $this->accountid = $id;
    if( ($this->accountdbo = load_AccountDBO( $id )) == null )
      {
	fatal_error( "InvoiceDBO::setAccountID()",
		     "could not load AccountDBO for InvoiceDBO, id = " . $id );
      }
  }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  function getAccountID() { return $this->accountid; }

  /**
   * Get Account
   *
   * @return AccountDBO Account for this invoice
   */
  function getAccountDBO() { return $this->accountdbo; }

  /**
   * Set Invoice Date
   *
   * @param string $date Invoice date (MySQL DATETIME)
   */
  function setDate( $date ) { $this->date = $date; }

  /**
   * Get Invoice Date
   *
   * @return string Invoice date (MySQL DATETIME)
   */
  function getDate() { return $this->date; }

  /**
   * Set Beginning of Invoice Period
   *
   * @param string $date Beginning of invoice periond (MySQL DATETIME)
   */
  function setPeriodBegin( $date ) { $this->periodbegin = $date; }

  /**
   * Get Beginning of Invoice Period
   *
   * @return string Beginning of invoice period (MySQL DATETIME)
   */
  function getPeriodBegin() { return $this->periodbegin; }

  /**
   * Set End of Invoice Period
   *
   * @param string $date End of Invoice Period (MySQL DATETIME)
   */
  function setPeriodEnd( $date ) { $this->periodend = $date; }

  /**
   * Get End of Invoice Period
   *
   * @return string End of Invoice Period (MySQL DATETIME)
   */
  function getPeriodEnd() { return $this->periodend; }

  /**
   * Set Customer Note
   *
   * @param string $note Customer note
   */
  function setNote( $note ) { $this->note = $note; }

  /**
   * Get Customer Note
   *
   * @return string Customer note
   */
  function getNote() { return $this->note; }

  /**
   * Set Invoice Terms
   *
   * @param integer $terms Invoice terms (number of days)
   */
  function setTerms( $terms ) { $this->terms = $terms; }

  /**
   * Get Invoice Terms
   *
   * @return integer Invoice terms (number of days)
   */
  function getTerms() { return $this->terms; }

  /**
   * Get Account Name
   *
   * @return string Account name
   */
  function getAccountName() { return $this->accountdbo->getAccountName(); }

  /**
   * Get Invoice Sub-Total
   *
   * Returns the total of all non-tax items.
   *
   * @return float Invoice sub-total
   */
  function getSubTotal()
  {
    // Sum the price of all invoice items
    $total = 0.00;
    foreach( $this->invoiceitemdbo_array as $itemdbo )
      {
	if( !$itemdbo->isTaxItem() )
	  {
	    $total += $itemdbo->getAmount();
	  }
      }
    return $total;
  }

  /**
   * Get Tax Total
   *
   * Returns the total of taxes on invoice items
   *
   * @return float Invoice tax total
   */
  function getTaxTotal()
  {
    // Sum all the tax items
    $total = 0.00;
    foreach( $this->invoiceitemdbo_array as $itemdbo )
      {
	if( $itemdbo->isTaxItem() )
	  {
	    $total += $itemdbo->getAmount();
	  }
      }
    return $total;
  }

  /**
   * Get Invoice Total
   *
   * Returns the total of all invoice items, not the balance of the invoice (the
   * sum of invoice items minus the sum of payments).
   *
   * @return double Invoice total
   */
  function getTotal()
  {
    // Sum invoice items
    $total = 0.00;
    foreach( $this->invoiceitemdbo_array as $itemdbo )
      {
	$total += $itemdbo->getAmount();
      }
    return $total;
  }

  /**
   * Get Total Payments
   *
   * @return double Total payments
   */
  function getTotalPayments()
  {
    // Sum payments
    $payments = 0.00;
    if( $this->paymentdbo_array != null )
      {
	foreach( $this->paymentdbo_array as $paymentdbo )
	  {
	    $payments += $paymentdbo->getAmount();
	  }
      }
    return $payments;
  }

  /**
   * Get Invoice Description
   *
   * Returns a text description of the invoice in the following format:
   *   Invoice #n (begin date - end date, $balance)
   *
   * @return string Invoice description
   */
  function getDescription()
  {
    global $DB;

    return "Invoice #" . $this->getID() . 
      " (" . $this->getAccountName() . " " . 
      date( "n/j/Y", $DB->datetime_to_unix( $this->getPeriodBegin() ) ) . " - " . 
      date( "n/j/Y", $DB->datetime_to_unix( $this->getPeriodEnd() ) ) . ", " .
      sprintf( "$%01.2f", $this->getBalance() ) . ")";
  }

  /**
   * Get Invoice Balance
   *
   * @return double Balance
   */
  function getBalance()
  {
    // Invoice Total - Payments
    return $this->getTotal() - $this->getTotalPayments();
  }

  /**
   * Get Invoice Items
   *
   * @return array Invoice items (InvoiceItemDBO)
   */
  function &getItems()
  {
    return $this->invoiceitemdbo_array;
  }

  /**
   * Get Invoice Payments
   *
   * @return array Payments (PaymentDBO)
   */
  function &getPayments()
  {
    return $this->paymentdbo_array;
  }

  /**
   * Get Invoice Due Date
   *
   * @return string Due date (MySQL DATETIME)
   */
  function getDueDate()
  {
    global $DB;

    return $DB->datetime_to_unix( $this->getDate() ) + ($this->getTerms()*24*60*60);
  }

  /**
   * Get Outstanding Status
   *
   * If the balance of the invoice is greater than 0, the invoice is considered to
   * be outstanding, and this function will return true.
   *
   * return boolean Outstanding if true
   */
  function getOutstanding()
  {
    return $this->getBalance() > 0 ? "yes" : "no";
  }

  /**
   * Generate Invoice
   *
   * Given an Account to generate the invoice for and a period for which to bill,
   * this function will search out any purchases that occured during that period
   * and add an InvoiceItem to the Invoice for each purchase.
   *
   * @return boolean True on success
   */
  function generate()
  {
    global $DB;

    if( $this->getAccountID() == null ||
	$this->getPeriodBegin() == null ||
	$this->getPeriodEnd() == null )
      {
	// Missing necessary information to generate this invoice
	return false;
      }

    $period_begin = $DB->datetime_to_unix( $this->getPeriodBegin() );
    $period_end   = $DB->datetime_to_unix( $this->getPeriodEnd() );

    // Add a line item for each web hosting service
    if( ($hsp_dbo_array = $this->accountdbo->getHostingServices()) != null )
      {
	foreach( $hsp_dbo_array as $hsp_dbo )
	  {
	    if( $hsp_dbo->is_billable( $period_begin, $period_end ) )
	      {
		// Add a line item for this web hosting service
		$this->add_item( 1, $hsp_dbo->getPrice(), $hsp_dbo->getTitle(), false );

		// Add a line item for each tax rule that applies to this purchase
		if( ($taxrules = $hsp_dbo->getTaxes()) != null )
		  {
		    foreach( $taxrules as $taxrule_dbo )
		      {
			$this->add_item( 1, 
					 $hsp_dbo->calculateTax( $taxrule_dbo ),
					 "+ " . $taxrule_dbo->getDescription() .
					 " @ " . $taxrule_dbo->getRate() . "%",
					 true );
		      }
		  }
	      }
	  }
      }

    // Add a line item for each domain service
    if( ($dsp_dbo_array = $this->accountdbo->getDomainServices()) != null )
      {
	foreach( $dsp_dbo_array as $dsp_dbo )
	  {
	    if( $dsp_dbo->is_billable( $period_begin, $period_end ) )
	      {
		// Add a line item for this domain service
		$this->add_item( 1, 
				 $dsp_dbo->getPrice(), 
				 $dsp_dbo->getFullDomainName(), 
				 false );

		// Add a line item for each tax rule that applies to this purchase
		if( ($taxrules = $dsp_dbo->getTaxes()) != null )
		  {
		    foreach( $taxrules as $taxrule_dbo )
		      {
			$this->add_item( 1, 
					 $dsp_dbo->calculateTax( $taxrule_dbo ),
					 "+ " . $taxrule_dbo->getDescription() .
					 " @ " . $taxrule_dbo->getRate() . "%",
					 true );
		      }
		  }
	      }
	  }
      }

    // Add a line item for each product
    if( ($pp_dbo_array = $this->accountdbo->getProducts()) != null )
      {
	foreach( $pp_dbo_array as $pp_dbo )
	  {
	    if( $pp_dbo->is_billable( $period_begin, $period_end ) )
	      {
		// Add a line item for this product
		$this->add_item( 1, 
				 $pp_dbo->getPrice(), 
				 $pp_dbo->getProductName(),
				 false );

		// Add a line item for each tax rule that applies to this purchase
		if( ($taxrules = $pp_dbo->getTaxes()) != null )
		  {
		    foreach( $taxrules as $taxrule_dbo )
		      {
			$this->add_item( 1, 
					 $pp_dbo->calculateTax( $taxrule_dbo ),
					 "+ " . $taxrule_dbo->getDescription() .
					 " @ " . $taxrule_dbo->getRate() . "%",
					 true );
		      }
		  }
	      }
	  }
      }

    return true;
  }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setAccountID( $data['accountid'] );
    $this->setDate( $data['date'] );
    $this->setPeriodBegin( $data['periodbegin'] );
    $this->setPeriodEnd( $data['periodend'] );
    $this->setNote( $data['note'] );
    $this->setTerms( $data['terms'] );
  }

  /**
   * Add Item to Invoice
   *
   * Creates an InvoiceItemDBO and adds it to this Invoice
   *
   * @param integer $quantity Quantity of units
   * @param double $unitamount Cost of each unit
   * @param string $text Description of unit(s)
   * @param boolean $taxflag True if this item is a tax item
   */
  function add_item( $quantity, $unitamount, $text, $taxflag )
  {
    // Create a new Invoice Item DBO
    $itemdbo = new InvoiceItemDBO;
    $itemdbo->setInvoiceID( $this->getID() );
    $itemdbo->setQuantity( $quantity );
    $itemdbo->setUnitAmount( $unitamount );
    $itemdbo->setText( $text );
    $itemdbo->setTaxItem( $taxflag ? "Yes" : "No" );
    
    // Add DBO to invoice
    if( $this->getID() != null )
      {
	// Invoice already exists in database, so go ahead and Insert line-item
	// into database
	if( !add_InvoiceItemDBO( $itemdbo ) )
	  {
	    fatal_error( "InvoiceDBO::add_item()",
			 "Failed to add line item to invoice!" );
	  }

      }
    $this->invoiceitemdbo_array[] = $itemdbo;
  }

  /**
   * Formatted Invoice Text
   *
   * Using the supplied template, this function generates text for the invoice.
   *
   * @param string $email_text Format string
   *
   * @return string Invoice text
   */
  function text( $email_text )
  {
    global $conf;

    // Generate Invoice & E-mail text
    $email_text = str_replace( "{invoice_id}", $this->getID(), $email_text );
    $email_text = str_replace( "{invoice_subtotal}", 
			       sprintf( "%s%01.2f", 
					$conf['locale']['currency_symbol'], 
					$this->getSubTotal() ), 
			       $email_text );
    $email_text = str_replace( "{invoice_taxtotal}", 
			       sprintf( "%s%01.2f", 
					$conf['locale']['currency_symbol'], 
					$this->getTaxTotal() ), 
			       $email_text );
    $email_text = str_replace( "{invoice_total}", 
			       sprintf( "%s%01.2f", 
					$conf['locale']['currency_symbol'], 
					$this->getTotal() ), 
			       $email_text );
    $email_text = str_replace( "{invoice_payments}", 
			       sprintf( "%s%01.2f", 
					$conf['locale']['currency_symbol'],
					$this->getTotalPayments() ), 
			       $email_text );
    $email_text = str_replace( "{invoice_balance}", 
			       sprintf( "%s%.2f", 
					$conf['locale']['currency_symbol'],
					$this->getBalance() ), 
			       $email_text );
    $due_date = strftime( "%B %e, %G", $this->getDueDate() );
    $email_text = str_replace( "{invoice_due}", $due_date, $email_text );

    // Generate invoice line items
    $line_items = "";
    if( ($item_dbo_array = $this->getItems()) != null )
      {
	foreach( $item_dbo_array as $item_dbo )
	  {
	    $line_items .= sprintf( "%-40s%s%6.2f %3d    %s%6.2f\n", 
				    $item_dbo->getText(),
				    $conf['locale']['currency_symbol'],
				    $item_dbo->getUnitAmount(),
				    $item_dbo->getQuantity(),
				    $conf['locale']['currency_symbol'],
				    $item_dbo->getAmount() );
	  }
      }
    $email_text = str_replace( "{invoice_items}", $line_items, $email_text );

    return $email_text;
  }
}

/**
 * Insert InvoiceDBO into database
 *
 * @param InvoiceDBO &$dbo InvoiceDBO to add to database
 * @return boolean True on success
 */
function add_InvoiceDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "invoice",
				array( "accountid" => intval( $dbo->getAccountID() ),
				       "date" => $dbo->getDate(),
				       "periodbegin" => $dbo->getPeriodBegin(),
				       "periodend" => $dbo->getPeriodEnd(),
				       "note" => $dbo->getNote(),
				       "terms" => intval( $dbo->getTerms() ),
				       "outstanding" => $dbo->getOutstanding() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      echo $sql . " ";
      echo mysql_error( $DB->handle() );
      return false;
    }

  // Get auto-increment ID
  $id = mysql_insert_id( $DB->handle() );

  // Validate ID
  if( $id == false )
    {
      // DB error
      fatal_error( "add_InvoiceDBO", "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_InvoiceDBO", "Previous INSERT did not generate an ID" );
    }

  // Add line-items to database as well
  if( ($itemdbo_array = $dbo->getItems()) != null )
    {
      foreach( $itemdbo_array as $itemdbo )
	{
	  $itemdbo->setInvoiceID( $id );
	  if( !add_InvoiceItemDBO( $itemdbo ) )
	    {
	      fatal_error( "add_InvoiceDBO", "Failed to add line item to invoice!" );
	    }
	}
    }

  // Store ID in DBO
  $dbo->setID( $id );

  return true;
}

/**
 * Update InvoiceDBO in database
 *
 * @param InvoiceDBO &$dbo InvoiceDBO to update
 * @return boolean True on success
 */
function update_InvoiceDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "invoice",
				"id = " . intval( $dbo->getID() ),
				array( "accountid" => intval( $dbo->getAccountID() ),
				       "date" => $dbo->getDate(),
				       "periodbegin" => $dbo->getPeriodBegin(),
				       "periodend" => $dbo->getPeriodEnd(),
				       "note" => $dbo->getNote(),
				       "terms" => intval( $dbo->getTerms() ),
				       "outstanding" => $dbo->getOutstanding() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Delete InvoiceDBO from database
 *
 * @param InvoiceDBO &$dbo InvoiceDBO to delete
 * @return boolean True on success
 */
function delete_InvoiceDBO( &$dbo )
{
  global $DB;

  // Delete line-items
  foreach( $dbo->getItems() as $item_dbo )
    {
      if( !delete_InvoiceItemDBO( $item_dbo ) )
	{
	  fatal_error( "delete_InvoiceDBO()",
		       "could not delete invoice line item for invoice id: " . $dbo->getID() );
	}
    }

  // Delete Payments
  foreach( $dbo->getPayments() as $payment_dbo )
    {
      if( !delete_PaymentDBO( $payment_dbo ) )
	{
	  fatal_error( "delete_InvoiceDBO()",
		       "could not delete payment for invoice id: " . $dbo->getID() );
	}
    }

  // Build SQL
  $sql = $DB->build_delete_sql( "invoice",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load InvoiceDBO from Database
 *
 * @param integer $id Invoice ID
 * @return InvoiceDBO Invoice if found, null if not found
 */
function load_InvoiceDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "invoice",
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
      fatal_error( "load_InvoiceDBO", "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new InvoiceDBO
  $dbo = new InvoiceDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple InvoiceDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of InvoiceDBO's
 */
function &load_array_InvoiceDBO( $filter = null,
				 $sortby = null,
				 $sortdir = null,
				 $limit = null,
				 $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "invoice",
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
      fatal_error( "load_array_InvoiceDBO", "SELECT failure" );
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
      $dbo =& new InvoiceDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count InvoiceDBO's
 *
 * Same as load_array_InvoiceDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of Invoice records
 */
function count_all_InvoiceDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "invoice",
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
      fatal_error( "count_all_InvoiceDBO()", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_InvoiceDBO()", "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>