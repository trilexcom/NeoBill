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
require_once BASE_PATH . "solidworks/Page.class.php";

// Order DBO
require_once BASE_PATH . "DBO/OrderDBO.class.php";

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
    // Make sure we have things to sell
    if( (load_array_DomainServiceDBO() == null) &&
	(load_array_HostingServiceDBO() == null) )
      {
	fatal_error( "CartPage::init()", 
		     "There are no services configured.  The HSP must configure some services before the order interface can be used" );
      }

    // Make sure we have a way to collect payment
    $paymentMethods = 0;
    foreach( $this->conf['modules'] as $moduleDBO )
      {
	if( (is_a( $moduleDBO, "PaymentProcessorModule" ) ||
	     is_a( $moduleDBO, "PaymentGatewayModule" )) &&
	    $moduleDBO->isEnabled() )
	  {
	    $paymentMethods++;
	  }
      }
    if( $this->conf['order']['accept_checks'] )
      {
	$paymentMethods++;
      }
    if( $paymentMethods == 0 && !$this->conf['order']['accept_checks'] )
      {
	fatal_error( "CartPage::init()",
		     "No payment methods have been enabled.  The HSP must enable at least one payment method before the order interface can be used" );
      }

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