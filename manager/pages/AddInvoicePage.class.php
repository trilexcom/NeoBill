<?php
/**
 * AddInvoicePage.class.php
 *
 * This file contains the definition for the AddInvoicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/AccountDBO.class.php";
require_once $base_path . "DBO/InvoiceDBO.class.php";

/**
 * AddInvoicePage
 *
 * Creates a new invoice.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddInvoicePage extends Page
{
  /**
   * Initialize Add Invoice Page
   *
   * If an account ID is provided in the query string, then the Invoice will be
   * created for that account.  Otherwise, the user must select the account via 
   * the form
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Account from the database
	$this->session['account_dbo'] = load_AccountDBO( intval( $id ) );
      }

    if( isset( $this->session['account_dbo'] ) )
      {
	$this->smarty->assign( "account",
			       $this->session['account_dbo']->getID() );
	$this->smarty->assign( "account_name", 
			       $this->session['account_dbo']->getAccountName() );
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   new_invoice
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "new_invoice":

	if( isset( $this->session['new_invoice']['cancel'] ) )
	  {
	    // Cancel
	    $this->cancel();
	  }
	elseif( isset( $this->session['new_invoice']['continue'] ) )
	  {
	    // Generate Invoice
	    $this->generate_invoice();
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Form Canceled
   */
  function cancel()
  {
    if( isset( $this->session['account_dbo'] ) )
      {
	$this->goto( "accounts_view_account",
		     null,
		     "id=" . $this->session['account_dbo']->getID() .
		     "&action=billing" );
      }
    else
      {
	$this->goback();
      }
  }

  /**
   * Generate Invoice
   *
   * Creates a new Invoice and adds it to the database.
   */
  function generate_invoice()
  {
    if( isset( $this->session['account_dbo'] ) )
      {
	// Account ID provided as a page parameter
	$account_id = $this->session['account_dbo']->getID();
      }
    else
      {
	// Account ID provided in form
	$account_id = $this->session['new_invoice']['accountid'];
      }

    $invoice_date = $this->session['new_invoice']['date'];
    $terms        = $this->session['new_invoice']['terms'];
    $period_begin = $this->session['new_invoice']['periodbegin'];
    $note         = $this->session['new_invoice']['note'];

    // Calculate the end of the invoice period by adding 1 month to the beginning
    $period_begin_arr = getdate( $period_begin );
    $period_end = mktime( $period_begin_arr['hours'],
			  $period_begin_arr['minutes'],
			  $period_begin_arr['seconds'],
			  $period_begin_arr['mon'] + 1 > 12 ? 1 : $period_begin_arr['mon'] + 1,
			  $period_begin_arr['mday'],
			  $period_begin_arr['mon'] + 1 > 12 ? $period_begin_arr['year'] + 1 : $period_begin_arr['year'] );

    // Create a new invoice DBO
    $invoice = new InvoiceDBO();
    $invoice->setAccountID( $account_id );
    $invoice->setDate( $this->DB->format_datetime( $invoice_date ) );
    $invoice->setPeriodBegin( $this->DB->format_datetime( $period_begin ) );
    $invoice->setPeriodEnd( $this->DB->format_datetime( $period_end ) );
    $invoice->setNote( $note );
    $invoice->setTerms( $terms );

    // Generate lineitems
    $invoice->generate();

    // Insert invoice into database
    if( !add_InvoiceDBO( $invoice ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ADD_INVOICE_FAILED" ) );
	$this->goback( 1 );
      }

    // Success
    $this->setMessage( array( "type" => "INVOICE_CREATED" ) );
    $this->goto( "billing_view_invoice",
		 null,
		 "id=" . $invoice->getID() );
  }

}

?>