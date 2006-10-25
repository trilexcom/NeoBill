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
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/PaymentDBO.class.php";

/**
 * BillingPaymentPage
 *
 * Receive a payment.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class BillingPaymentPage extends SolidStatePage
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
	if( isset( $this->post['continue'] ) )
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
    $invoice = isset( $this->post['invoiceint'] ) ? 
      $this->post['invoiceint'] : $this->post['invoiceselect'];

    // Create a new payment DBO
    $payment_dbo = new PaymentDBO();
    $payment_dbo->setInvoiceID( $invoice->getID() );
    $payment_dbo->setDate( $this->DB->format_datetime( $this->post['date'] ) );
    $payment_dbo->setAmount( $this->post['amount'] );
    $payment_dbo->setType( $this->post['type'] );
    $payment_dbo->setTransaction1( $this->post['transaction1'] );
    $payment_dbo->setTransaction2( $this->post['transaction2'] );
    $payment_dbo->setStatus( $this->post['status'] );

    // Insert Payment into database
    if( !add_PaymentDBO( $payment_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ADD_PAYMENT_FAILED" ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "PAYMENT_ENTERED" ) );
    $this->reload();
  }

  /**
   * Initialize the Add Payment Page
   */
  public function init()
  {
    parent::init();

    // Only display outstanding invoices in the drop-down menu
    $this->forms['billing_payment']->getField( "invoiceselect" )->getWidget()->filterOutstanding();
  }
}

?>