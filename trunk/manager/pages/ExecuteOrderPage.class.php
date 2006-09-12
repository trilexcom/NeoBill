<?php
/**
 * ExecuteOrderPage.class.php
 *
 * This file contains the definition for the Execute Order Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// OrderDBO class
require_once $base_path . "DBO/OrderDBO.class.php";

/**
 * ExecuteOrderPage
 *
 * Display an order.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ExecuteOrderPage extends Page
{
  /**
   * @var OrderDBO The order
   */
  var $orderDBO = null;

  /**
   * Action
   *
   * Actions handled by this page:
   *   browse_accounts_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "execute_order":
	if( isset( $this->session['execute_order']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	elseif( isset( $this->session['execute_order']['continue'] ) )
	  {
	    $this->execute();
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
    $this->goto( "view_order", null, sprintf( "id=%d", $this->orderDBO->getID() ) );
  }

  /**
   * Execute the Order
   */
  function execute()
  {
    // Execute the order
    switch( $this->orderDBO->getAccountType() )
      {
      case "New Account":
	if( !$this->orderDBO->executeNewAccount( $this->session['execute_order']['type'],
						 $this->session['execute_order']['status'],
						 $this->session['execute_order']['billingstatus'],
						 $this->session['execute_order']['billingday'] ) )
	  {
	    fatal_error( "ExecuteOrderPage::execut()", 
			 "Failed to execute Order.  ID=" . $this->orderDBO->getID() );
	  }
	break;

      case "Existing Account":
	if( !$this->orderDBO->execute() )
	  {
	    fatal_error( "ExecuteOrderPage::execut()", 
			 "Failed to execute Order.  ID=" . $this->orderDBO->getID() );
	  }
	break;

      default:
	fatal_error( "ExecuteOrderPage::execute()",
		     "Failed to execute order: invalid account type." );
      }
	
    // Jump to the view account page
    $this->goto( "accounts_view_account", 
		 null, 
		 sprintf( "id=%d", $this->orderDBO->getAccountID() ) );
  }

  /**
   * Initialize the Execute Order Page
   */
  function init()
  {
    $this->orderDBO =& $this->session['orderdbo'];
    if( isset( $_GET['id'] ) )
      {
	// Retrieve the Order from the database
	$this->orderDBO = load_OrderDBO( intval( $_GET['id'] ) );
      }

    if( !isset( $this->orderDBO ) )
      {
	// Could not find Server
	fatal_error( "ExecuteOrderPage::init()", 
		     "Could not load Order.  ID = " . $_GET['id'] );
      }

    // Set Nav vars
    $this->setNavVar( "order_id", $this->orderDBO->getID() );

    // Go ahead and execute if this is an existing customer
    if( $this->orderDBO->getAccountType() == "Existing Account" )
      {
	$this->execute();
      }
  }

  /**
   * Populate the Order Item's Table
   *
   * @return array An array of all OrderItemDBO's for this Order
   */
  function populateItemTable()
  {
    return $this->orderDBO->getAcceptedItems();
  }
  
}
?>