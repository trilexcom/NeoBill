<?php
/**
 * PSIPNPage.class.php
 *
 * This file contains the definition of the PSIPNPage class.
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
 * PPIPNPage
 *
 * Processes a Paypal Instant Payment Notification (IPN)
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PSIPNPage extends SolidStatePage
{
  /**
   * @var PaymentDBO Payment DBO
   */
  var $paymentDBO;

  /**
   * @var Paypal Paypal Module object
   */
  var $ppModule;

  /**
   * Action
   *
   * Actions handled by this page:
   *   ipn
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "ipn":
	$this->ipn();
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Payment
   */
  function deletePayment()
  {
    // Delete the payment
    if( !delete_PaymentDBO( $this->paymentDBO ) )
      {
	fatal_error( "PSIPNPage::deletePayment", 
		     sprintf( "Failed to delete payment. TXN=%s, Customer=%s, Amount=%s, Status=%s",
			      $_POST['txn_id'],
			      $_POST['payer_email'],
			      $_POST['mc_gross'],
			      $_POST['payment_status'] ) );
      }

    // Log the deleted payment
    log_notice( "PSIPNPage::deletePayment()", 
		sprintf( "Deleted Paypal payment. TXN=%s, Customer=%s, Amount=%s, Paypal Status=%s",
			 $_POST['txn_id'],
			 $_POST['payer_email'],
			 $_POST['mc_gross'],
			 $_POST['payment_status'] ) );
  }

  /**
   * Initialize the Page
   */
  function init()
  {
    $registry = ModuleRegistry::getModuleRegistry();
    $this->ppModule = $registry->getModule( 'paypalwps' );
  }

  /**
   * Process IPN
   */
  function ipn()
  {
    log_notice( "PSIPNPage::init()", "Processing an IPN..." );

    // Verify IPN
    if( !$this->ppModule->processIPN( $_POST ) )
      {
	fatal_error( "PSIPNPage::init()", "Failed to verify IPN" );
      }
    log_notice( "PSIPNPage::init()", "IPN verfied." );

    // Attempt to load the previous transaction from the database, if there is any
    $this->paymentDBO = 
      $this->ppModule->loadPaypalPaymentDBO( isset( $_POST['parent_txn_id'] ) ?
					     $_POST['parent_txn_id'] :
					     $_POST['txn_id'] );

    // Take action
    switch( $_POST['payment_status'] )
      {
      case "Canceled_Reversal":
	$this->paymentCanceledReversal();
	break;

      case "Processed":

      case "Completed":
	$this->paymentCompleted();
	break;

      case "In-Progress":

      case "Pending":
	$this->paymentPending();
	break;

      case "Refunded":
	$this->paymentRefunded();
	break;

      case "Reversed":
	$this->paymentReversed();
	break;

      case "Denied":

      case "Expired":

      case "Failed":

      case "Voided":

	$this->paymentVoided();
	break;

      default:
	fatal_error( "PSIPNPage::init()", 
		     "IPN was validated, but the payment status is not supported!" );
	break;
      }

    log_notice( "PSPIPNPage::init()", "Succesfully processed IPN." );
  }

  /**
   * Create a New Payment DBO and save it to the database
   *
   * @param string $status SolidState's Payment status (THIS IS NOT $_POST['payment_status'])
   */
  function newPayment( $status )
  {
    global $DB;

    // Construct a new Payment DBO
    $this->paymentDBO = new PaymentDBO();
    $this->paymentDBO->setDate( $DB->format_datetime( time() ) );
    $this->paymentDBO->setAmount( $_POST['mc_gross'] );
    $this->paymentDBO->setTransaction1( $_POST['txn_id'] );
    $this->paymentDBO->setTransaction2( $_POST['payer_email'] );
    $this->paymentDBO->setType( "Module" );
    $this->paymentDBO->setModule( $this->ppModule->getName() );
    $this->paymentDBO->setStatus( $status );
    if( isset( $_POST['custom'] ) )
      {
	// This IPN contains an order ID
	$this->paymentDBO->setOrderID( intval( $_POST['custom'] ) );
      }
    if( isset( $_POST['invoice'] ) )
      {
	// This IPN contains an invoice ID
	$this->paymentDBO->setInvoiceID( intval( $_POST['invoice'] ) );
      }


    // Add the Payment DBO to the database
    if( !add_PaymentDBO( $this->paymentDBO ) )
      {
	fatal_error( "PSIPNPage::newPayment()",
		     sprintf( "Failed to add Paypal payment to database.  Order id=%d, TXN=%s, Customer=%s, Amount=%s, Paypal Status=%s",
			      intval( $_POST['custom'] ),
			      $_POST['txn_id'],
			      $_POST['payer_email'],
			      $_POST['mc_gross'],
			      $_POST['payment_status'] ) );
      }

    // Log the new payment
    log_notice( "PSIPNPage::newPayment()", 
		sprintf( "New payment received from Paypal.  Order ID=%d, TXN=%s, Customer=%s, Amount=%s, Paypal Status=%s",
			 intval( $_POST['custom'] ),
			 $_POST['txn_id'],
			 $_POST['payer_email'],
			 $_POST['mc_gross'],
			 $_POST['payment_status'] ) );
  }

  /**
   * Process a Canceled Payment Reversal IPN
   */
  function paymentCanceledReversal()
  {
    if( $this->paymentDBO == null )
      {
	fatal_error( "PSIPNPage::paymentCanceledReversal()",
		     sprintf( "Received a Paypal Canceled Reversal IPN for a payment that does not exist! TXN=%s, Customer=%s, Amount=%s",
			      $_POST['txn_id'],
			      $_POST['payer_email'],
			      $_POST['mc_gross'] ) );
      }

    // Set the Payment's status back to completed
    $this->paymentDBO->setStatus( "Completed" );
    $this->updatePayment();
  }

  /**
   * Process a Completed Payment IPN
   */
  function paymentCompleted()
  {
    if( $this->paymentDBO == null )
      {
	// This is a new payment
	$this->newPayment( "Completed" );
      }
    else
      {
	// Update the current payment
	$this->paymentDBO->setStatus( "Completed" );
	$this->updatePayment();
      }
  }

  /**
   * Process a Pending Payment IPN
   */
  function paymentPending()
  {
    if( $this->paymentDBO == null )
      {
	// This is a new payment
	$this->newPayment( "Pending" );
      }
    else
      {
	// Update the current payment
	$this->paymentDBO->setStatus( "Pending" );
	$this->updatePayment();
      }
  }

  /**
   * Process a Refund Payment IPN
   */
  function paymentRefunded()
  {
    if( $this->paymentDBO == null )
      {
	fatal_error( "PSIPNPage::paymentRefund()",
		     sprintf( "Received a Paypal Refund IPN for a payment that does not exist! TXN=%s, Customer=%s, Amount=%s",
			      $_POST['txn_id'],
			      $_POST['payer_email'],
			      $_POST['mc_gross'] ) );
      }
    $this->paymentDBO->setStatus( "Refunded" );
    $this->updatePayment();
  }

  /**
   * Process a Refund Payment IPN
   */
  function paymentReversed()
  {
    if( $this->paymentDBO == null )
      {
	fatal_error( "PSIPNPage::paymentReversed()",
		     sprintf( "Received a Paypal Payment Reversed IPN for a payment that does not exist! TXN=%s, Customer=%s, Amount=%s, Reason=%s",
			      $_POST['txn_id'],
			      $_POST['payer_email'],
			      $_POST['mc_gross'],
			      $_POST['reason_code'] ) );
      }

    // Update the old transaction by setting its status to refunded
    $this->paymentDBO->setStatus( "Reversed" );
    $this->updatePayment();
  }

  /**
   * Process a Voided Payment IPN
   */
  function paymentVoided()
  {
    if( $this->paymentDBO == null )
      {
	fatal_error( "PSIPNPage::paymentVoided()",
		     sprinf( "Received a Paypal Denied / Expired / Failed / Voided IPN for a payment that does not exist! TXN=%s, Customer=%s, Amount=%s, Status=%s",
			     $_POST['txn_id'],
			     $_POST['payer_email'],
			     $_POST['mc_gross'],
			     $_POST['payment_status'] ) );
      }

    $this->deletePayment();
  }

  /**
   * Update Payment
   */
  function updatePayment()
  {
    if( !update_PaymentDBO( $this->paymentDBO ) )
      {
	fatal_error( "PSIPNPage::paymentCompleted()",
		     "Failed to update Payment!" );
      }
    log_notice( "PSIPNPage::paymentCompleted()", 
		sprintf( "Updated Paypal payment.  TXN=%s, Customer=%s", 
			 $_POST['txn_id'],
			 $_POST['payer_email'] ) );
  }
}
?>