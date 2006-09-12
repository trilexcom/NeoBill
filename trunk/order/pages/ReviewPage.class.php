<?php
/**
 * ReviewPage.class.php
 *
 * This file contains the definition for the ReviewPage class
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

// Payment DBO
require_once $base_path . "DBO/PaymentDBO.class.php";

/**
 * ReviewPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ReviewPage extends Page
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
      case "review":
	if( isset( $this->session['review']['back'] ) )
	  {
	    if( $this->session['order']->getAccountID() != null &&
		$this->session['order']->getDomainItems() == null )
	      {
		$this->goto( "cart" );
	      }
	    $this->goto( "customer" );
	  }
	elseif( isset( $this->session['review']['checkout'] ) )
	  {
	    $this->checkout();
	  }
	elseif( isset( $this->session['review']['startover'] ) )
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
   * Check Out
   */
  function checkout()
  {
    global $DB;

    // The module must have been picked if this is not an existing customer
    if( $this->session['order']->getAccountType() == "New Account" &&
	!isset( $this->session['review']['module'] ) )
      {
	$this->setError( array( "type" => "YOU_MUST_SELECT_PAYMENT" ) );
	return;
      }

    $this->session['order']->setRemoteIP( ip2long( $_SERVER['REMOTE_ADDR'] ) );
    $this->session['order']->setDateCreated( $DB->format_datetime( time() ) );

    // If the order does not have an ID already, save it to the database
    if( $this->session['order']->getID() == null && 
	!add_OrderDBO( $this->session['order'] ) )
      {
	fatal_error( "ReviewPage::checkout()", "Failed to add Order to database!" );
      }

    if( $this->session['order']->getAccountType() == "Existing Account" )
      {
	// Send existing accounts off to the receipt page
	$this->session['order']->complete();
	$this->goto( "receipt" );
      }

    if( $this->session['review']['module'] == "Check" )
      {
	// Record the promise to pay by check
	$checkPayment = new PaymentDBO();
	$checkPayment->setOrderID( $this->session['order']->getID() );
	$checkPayment->setAmount( $this->session['order']->getTotal() );
	$checkPayment->setStatus( "Pending" );
	$checkPayment->setDate( $DB->format_datetime( time() ) );
	$checkPayment->setType( "Check" );
	if( !add_PaymentDBO( $checkPayment ) )
	  {
	    fatal_error( "ReviewPage::checkout()", 
			 "Failed to record payment by check!" );
	  }

	// Goto the receipt page
	$this->session['order']->complete();
	$this->goto( "receipt", null, "payByCheck=1" );
      }

    // Collect Payment
    $paymentModule = $this->conf['modules'][$this->session['review']['module']];
    $checkoutPage = $paymentModule->getType() == "payment_processor" ?
      $paymentModule->getOrderCheckoutPage() : "ccpayment";

    $_SESSION['module'] = $paymentModule;
    $this->goto( $checkoutPage );
  }

  /**
   * Initialize Review Page
   */
  function init()
  {
    // Give access to the template
    $this->session['order'] =& $_SESSION['order'];

    // Calculate tax on the order
    $this->session['order']->calculateTaxes();

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
   * Populate the Payment Method drop-down
   */
  function populateMethodField()
  {
    // Place all payment processors and payment gateways in the drop-down
    $values = array();
    foreach( $this->conf['modules'] as $moduleDBO )
      {
	// Add each payment module to the list
	if( (is_a( $moduleDBO, "PaymentProcessorModule" ) ||
	     is_a( $moduleDBO, "PaymentGatewayModule" )) &&
	    $moduleDBO->isEnabled() )
	  {
	    $values[$moduleDBO->getName()] = $moduleDBO->getShortDescription();
	  }
      }
    if( $this->conf['order']['accept_checks'] )
      {
	// Add check or money order to the list
	$values['Check'] = translate_string( $this->conf['locale']['language'],
					     "[CHECK_OR_MONEY_ORDER]" );
      }

    return $values;
  }

  /**
   * Populate the Order Table
   */
  function populateOrderTable()
  {
    return $this->session['order']->getItems();
  }
}
?>