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
require_once $base_path . "solidworks/Page.class.php";

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
   * Initialize the Edit Payment Page
   *
   * If the Payment ID is provided in the query string, load the PaymentDBO from
   * the database and store it in the session.  Otherwise, use the DBO that is already
   * there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Account from the database
	$dbo = load_PaymentDBO( $id );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['payment_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Account
	$this->setError( array( "type" => "DB_PAYMENT_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['payment_dbo'] = $dbo;
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
	else
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
		 "id=" . $this->session['payment_dbo']->getInvoiceID() );
  }

  /**
   * Save Changes
   */
  function save()
  {
    $payment_dbo =& $this->session['payment_dbo'];
    $payment_data = $this->session['edit_payment'];

    // Update Payment DBO
    $payment_dbo->setDate( $this->DB->format_datetime( $payment_data['date'] ) );
    $payment_dbo->setAmount( $payment_data['amount'] );
    $payment_dbo->setTransaction1( $payment_data['transaction1'] );
    $payment_dbo->setTransaction2( $payment_data['transaction2'] );
    $payment_dbo->setType( $payment_data['type'] );
    if( !update_PaymentDBO( $payment_dbo ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_PAYMENT_UPDATE_FAILED" ) );
	$this->cancel();
      }

    // Success!
    $this->setMessage( array( "type" => "PAYMENT_UPDATED" ) );
    $this->cancel();
  }
}

?>