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
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * CartPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CartPage extends SolidStatePage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch( $action_name ) {
			case "cart_mod":
				if ( isset( $this->post['remove'] ) ) {
					$this->removeCartItems( $this->post['cart'] );
				}
				elseif ( isset( $this->post['addhosting'] ) ) {
					$this->gotoPage( "purchasehosting" );
				}
				elseif ( isset( $this->post['adddomain'] ) ) {
					$this->gotoPage( "purchasedomain" );
				}
				break;

			case "cart_nav":
				if ( isset( $this->post['startover'] ) ) {
					$this->newOrder();
				}
				elseif ( isset( $this->post['checkout'] ) ) {
					$this->gotoPage( "customer" );
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
	function init() {
		// Make sure we have things to sell
		$stuffToSell = false;
		try {
			load_array_DomainServiceDBO();
			$stuffToSell = true;
		}
		catch( DBNoRowsFoundException $e ) {

		}

		try {
			load_array_HostingServiceDBO();
			$stuffToSell = true;
		}
		catch( DBNoRowsFoundException $E ) {

		}

		if( !$stuffToSell ) {
			throw new SWUserException( "No hosting or domain services have been configured.  The HSP must configure hosting and/or domain services before using the Order wizard" );
		}

		// Make sure we have a way to collect payment
		$registry = ModuleRegistry::getModuleRegistry();
		$paymentModules =
				array_merge( $registry->getModulesByType( "payment_processor", true ),
				$registry->getModulesByType( "payment_gateway", true ) );
		$paymentMethods = count( $paymentModules );
		if ( $this->conf['order']['accept_checks'] ) {
			$paymentMethods++;
		}
		if ( $paymentMethods == 0 ) {
			throw new SWUserException( "No payment methods have been enabled.  The HSP must enable at least one payment method before the order interface can be used" );
		}

		// Make sure that an order has been started
		if ( !isset( $_SESSION['order'] ) ) {
			$this->newOrder();
		}
		else {
			// Setup the cart table
			$cField = $this->forms['cart_mod']->getField( "cart" );
			$cField->getWidget()->setOrder( $_SESSION['order'] );
			$cField->getValidator()->setOrder( $_SESSION['order'] );

			$this->smarty->assign( "recurring_total",
					$_SESSION['order']->getRecurringTotal() );
			$this->smarty->assign( "nonrecurring_total",
					$_SESSION['order']->getNonRecurringTotal() );
			$this->smarty->assign( "cart_total", $_SESSION['order']->getSubTotal() );
		}
	}

	/**
	 * Start New Order
	 */
	function newOrder() {
		// Start a new order
		$_SESSION['order'] = new OrderDBO();
		$this->gotoPage( "purchasehosting" );
	}

	/**
	 * Remove Items from Cart
	 *
	 * @param array $orderitemids Array of Order Item IDs to be removed
	 */
	function removeCartItems( $orderitems = array() ) {
		foreach ( $orderitems as $orderitemdbo ) {
			$_SESSION['order']->removeItem( $orderitemdbo->getOrderItemID() );
		}

		// Reload (to reset the display domains flag, if necessary )
		$this->reload();
	}
}
?>