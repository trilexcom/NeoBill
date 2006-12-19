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
  protected $id;

  /**
   * @var integer Account ID
   */
  protected $accountid;

  /**
   * @var AccountDBO The Account this Invoice is assigned to
   */
  protected $accountDBO;

  /**
   * @var string Invoice date (MySQL DATETIME)
   */
  protected $date;

  /**
   * @var string Beginning of invoice period (MySQL DATETIME)
   */
  protected $periodbegin;

  /**
   * @var string End of invoice period (MySQL DATETIME)
   */
  protected $periodend;

  /**
   * @var string Note to customer
   */
  protected $note;

  /**
   * @var integer Invoice terms (number of days)
   */
  protected $terms;

  /**
   * @var array Invoice items (InvoiceItemDBO)
   */
  protected $invoiceitemdbo_array = array();

  /**
   * @var array Payments (PaymentDBO)
   */
  protected $paymentdbo_array = array();

  /**
   * @var array PurchaseDBO's that must be updated when the Invoice is added
   */
  protected $updatePurchases = array();

  /**
   * Convert to a String
   *
   * @return string Invoice ID
   */
  public function __toString() { return $this->getID(); }

  /**
   * Set Invoice ID
   *
   * @param integer $id Invoice ID
   */
  function setID( $id ) 
  { 
    $this->id = $id; 

    // Load any line-items for this Invoice
    try
      {
	$this->invoiceitemdbo_array = 
	  load_array_InvoiceItemDBO( "invoiceid=" . intval( $id ) );
      }
    catch( DBNoRowsFoundException $e )
      {
	$this->invoiceitemdbo_array = array();
      }

    // Load any payments for this Invoice
    try
      {
	$this->paymentdbo_array = load_array_PaymentDBO( "invoiceid=" . intval( $id ) );
      }
    catch( DBNoRowsFoundException $e )
      {
	$this->paymentdbo_array = array();
      }
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
    $this->accountDBO = load_AccountDBO( $id );
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
  function getAccountDBO() { return $this->accountDBO; }

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
  function getAccountName() { return $this->accountDBO->getAccountName(); }

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
   * Returns sub-total + tax-total
   *
   * @return double Invoice total
   */
  function getTotal()
  {
    return $this->getSubTotal() + $this->getTaxTotal();
  }

  /**
   * Get Outstanding Invoices Total
   *
   * Returns the sum of the balances of all outstanding invoices that are
   * dated before this invoice period.
   *
   * @return double Outstanding invoice total
   */
  function getOutstandingTotal()
  {
    $total = 0.00;
    foreach( $this->getOutStandingInvoices() as $invoiceDBO )
      {
	$total += $invoiceDBO->getBalance();
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
    foreach( $this->paymentdbo_array as $paymentdbo )
      {
	$payments += $paymentdbo->getAmount();
      }

    return $payments;
  }

  /**
   * Get Invoice Balance
   *
   * @return double Balance
   */
  function getBalance()
  {
    // Invoice Total - Payments
    return ( $this->getTotal() -
	     $this->getTotalPayments() );
  }

  /**
   * Get Outstanding Balance
   *
   * Returns the invoice balance + all outstanding invoice balances
   *
   * @return float Outstanding balance
   */
  function getOutstandingBalance()
  {
    return $this->getBalance() + $this->getOutstandingTotal();
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
    return "Invoice #" . $this->getID() . 
      " (" . $this->getAccountName() . " " . 
      date( "n/j/Y", DBConnection::datetime_to_unix( $this->getPeriodBegin() ) ) . " - " . 
      date( "n/j/Y", DBConnection::datetime_to_unix( $this->getPeriodEnd() ) ) . ", " .
      sprintf( "$%01.2f", $this->getBalance() ) . ")";
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
    return DBConnection::datetime_to_unix( $this->getDate() ) + 
      ($this->getTerms()*24*60*60);
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
   * Get Outstanding Invoices
   *
   * Returns an array of all outstanding invoices with a creation date before
   * the beginning of this invoice period.
   *
   * @return array An array of InvoiceDBO's
   */
  function getOutstandingInvoices()
  {
    $where = sprintf( "id <> %d AND accountid=%d AND outstanding='%s' AND `date` < '%s'",
		      $this->getID(),
		      $this->getAccountID(),
		      "yes",
		      $this->getPeriodBegin() );
    try
      {
	return load_array_InvoiceDBO( $where );
      }
    catch( DBNoRowsFoundException $e )
      {
	return array();
      }
  }

  /**
   * Get Update Purchases
   *
   * @return array An array of PurchaseDBO's that should be updated when the invoices is added to the database
   */
  public function getUpdatePurchases()
  {
    return $this->updatePurchases;
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
  public function generate()
  {
    if( !( $this->getAccountID() || $this->getPeriodBegin() || $this->getPeriodEnd() ) )
      {
	throw new SWException( "Missing necessary information to generate this invoice" );
      }

    $periodBeginTS = DBConnection::datetime_to_unix( $this->getPeriodBegin() );
    $periodEndTS = DBConnection::datetime_to_unix( $this->getPeriodEnd() );

    // Bill all applicable purchases for the account
    foreach( $this->accountDBO->getPurchases() as $purchaseDBO )
      {
	$taxes = 0;

	// Bill onetime price if necessary
	if( $purchaseDBO->getPrevInvoiceID() == 0 && 
	    $purchaseDBO->getOnetimePrice() > 0 )
	  {
	    $taxes += $purchaseDBO->getOnetimeTaxes();
	    $this->add_item( 1, 
			     $purchaseDBO->getOnetimePrice(),
			     $purchaseDBO->getTitle() .
			     " ([ONETIME])",
			     false );
	  }

	// Bill the purchase as many times as necessary during the period
	$nextBillingDateTS = DBConnection::date_to_unix( $purchaseDBO->getNextBillingDate() );
	$recurCount = 0;
	while( $nextBillingDateTS >= $periodBeginTS && 
	       $nextBillingDateTS < $periodEndTS )
	  {
	    // Calculate the "new next" billing date for this purchase
	    if( $purchaseDBO->getTerm() == 0 )
	      {
		// Do not bill again
		$nextBillingDateTS = null;
		$purchaseDBO->setNextBillingDate( null );
	      }
	    else
	      {
		// Increment the recurring count
		$recurCount++;

		// Increment the next billing date by term
		$nextBillingDateTS = 
		  DBConnection::date_to_unix( $purchaseDBO->incrementNextBillingDate() );
	      }

	    // The -1 will be replaced by the invoice ID in add_InvoiceDBO
	    $purchaseDBO->setPrevInvoiceID( -1 );

	    // Add this purchase to the list of purchase DBO's to update when
	    // the invoice is added to the database
	    $this->updatePurchases[] = $purchaseDBO;
	  }

	// Bill the recurring price (if exists)
	if( $recurCount > 0 && $purchaseDBO->getRecurringPrice() > 0 )
	  {
	    $taxes += ($purchaseDBO->getRecurringTaxes() * $recurCount);
	    $this->add_item( $recurCount, 
			     $purchaseDBO->getRecurringPrice(),
			     $purchaseDBO->getTitle(),
			     false );
	  }

	// Charge taxes
	if( $taxes > 0 )
	  {
	    $this->add_item( 1, 
			     $taxes,
			     $purchaseDBO->getTitle() . ": [TAX]",
			     true );
	  }

      }

    // Done
    return true;
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
	add_InvoiceItemDBO( $itemdbo );
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

    $invoiceDate = DBConnection::datetime_to_unix( $this->getDate() );
    $email_text = str_replace( "{invoice_date}", 
			       strftime( "%B %e, %G", $invoiceDate ),
			       $email_text );

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
 
    $email_text = str_replace( "{outstanding_balance}",
			       sprintf( "%s%.2f", 
					$conf['locale']['currency_symbol'],
					$this->getOutstandingBalance() ), 
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
 */
function add_InvoiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  // Get auto-increment ID
  $id = mysql_insert_id( $DB->handle() );

  // Validate ID
  if( $id == false )
    {
      // DB error
      throw new DBException( "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      throw new DBException( "Previous INSERT did not generate an ID" );
    }

  // Add line-items to database as well
  if( ($itemdbo_array = $dbo->getItems()) != null )
    {
      foreach( $itemdbo_array as $itemdbo )
	{
	  $itemdbo->setInvoiceID( $id );
	  add_InvoiceItemDBO( $itemdbo );
	}
    }

  // Update Purchase DBO's with a prev invoice id set to -1
  foreach( $dbo->getUpdatePurchases() as $purchaseDBO )
    {
      $purchaseDBO->setPrevInvoiceID( $id );
      
      switch( get_class( $purchaseDBO ) )
	{
	case "DomainServicePurchaseDBO":
	  update_DomainServicePurchaseDBO( $purchaseDBO );
	  break;
	case "HostingServicePurchaseDBO":
	  update_HostingServicePurchaseDBO( $purchaseDBO );
	  break;
	case "ProductPurchaseDBO":
	  update_ProductPurchaseDBO( $purchaseDBO );
	  break;
	}
    }

  // Store ID in DBO
  $dbo->setID( $id );
}

/**
 * Update InvoiceDBO in database
 *
 * @param InvoiceDBO &$dbo InvoiceDBO to update
 * @return boolean True on success
 */
function update_InvoiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

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
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Delete InvoiceDBO from database
 *
 * @param InvoiceDBO &$dbo InvoiceDBO to delete
 */
function delete_InvoiceDBO( &$dbo )
{
  $DB = DBConnection::getDBConnection();

  // Delete line-items
  foreach( $dbo->getItems() as $item_dbo )
    {
      delete_InvoiceItemDBO( $item_dbo );
    }

  // Delete Payments
  foreach( $dbo->getPayments() as $payment_dbo )
    {
      delete_PaymentDBO( $payment_dbo );
    }

  // Build SQL
  $sql = $DB->build_delete_sql( "invoice",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      throw new DBException();
    }
}

/**
 * Load InvoiceDBO from Database
 *
 * @param integer $id Invoice ID
 * @return InvoiceDBO Invoice 
 */
function load_InvoiceDBO( $id )
{
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();

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
      throw new DBException();
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      throw new DBNoRowsFoundException();
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
  $DB = DBConnection::getDBConnection();
  
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
      throw new DBException();
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      throw new DBException();
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}

?>