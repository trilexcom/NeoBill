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
require_once $base_path . "solidworks/Page.class.php";

// Order DBO
require_once $base_path . "DBO/OrderDBO.class.php";

/**
 * CCPaymentPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CCPaymentPage extends Page
{
  /**
   * @var PaymentGatewayModule The payment gateway module that will process this card
   */
  var $pgModule;

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
	if( isset( $this->session['creditcard']['authorize'] ) )
	  {
	    $this->processCard();
	  }
	elseif( isset( $this->session['creditcard']['back'] ) )
	  {
	    $this->back();
	  }
	elseif( isset( $this->session['creditcard']['startover'] ) )
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
    // Access the payment gateway module selected on the previous page
    $this->pgModule =& $this->session['module'];
    if( !isset( $this->pgModule ) )
      {
	if( !is_a( $_SESSION['module'], "PaymentGatewayModule" ) )
	  {
	    fatal_error( "CCPaymentPage::init()", "Invalid module or no module provided!" );
	  }
	$this->pgModule = $_SESSION['module'];
	unset( $_SESSION['module'] );
      }

    // Reference the order object from the local session so the template can see it
    $this->session['order'] =& $_SESSION['order'];
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
    $billingContact = new ContactDBO( $this->session['creditcard']['contactname'],
				      null,
				      null,
				      $this->session['creditcard']['address1'],
				      $this->session['creditcard']['address2'],
				      $this->session['creditcard']['city'],
				      $this->session['creditcard']['state'],
				      $this->session['creditcard']['postalcode'],
				      $this->session['creditcard']['country'],
				      $this->session['creditcard']['phone'],
				      null,
				      null );
    // Format the expire date
    $expireDate = strftime( "%m%y", $this->session['creditcard']['cardexpire'] );

    // Create a new Payment DBO and process the payment
    $paymentDBO = new PaymentDBO();
    $paymentDBO->setType( "Module" );
    $paymentDBO->setModule( $this->pgModule->getName() );
    $paymentDBO->setOrderID( $this->session['order']->getID() );
    $paymentDBO->setAmount( $this->session['order']->getTotal() );
    if( !$paymentDBO->processCreditCard( $billingContact,
					 $this->session['creditcard']['cardnumber'],
					 $expireDate,
					 $this->session['creditcard']['cardcode'],
					 $this->conf['payment_gateway']['order_method'] ) )
      {
	$this->setError( array( "type" => "CC_PROCESSING_ERROR" ) );
	$this->goback( 1 );
      }

    // Card processed, save the payment DBO
    if( !add_PaymentDBO( $paymentDBO ) )
      {
	fatal_error( "CCPaymentPage::processCard()",
		     "Failed to save Payment to database!" );
      }

    // Complete the order
    $_SESSION['order']->complete();

    // Show receipt
    $this->goto( "receipt" );
  }
}
?>