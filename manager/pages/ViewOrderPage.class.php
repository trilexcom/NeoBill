<?php
/**
 * ViewOrderPage.class.php
 *
 * This file contains the definition for the View Order Page class
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
 * ViewOrderPage
 *
 * Display an order.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewOrderPage extends Page
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
      case "order":
	if( isset( $this->session['order']['execute'] ) )
	  {
	    $this->execute();
	  }
	elseif( isset( $this->session['order']['save'] ) )
	  {
	    $this->save();
	  }
	elseif( isset( $this->session['order']['delete'] ) )
	  {
	    $this->delete();
	  }
	break;
	
      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Order
   */
  function delete()
  {
    if( !delete_OrderDBO( $this->orderDBO ) )
      {
	fatal_error( "ViewOrderPage::delete()",
		     "Could not delete Order.  ID = " . $this->orderDBO->getID() );
      }

    // Success
    $this->setMessage( array( "type" => "ORDER_DELETED",
			      "args" => array( $this->orderDBO->getID() ) ) );
    $this->goto( "pending_orders" );
  }

  /**
   * Execute Order
   */
  function execute()
  {
    // Save any changes made to the order
    $this->saveChanges();

    // Redirect to the execute order page
    $this->goto( "execute_order", null, sprintf( "id=%d", $this->orderDBO->getID() ) );
  }

  /**
   * Initialize the View Order Page
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
	fatal_error( "ViewOrderPage::init()", 
		     "Could not load Order.  ID = " . $_GET['id'] );
      }

    // Store item id's in the session to be used for the "Accept" checkboxes
    foreach( $this->orderDBO->getItems() as $itemDBO )
      {
	$this->session['itemids'][] = $itemDBO->getOrderItemID();
      }

    // Set Nav vars
    $this->setNavVar( "order_id", $this->orderDBO->getID() );
  }

  /**
   * Populate the Order Item's Table
   *
   * @return array An array of all OrderItemDBO's for this Order
   */
  function populateItemTable()
  {
    return $this->orderDBO->getItems();
  }
  
  /**
   * Populate the Order Payment Table
   *
   * @return array An array of all PaymentDBO's for this Order
   */
  function populatePaymentTable()
  {
    return $this->orderDBO->getPayments();
  }
  
  /**
   * Save Order
   */
  function save()
  {
    if( !$this->saveChanges() )
      {
	// DB Error
	fatal_error( "ViewOrderPage::save()",
		     "Could not update Order. ID = " . $this->orderDBO->getID() );
      }

    $this->setMessage( array( "type" => "ORDER_SAVED" ) );
  }

  /**
   * Save Changes
   *
   * Write any changes made to the order to the database
   *
   * @return boolean True for success
   */
  function saveChanges()
  {
    // Update OrderDBO
    $this->orderDBO->setContactName( $this->session['order']['contactname'] );
    $this->orderDBO->setContactEmail( $this->session['order']['contactemail'] );
    $this->orderDBO->setAddress1( $this->session['order']['address1'] );
    $this->orderDBO->setAddress2( $this->session['order']['address2'] );
    $this->orderDBO->setCity( $this->session['order']['city'] );
    $this->orderDBO->setState( $this->session['order']['state'] );
    $this->orderDBO->setCountry( $this->session['order']['country'] );
    $this->orderDBO->setPostalCode( $this->session['order']['postalcode'] );
    $this->orderDBO->setPhone( $this->session['order']['phone'] );
    $this->orderDBO->setMobilePhone( $this->session['order']['mobilephone'] );
    $this->orderDBO->setFax( $this->session['order']['fax'] );

    foreach( $this->orderDBO->getItems() as $itemDBO )
      {
	if( in_array( $itemDBO->getOrderItemID(), $this->session['order']['accepted'] ) )
	  {
	    $this->orderDBO->acceptItem( $itemDBO->getOrderItemID() );
	  }
	else
	  {
	    $this->orderDBO->rejectItem( $itemDBO->getOrderItemID() );
	  }
      }

    // Save changes to database
    return update_OrderDBO( $this->orderDBO );
  }
}

?>