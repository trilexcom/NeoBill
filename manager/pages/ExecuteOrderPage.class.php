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
require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ExecuteOrderPage
 *
 * Display an order.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ExecuteOrderPage extends SolidStatePage {
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
	function action( $action_name ) {
		switch ( $action_name ) {
			case "execute_order":
				if ( isset( $this->session['execute_order']['cancel'] ) ) {
					$this->cancel();
				}
				elseif ( isset( $this->session['execute_order']['continue'] ) ) {
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
	function cancel() {
		$this->goback();
	}

	/**
	 * Execute the Order
	 */
	function execute() {
		// Execute the order
		switch( $this->get['order']->getAccountType() ) {
			case "New Account":
				if ( !$this->get['order']->executeNewAccount( $this->post['type'],
						$this->post['status'],
						$this->post['billingstatus'],
						$this->post['billingday'] ) ) {
					throw new SWException( "Failed to execute Order.  ID=" .
							$this->get['order']->getID() );
				}
				break;

			case "Existing Account":
				if ( !$this->get['order']->execute() ) {
					throw new SWException( "Failed to execute Order.  ID=" .
							$this->get['order']->getID() );
				}
				break;

			default:
				throw new SWException( "Failed to execute order: invalid account type." );
		}

		// Jump to the view account page
		$this->gotoPage( "accounts_view_account",
				null,
				sprintf( "account=%d", $this->get['order']->getAccountID() ) );
	}

	/**
	 * Initialize the Execute Order Page
	 */
	function init() {
		parent::init();

		// Set URL Fields
		$this->setURLField( "order", $this->get['order']->getID() );

		// Give the template access to the Order DBO
		$this->session['orderdbo'] =& $this->get['order'];

		// Set Nav vars
		$this->setNavVar( "order_id", $this->get['order']->getID() );

		// Setup the Order Items table
		$oiField = $this->forms['execute_order']->getField( "items" );
		$oiField->getWidget()->setOrder( $this->get['order'] );
		$oiField->getWidget()->showAcceptedItemsOnly();
		$oiField->getValidator()->setOrder( $this->get['order'] );

		// Go ahead and execute if this is an existing customer
		if ( $this->get['order']->getAccountType() == "Existing Account" ) {
			$this->execute();
		}
	}
}
?>