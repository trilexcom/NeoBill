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
require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ViewOrderPage
 *
 * Display an order.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewOrderPage extends SolidStatePage {
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
			case "order":
				if ( isset( $this->post['execute'] ) ) {
					$this->execute();
				}
				elseif ( isset( $this->post['save'] ) ) {
					$this->save();
				}
				elseif ( isset( $this->post['delete'] ) ) {
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
	function delete() {
		delete_OrderDBO( $this->get['order'] );

		// Success
		$this->setMessage( array( "type" => "[ORDER_DELETED]",
				"args" => array( $this->get['order']->getID() ) ) );
		$this->gotoPage( "pending_orders" );
	}

	/**
	 * Execute Order
	 */
	function execute() {
		// Save any changes made to the order
		$this->saveChanges();

		// Redirect to the execute order page
		$this->gotoPage( "execute_order", null, sprintf( "order=%d",
				$this->get['order']->getID() ) );
	}

	/**
	 * Initialize the View Order Page
	 */
	function init() {
		parent::init();

		// Set URL Fields
		$this->setURLField( "order", $this->get['order']->getID() );

		// Give the template access to the Order DBO
		$this->session['orderdbo'] =& $this->get['order'];

		// Setup the Order Items table
		$oiField = $this->forms['order']->getField( "items" );
		$oiField->getWidget()->setOrder( $this->get['order'] );
		$oiField->getValidator()->setOrder( $this->get['order'] );

		// Setup the payment table
		$payField = $this->forms['order']->getField( "payments" );
		$payField->getWidget()->setOrderID( $this->get['order']->getID() );

		// If this is an existing account order, make sure the template has access
		// to the account DBO
		if ( $this->get['order']->getAccountType() == "Existing Account" ) {
			$this->session['accountdbo'] = $this->get['order']->getAccount();
		}

		// Set Nav vars
		$this->setNavVar( "order_id", $this->get['order']->getID() );
	}

	/**
	 * Populate the Order Item's Table
	 *
	 * @return array An array of all OrderItemDBO's for this Order
	 */
	function populateItemTable() {
		return $this->get['order']->getItems();
	}

	/**
	 * Populate the Order Payment Table
	 *
	 * @return array An array of all PaymentDBO's for this Order
	 */
	function populatePaymentTable() {
		return $this->get['order']->getPayments();
	}

	/**
	 * Save Order
	 */
	function save() {
		$this->saveChanges();
		$this->setMessage( array( "type" => "[ORDER_SAVED]" ) );
	}

	/**
	 * Save Changes
	 *
	 * Write any changes made to the order to the database
	 *
	 * @return boolean True for success
	 */
	function saveChanges() {
		if ( $this->get['order']->getAccountType() == "New Account" ) {
			if ( !isset( $this->post['username'] ) ) {
				throw new FieldMissingException( "username" );
			}

			try {
				load_UserDBO( $this->post['username'] );
				throw new SWUserException( "[DB_USER_EXISTS]" );
			}
			catch ( DBNoRowsFoundException $e ) {

			}

			$this->get['order']->setUsername( $this->post['username'] );
			if ( isset( $this->post['password'] ) ) {
				$this->get['order']->setPassword( $this->post['password'] );
			}
		}

		// Update OrderDBO
		$this->get['order']->setContactName( $this->post['contactname'] );
		$this->get['order']->setContactEmail( $this->post['contactemail'] );
		$this->get['order']->setAddress1( $this->post['address1'] );
		$this->get['order']->setAddress2( $this->post['address2'] );
		$this->get['order']->setCity( $this->post['city'] );
		$this->get['order']->setState( $this->post['state'] );
		$this->get['order']->setCountry( $this->post['country'] );
		$this->get['order']->setPostalCode( $this->post['postalcode'] );
		$this->get['order']->setPhone( $this->post['phone'] );
		$this->get['order']->setMobilePhone( $this->post['mobilephone'] );
		$this->get['order']->setFax( $this->post['fax'] );

		$acceptedItems = is_array( $this->post['items'] ) ?
				$this->post['items'] : array();
		foreach ( $this->get['order']->getItems() as $itemDBO ) {
			if ( in_array( $itemDBO, $acceptedItems ) ) {
				$this->get['order']->acceptItem( $itemDBO->getOrderItemID() );
			}
			else {
				$this->get['order']->rejectItem( $itemDBO->getOrderItemID() );
			}
		}

		// Save changes to database
		update_OrderDBO( $this->get['order'] );
	}
}
?>