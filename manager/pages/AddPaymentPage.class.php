<?php
/**
 * AddPaymentPage.class.php
 *
 * This file contains the definition for the AddPaymentPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

require_once BASE_PATH . "DBO/PaymentDBO.class.php";

/**
 * AddPaymentPage
 *
 * Receive a Payment.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddPaymentPage extends Page
{
  /**
   * Initialize Add Payment Page
   *
   * If the Account ID and/or the Invoice ID is provided in the query string, then
   * load those DBOs and store them in the session.
   */
  function init()
  {
    $account_id = $_GET['id'];
    $invoice_id = $_GET['invoiceid'];

    if( isset( $invoice_id ) )
      {
	// Retrieve the Invoice from the database
	if( ($invoice_dbo = load_InvoiceDBO( intval( $invoice_id ) )) == null )
	  {
	    fatal_error( "AddPaymentPage::init()",
			 "could not load Invoice! id = " . $invoice_id );
	  }
	$account_id = $invoice_dbo->getAccountID();
	$this->session['invoice_dbo'] = $invoice_dbo;
	$this->smarty->assign( "invoice_id", $invoice_dbo->getID() );
      }

    if( isset( $account_id ) )
      {
	// Retrieve the Account from the database
	$dbo = load_AccountDBO( intval( $account_id ) );
	// Set this page's Nav Vars
	$this->setNavVar( "account_id",   $dbo->getID() );
	$this->setNavVar( "account_name", $dbo->getAccountName() );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['account_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Account
	$this->setError( array( "type" => "DB_ACCOUNT_NOT_FOUND",
				"args" => array( $account_id ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['account_dbo'] = $dbo;
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   new_payment
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "new_payment":

	if( isset( $this->session['new_payment']['cancel'] ) )
	  {
	    // Cancel
	    $this->goto( "accounts_view_account",
			 null,
			 "id=" . $this->session['account_dbo']->getID() .
			 "&action=billing" );
	  }
	elseif( isset( $this->session['new_payment']['continue'] ) )
	  {
	    // Add Payment
	    $this->add_payment();
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Add Payment
   *
   * Create a new PaymentDBO and add it to the database
   */
  function add_payment()
  {
    $invoice_id   = isset( $this->session['invoice_dbo'] ) ? $this->session['invoice_dbo']->getID() : $this->session['new_payment']['invoiceid'];
    $payment_date = $this->session['new_payment']['date'];
    $amount       = $this->session['new_payment']['amount'];
    $type         = $this->session['new_payment']['type'];
    $transaction1 = $this->session['new_payment']['transaction1'];
    $transaction2 = $this->session['new_payment']['transaction2'];

    // Validate the invoice ID
    if( !isset( $this->session['invoice_dbo'] ) &&
	load_InvoiceDBO( $invoice_id ) == null )
      {
	// Invalid Invoice ID
	fatal_error( "AddPaymentPage.class.php::add_payment()",
		     "could not load invoice! id = " . $invoice_id );
      }

    // Create a new payment DBO
    $payment_dbo = new PaymentDBO();
    $payment_dbo->setInvoiceID( $invoice_id );
    $payment_dbo->setDate( $this->DB->format_datetime( $payment_date ) );
    $payment_dbo->setAmount( $amount );
    $payment_dbo->setType( $type );
    $payment_dbo->setStatus( "Completed" );
    $payment_dbo->setTransaction1( $transaction1 );
    $payment_dbo->setTransaction2( $transaction2 );

    // Insert Payment into database
    if( !add_PaymentDBO( $payment_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ADD_PAYMENT_FAILED" ) );
	$this->goback( 1 );
      }

    // Success
    $this->setMessage( array( "type" => "PAYMENT_ENTERED" ) );
    $this->goto( "billing_view_invoice",
		 null,
		 "id=" . $payment_dbo->getInvoiceID() );
  }
}

?>