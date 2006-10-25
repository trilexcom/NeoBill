<?php
/**
 * CCPaymentPage.class.php
 *
 * This file contains the definition for the CCPaymentPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

// Order DBO
require_once BASE_PATH . "DBO/OrderDBO.class.php";

/**
 * CCPaymentPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CCPaymentPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "creditcard":
	if( isset( $this->post['authorize'] ) )
	  {
	    $this->processCard();
	  }
	elseif( isset( $this->post['back'] ) )
	  {
	    $this->back();
	  }
	elseif( isset( $this->post['startover'] ) )
	  {
	    $this->newOrder();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Go Back (to Review Page)
   */
  function back() { $this->goto( "review" ); }

  /**
   * Initialize Page
   */
  function init()
  {
    parent::init();

    // Reference the order object from the local session so the template can see it
    $this->session['order'] =& $_SESSION['order'];

    // Supress the login link
    $this->smarty->assign( "supressWelcome", true );
  }

  /**
   * Start New Order
   */
  function newOrder()
  {
    // Start a new order
    unset( $_SESSION['order'] );
    $this->goto( "cart" );
  }

  /**
   * Process Credit Card Payment
   */
  function processCard()
  {
    // Update contact information
    $billingContact = new ContactDBO( $this->post['contactname'],
				      null,
				      null,
				      $this->post['address1'],
				      $this->post['address2'],
				      $this->post['city'],
				      $this->post['state'],
				      $this->post['postalcode'],
				      $this->post['country'],
				      $this->post['phone'],
				      null,
				      null );
    // Format the expire date
    $expireDate = strftime( "%m%y", $this->post['cardexpire'] );

    // Create a new Payment DBO and process the payment
    $paymentDBO = new PaymentDBO();
    $paymentDBO->setType( "Module" );
    $paymentDBO->setModule( $_SESSION['module']->getName() );
    $paymentDBO->setOrderID( $this->session['order']->getID() );
    $paymentDBO->setAmount( $this->session['order']->getTotal() );
    if( !$paymentDBO->processCreditCard( $billingContact,
					 $this->post['cardnumber'],
					 $expireDate,
					 $this->post['cardcode'],
					 $this->conf['payment_gateway']['order_method'] ) )
      {
	$this->setError( array( "type" => "CC_PROCESSING_ERROR" ) );
	$this->reload();
      }

    // Card processed, save the payment DBO
    if( !add_PaymentDBO( $paymentDBO ) )
      {
	throw new SWException( "Failed to save Payment to database!" );
      }

    // Complete the order
    $_SESSION['order']->complete();

    // Show receipt
    $this->goto( "receipt" );
  }
}
?>