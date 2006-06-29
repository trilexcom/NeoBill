<?php
/**
 * BillingPaymentPage.class.php
 *
 * This file contains the definition for the Billing Payment Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/PaymentDBO.class.php";

/**
 * BillingPaymentPage
 *
 * Receive a payment.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class BillingPaymentPage extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   billing_payment (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "billing_payment":

	if( isset( $this->session['billing_payment']['continue'] ) )
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
   * Create a PaymentDBO and add it to the database
   */
  function add_payment()
  {
    // If the use entered the Invoice ID directly, use that.  Otherwise, use the
    // Invoice selected from the drop-down menu
    $invoice_id   = isset( $this->session['billing_payment']['invoiceid_int'] ) ? 
      $this->session['billing_payment']['invoiceid_int'] : 
      $this->session['billing_payment']['invoiceid_select'];

    $payment_date = $this->session['billing_payment']['date'];
    $amount       = $this->session['billing_payment']['amount'];
    $type         = $this->session['billing_payment']['type'];
    $transaction1 = $this->session['billing_payment']['transaction1'];
    $transaction2 = $this->session['billing_payment']['transaction2'];

    // Validate the invoice ID
    if( load_InvoiceDBO( $invoice_id ) == null )
      {
	// Invalid Invoice ID
	fatal_error( "BillingPaymentPage::add_payment()",
		     "could not load invoice! id = " . $invoice_id );
      }

    // Create a new payment DBO
    $payment_dbo = new PaymentDBO();
    $payment_dbo->setInvoiceID( $invoice_id );
    $payment_dbo->setDate( $this->DB->format_datetime( $payment_date ) );
    $payment_dbo->setAmount( $amount );
    $payment_dbo->setType( $type );
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
    $this->goback( 1 );
  }
}

?>