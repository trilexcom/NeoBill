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
require_once BASE_PATH . "include/SolidStatePage.class.php";

// Order DBO
require_once BASE_PATH . "DBO/OrderDBO.class.php";

/**
 * CartPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CartPage extends SolidStatePage
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
	if( isset( $this->post['remove'] ) )
	  {
	    $this->removeCartItems( $this->post['cart'] );
	  }
	elseif( isset( $this->post['adddomain'] ) )
	  {
	    $this->goto( "adddomain" );
	  }
	elseif( isset( $this->post['addhosting'] ) )
	  {
	    $this->goto( "addhosting" );
	  }
	break;

      case "cart_domains":
	if( isset( $this->post['removedomain'] ) )
	  {
	    $this->removeExistingDomains( $this->post['domaintable'] );
	  }
	break;

      case "cart_nav":
	if( isset( $this->post['startover'] ) )
	  {
	    $this->newOrder();
	  }
	elseif( isset( $this->post['checkout'] ) )
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
    if( (load_array_DomainServiceDBO() == null) && (load_array_HostingServiceDBO() == null) )
      {
	throw new SWException( "There are no services configured.  The HSP must configure some services before the order interface can be used" );
      }

    // Make sure we have a way to collect payment
    $registry = ModuleRegistry::getModuleRegistry(); 
    $paymentModules = 
      array_merge( $registry->getModulesByType( "payment_processor", true ),
		   $registry->getModulesByType( "payment_gateway", true ) );
    $paymentMethods = count( $paymentModules );
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
	// Setup the cart table
	$cField = $this->forms['cart_mod']->getField( "cart" );
	$cField->getWidget()->setOrder( $_SESSION['order'] );
	$cField->getValidator()->setOrder( $_SESSION['order'] );

	// Setup the existing domains table
	$dField = $this->forms['cart_domains']->getField( "domaintable" );
	$dField->getWidget()->setOrder( $_SESSION['order'] );
	$dField->getWidget()->showExistingDomains();
	$dField->getValidator()->setOrder( $_SESSION['order'] );

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
   * Remove Items from Cart
   *
   * @param array $orderitemids Array of Order Item IDs to be removed
   */
  function removeCartItems( $orderitems = array() )
  {
    foreach( $orderitems as $orderitemdbo )
      {
	$_SESSION['order']->removeItem( $orderitemdbo->getOrderItemID() );
      }

    // Reload (to reset the display domains flag, if necessary )
    $this->goto( "cart" );
  }

  /**
   * Remove Existing Domains from Cart
   *
   * @param array $orderitemids Array of domain names to be removed
   */
  function removeExistingDomains( $orderitems = array() )
  {
    foreach( $orderitems as $orderitemdbo )
      {
	$_SESSION['order']->removeExistingDomain( $orderitemdbo->getOrderItemID() );
      }

    // Reload (to reset the display domains flag, if necessary )
    $this->goto( "cart" );
  }

}
?>