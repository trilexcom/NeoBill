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
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/InvoiceDBO.class.php";

/**
 * GenerateInvoicesPage
 *
 * Generate an Invoice batch for all billable accounts.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class GenerateInvoicesPage extends Page
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

	if( isset( $this->session['generate_invoices']['continue'] ) )
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
    $invoice_date = $this->session['generate_invoices']['date'];
    $terms        = $this->session['generate_invoices']['terms'];
    $period_begin = $this->session['generate_invoices']['periodbegin'];
    $note         = $this->session['generate_invoices']['note'];

    // Calculate the end of the invoice period by adding 1 month to the beginning
    $period_begin_arr = getdate( $period_begin );
    $period_end = mktime( $period_begin_arr['hours'],
			  $period_begin_arr['minutes'],
			  $period_begin_arr['seconds'],
			  $period_begin_arr['mon'] + 1 > 12 ? 1 : $period_begin_arr['mon'] + 1,
			  $period_begin_arr['mday'],
			  $period_begin_arr['mon'] + 1 > 12 ? $period_begin_arr['year'] + 1 : $period_begin_arr['year'] );

    // Get all accounts
    $accountdbo_array = load_array_AccountDBO();

    // Generate an invoice for each account
    foreach( $accountdbo_array as $account )
      {
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

	// Insert invoice into database
	if( !add_InvoiceDBO( $invoice ) )
	  {
	    // Add failed
	    $this->setError( array( "type" => "DB_INVOICE_BATCH_FAILED" ) );
	    $this->goback( 1 );
	  }
      }

    // Success
    $this->setMessage( array( "type" => "INVOICE_BATCH_CREATED" ) );
    $this->goto( "billing_invoices" );
  }
}

?>
