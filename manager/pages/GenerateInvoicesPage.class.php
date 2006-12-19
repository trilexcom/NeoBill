<?php
/**
 * GenerateInvoicesPage.class.php
 *
 * This file contains the definition for the GenerateInvoicesPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * GenerateInvoicesPage
 *
 * Generate an Invoice batch for all billable accounts.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class GenerateInvoicesPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   generate_invoices (form)
   * 
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "generate_invoices":
	if( isset( $this->post['continue'] ) )
	  {
	    // Generate Invoice Batch
	    $this->generate_invoices();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
	break;
      }
  }

  /**
   * Generate Invoice Batch
   *
   * Generate an Invoice for each billable account during the period set 
   * in the form.
   */
  function generate_invoices()
  {
    $invoice_date = $this->post['date'];
    $terms        = $this->post['terms'];
    $period_begin = $this->post['periodbegin'];
    $period_end   = $this->post['periodend'];
    $note         = $this->post['note'];

    // Get all accounts
    $accountdbo_array = load_array_AccountDBO();

    // Generate an invoice for each account
    foreach( $accountdbo_array as $account )
      {
	if( $account->getStatus() != "Active" ||
	    $account->getBillingStatus() == "Do Not Bill" )
	  {
	    // Skip invalid, pending, and non-billable accounts
	    continue;
	  }

	// Create a new Invoice
	$invoice = new InvoiceDBO();
	$invoice->setAccountID( $account->getID() );
	$invoice->setDate( $this->DB->format_datetime( $invoice_date ) );
	$invoice->setPeriodBegin( $this->DB->format_datetime( $period_begin ) );
	$invoice->setPeriodEnd( $this->DB->format_datetime( $period_end ) );
	$invoice->setNote( $note );
	$invoice->setTerms( $terms );

	// Generate line items
	$invoice->generate();

	$invoiceItems = $invoice->getItems();
	if( empty( $invoiceItems ) )
	  {
	    // Abandon empty invoices
	    continue;
	  }

	// Insert invoice into database
	add_InvoiceDBO( $invoice );
      }

    // Success
    $this->setMessage( array( "type" => "[INVOICE_BATCH_CREATED]" ) );
    $this->goto( "billing_invoices" );
  }

  /**
   * Initialize Generate Invoice Page
   */
  function init()
  {
    parent::init();

    if( !isset( $this->post['periodend'] ) )
      {
	// Set the end of the invoice period to be 1 month ahead of today
	$today = getdate( time() );
	$newDate = DBConnection::format_datetime( mktime( null, null, null, $today['mon']+1 ) );
	$this->smarty->assign( "nextMonth", $newDate );
      }
  }
}
?>