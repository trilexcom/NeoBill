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
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/PaymentDBO.class.php";

/**
 * AddPaymentPage
 *
 * Receive a Payment.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddPaymentPage extends SolidStatePage
{
  /**
   * @var AccountDBO Account making the payment
   */
  protected $account;

  /**
   * @var InvoiceDBO Invoice to pay
   */
  protected $invoice;

  /**
   * Initialize Add Payment Page
   *
   * If the Account ID and/or the Invoice ID is provided in the query string, then
   * load those DBOs and store them in the session.
   */
  function init()
  {
    parent::init();

    if( isset( $this->get['invoice'] ) )
      {
	$this->setURLField( "invoice", $this->get['invoice']->getID() );
	$this->smarty->assign( "invoice_id", $this->get['invoice']->getID() );
	$this->session['invoice_dbo'] =& $this->get['invoice'];
      }

    // Indicate to the InvoiceSelect widget that we only want to display 
    // invoices for this account
    $ISWidget =& $this->forms['new_payment']->getField( "invoice" )->getWidget();
    $ISWidget->setAccountID( $this->get['account']->getID() );

    $this->setURLField( "account", $this->get['account']->getID() );
    $this->setNavVar( "account_id", $this->get['account']->getID() );
    $this->setNavVar( "account_name", $this->get['account']->getAccountName() );
    $this->session['account_dbo'] =& $this->get['account'];
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
	if( isset( $this->post['cancel'] ) )
	  {
	    // Cancel
	    $this->goback();
	  }
	elseif( isset( $this->post['continue'] ) )
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
    // Create a new payment DBO
    $invoice_id   = isset( $this->get['invoice'] ) ? 
      $this->get['invoice']->getID() : 
      $this->session['new_payment']['invoice']->getID();
    $payment_dbo = new PaymentDBO();
    $payment_dbo->setInvoiceID( $invoice_id );
    $payment_dbo->setDate( $this->DB->format_datetime( $this->post['date'] ) );
    $payment_dbo->setAmount( $this->post['amount'] );
    $payment_dbo->setType( $this->post['type'] );
    $payment_dbo->setStatus( "Completed" );
    $payment_dbo->setTransaction1( $this->post['transaction1'] );
    $payment_dbo->setTransaction2( $this->post['transaction2'] );

    // Insert Payment into database
    if( !add_PaymentDBO( $payment_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ADD_PAYMENT_FAILED" ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "PAYMENT_ENTERED" ) );
    $this->goto( "billing_view_invoice",
		 null,
		 "invoice=" . $payment_dbo->getInvoiceID() );
  }
}

?>