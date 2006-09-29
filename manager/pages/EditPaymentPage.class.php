<?php
/**
 * EditPaymentPage.class.php
 *
 * This file contains the definition for the EditPaymentPage class
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
 * EditPaymentPage
 *
 * Edit Payment information and save any changes to the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditPaymentPage extends Page
{
  /**
   * @var PaymentDBO The payment being worked on
   */
  var $paymentDBO = null;

  /**
   * Initialize the Edit Payment Page
   *
   * If the Payment ID is provided in the query string, load the PaymentDBO from
   * the database and store it in the session.  Otherwise, use the DBO that is already
   * there.
   */
  function init()
  {
    $this->paymentDBO =& $this->session['payment_dbo'];
    if( isset( $_GET['id'] ) )
      {
	// Retrieve the Account from the database
	$this->paymentDBO = load_PaymentDBO( intval( $_GET['id'] ) );
      }
    if( !isset( $this->paymentDBO ) )
      {
	// Could not find Account
	$this->setError( array( "type" => "DB_PAYMENT_NOT_FOUND",
				"args" => array( $id ) ) );
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_payment (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_payment":
	if( isset( $this->session['edit_payment']['save'] ) )
	  {
	    $this->save();
	  }
	elseif( isset( $this->session['edit_payment']['capture'] ) )
	  {
	    $this->capture();
	  }
	elseif( isset( $this->session['edit_payment']['void'] ) )
	  {
	    $this->void();
	  }
	elseif( isset( $this->session['edit_payment']['refund'] ) )
	  {
	    $this->refund();
	  }
	elseif( isset( $this->session['edit_payment']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;
	
      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }

  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goto( "billing_view_invoice",
		 null,
		 "id=" . $this->paymentDBO->getInvoiceID() );
  }

  /**
   * Capture a Previously Authorized Payment
   */
  function capture()
  {
    // Capture payment
    if( !$this->paymentDBO->capture() )
      {
	// There was an error processing the transaction
	$this->setError( array( "type" => "CC_TRANSACTION_FAILED" ) );
	return;
      }

    // Update the payment record
    if( !update_PaymentDBO( $this->paymentDBO ) )
      {
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
      }

    if( $paymentDBO->getStatus() == "Declined" )
      {
	// Transaction was declined
	$this->setError( array( "type" => "CC_CAPTURE_DECLINED" ) );
	return;
      }

    // Success
    $this->setMessage( array( "type" => "CC_CAPTURED" ) );
  }

  /**
   * Refund Payment
   */
  function refund()
  {
    // Capture payment
    if( !$this->paymentDBO->refund() )
      {
	// There was an error processing the transaction
	$this->setError( array( "type" => "CC_TRANSACTION_FAILED" ) );
	return;
      }

    if( $paymentDBO->getStatus() == "Declined" )
      {
	// Transaction was declined
	$this->setError( array( "type" => "CC_REFUND_DECLINED" ) );
	return;
      }

    // Update the payment record
    if( !update_PaymentDBO( $this->paymentDBO ) )
      {
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
      }

    // Success
    $this->setMessage( array( "type" => "CC_REFUNDED" ) );
  }

  /**
   * Save Changes
   */
  function save()
  {
    $payment_data = $this->session['edit_payment'];

    // Update Payment DBO
    $this->paymentDBO->setDate( $this->DB->format_datetime( $payment_data['date'] ) );
    $this->paymentDBO->setAmount( $payment_data['amount'] );
    $this->paymentDBO->setTransaction1( $payment_data['transaction1'] );
    $this->paymentDBO->setTransaction2( $payment_data['transaction2'] );
    $this->paymentDBO->setStatus( $payment_data['status'] );
    $this->paymentDBO->setStatusMessage( $payment_data['statusmessage'] );
    if( !update_PaymentDBO( $this->paymentDBO ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
      }

    // Success!
    $this->setMessage( array( "type" => "PAYMENT_UPDATED" ) );
  }

  /**
   * Void a Previously Authorized Payment
   */
  function void()
  {
    if( !$this->paymentDBO->void() )
      {
	// There was an error processing the transaction
	$this->setError( array( "type" => "CC_TRANSACTION_FAILED" ) );
	return;
      }

    if( $paymentDBO->getStatus() == "Declined" )
      {
	// Transaction was declined
	$this->setError( array( "type" => "CC_VOID_DECLINED" ) );
	return;
      }

    // Update the payment record
    if( !update_PaymentDBO( $this->paymentDBO ) )
      {
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
      }

    // Success
    $this->setMessage( array( "type" => "CC_VOIDED" ) );
  }
}

?>