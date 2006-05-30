<?php
/**
 * CartPage.class.php
 *
 * This file contains the definition for the CartPage class
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
 * CartPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CartPage extends Page
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
      case "cart_mod":
	if( isset( $this->session['cart_mod']['remove'] ) )
	  {
	    $this->removeCartItems( $this->session['cart_mod']['carttable'] );
	  }
	elseif( isset( $this->session['cart_mod']['adddomain'] ) )
	  {
	    $this->goto( "adddomain" );
	  }
	elseif( isset( $this->session['cart_mod']['addhosting'] ) )
	  {
	    $this->goto( "addhosting" );
	  }
	break;

      case "cart_domains":
	if( isset( $this->session['cart_domains']['removedomain'] ) )
	  {
	    $this->removeExistingDomains( $this->session['cart_domains']['domaintable'] );
	  }
	break;

      case "cart_nav":
	if( isset( $this->session['cart_nav']['startover'] ) )
	  {
	    $this->newOrder();
	  }
	elseif( isset( $this->session['cart_nav']['checkout'] ) )
	  {
	    $this->goto( "customer" );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Init
   *
   * Initialize the Cart Page
   */
  function init()
  {
    if( !isset( $_SESSION['order'] ) )
      {
	$this->newOrder();
      }
    else
      {
	$this->smarty->assign( "recurring_total", 
			       $_SESSION['order']->getRecurringTotal() );
	$this->smarty->assign( "nonrecurring_total",
			       $_SESSION['order']->getNonRecurringTotal() );
	$this->smarty->assign( "cart_total", $_SESSION['order']->getSubTotal() );
	$this->smarty->assign( "show_existing_domains", 
			       $_SESSION['order']->getExistingDomains() != null );
      }
  }

  /**
   * Start New Order
   */
  function newOrder()
  {
    // Start a new order
    $_SESSION['order'] = new OrderDBO();
    $this->goto( "adddomain" );
  }

  /**
   * Populate the Cart Table
   *
   * @return array OrderItemDBO's
   */
  function populateCart()
  {
    // Return the order items
    return $_SESSION['order']->getItems();
  }

  /**
   * Populate the Domain Table
   */
  function populateDomainTable()
  {
    // Return the existing domain items
    return $_SESSION['order']->getExistingDomains();
  }

  /**
   * Remove Items from Cart
   *
   * @param array $orderitemids Array of Order Item IDs to be removed
   */
  function removeCartItems( $orderitemids = array() )
  {
    foreach( $orderitemids as $orderitemid )
      {
	$_SESSION['order']->removeItem( $orderitemid );
      }

    // Reload (to reset the display domains flag, if necessary )
    $this->goto( "cart" );
  }

  /**
   * Remove Existing Domains from Cart
   *
   * @param array $orderitemids Array of domain names to be removed
   */
  function removeExistingDomains( $orderitemids = array() )
  {
    foreach( $orderitemids as $orderitemid )
      {
	$_SESSION['order']->removeExistingDomain( $orderitemid );
      }

    // Reload (to reset the display domains flag, if necessary )
    $this->goto( "cart" );
  }

}

?>
