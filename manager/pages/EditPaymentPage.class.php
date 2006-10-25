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
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/PaymentDBO.class.php";

/**
 * EditPaymentPage
 *
 * Edit Payment information and save any changes to the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditPaymentPage extends SolidStatePage
{
  /**
   * Initialize the Edit Payment Page
   */
  function init()
  {
    parent::init();
    
    // Set URL Fields
    $this->setURLField( "payment", $this->get['payment']->getID() );

    // Give the template access to the Payment DBO
    $this->session['payment_dbo'] =& $this->get['payment'];
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
    $this->goback();
  }

  /**
   * Capture a Previously Authorized Payment
   */
  function capture()
  {
    // Capture payment
    if( !$this->get['payment']->capture() )
      {
	// There was an error processing the transaction
	$this->setError( array( "type" => "CC_TRANSACTION_FAILED" ) );
	$this->reload();
      }

    // Update the payment record
    if( !update_PaymentDBO( $this->get['payment'] ) )
      {
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
      }

    if( $this->get['payment']->getStatus() == "Declined" )
      {
	// Transaction was declined
	$this->setError( array( "type" => "CC_CAPTURE_DECLINED" ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "CC_CAPTURED" ) );
    $this->reload();
  }

  /**
   * Refund Payment
   */
  function refund()
  {
    // Capture payment
    if( !$this->get['payment']->refund() )
      {
	// There was an error processing the transaction
	$this->setError( array( "type" => "CC_TRANSACTION_FAILED" ) );
	$this->reload();
      }

    if( $this->get['payment']->getStatus() == "Declined" )
      {
	// Transaction was declined
	$this->setError( array( "type" => "CC_REFUND_DECLINED" ) );
	$this->reload();
      }

    // Update the payment record
    if( !update_PaymentDBO( $this->get['payment'] ) )
      {
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "CC_REFUNDED" ) );
    $this-reload();
  }

  /**
   * Save Changes
   */
  function save()
  {
    // Update Payment DBO
    $this->get['payment']->setDate( $this->DB->format_datetime( $this->post['date'] ) );
    $this->get['payment']->setAmount( $this->post['amount'] );
    $this->get['payment']->setTransaction1( $this->post['transaction1'] );
    $this->get['payment']->setTransaction2( $this->post['transaction2'] );
    $this->get['payment']->setStatus( $this->post['status'] );
    $this->get['payment']->setStatusMessage( $this->post['statusmessage'] );
    if( !update_PaymentDBO( $this->get['payment'] ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Success!
    $this->setMessage( array( "type" => "PAYMENT_UPDATED" ) );
    $this->reload();
  }

  /**
   * Void a Previously Authorized Payment
   */
  function void()
  {
    if( !$this->get['payment']->void() )
      {
	// There was an error processing the transaction
	$this->setError( array( "type" => "CC_TRANSACTION_FAILED" ) );
	$this->reload();
      }

    if( $this->get['payment']->getStatus() == "Declined" )
      {
	// Transaction was declined
	$this->setError( array( "type" => "CC_VOID_DECLINED" ) );
	$this->reload();
      }

    // Update the payment record
    if( !update_PaymentDBO( $this->get['payment'] ) )
      {
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "CC_VOIDED" ) );
    $this->reload();
  }
}

?>