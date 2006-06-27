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

    $this->session['order']->setRemoteIP( ip2long( $_SERVER['REMOTE_ADDR'] ) );
    $this->session['order']->setDateCreated( $DB->format_datetime( time() ) );

    // If the order does not have an ID already, save it to the database
    if( $this->session['order']->getID() == null && 
	!add_OrderDBO( $this->session['order'] ) )
      {
	fatal_error( "ReviewPage::checkout()", "Failed to add Order to database!" );
      }

    // Hand-off to the payment module to collect the balance due
    $paymentModule = $this->conf['modules'][$this->session['review']['module']];
    $this->goto( $paymentModule->getOrderCheckoutPage() );
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
	if( (is_a( $moduleDBO, "PaymentProcessorModule" ) ||
	     is_a( $moduleDBO, "PaymentGatewayModule" )) &&
	    $moduleDBO->isEnabled() )
	  {
	    $values[$moduleDBO->getName()] = $moduleDBO->getShortDescription();
	  }
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
