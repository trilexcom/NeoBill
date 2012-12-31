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

require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ReviewPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ReviewPage extends SolidStatePage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch ( $action_name ) {
			case "review":
				if ( isset( $this->post['back'] ) ) {
					if ( $this->session['order']->getAccountID() != null &&
							$this->session['order']->getDomainItems() == null ) {
						$this->gotoPage( "cart" );
					}
					$this->gotoPage( "customer" );
				}
				elseif ( isset( $this->post['checkout'] ) ) {
					$this->checkout();
				}
				elseif ( isset( $this->post['startover'] ) ) {
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
	function checkout() {
		// The module must have been picked if this is not an existing customer
		if ( $this->session['order']->getAccountType() == "New Account" &&
				!isset( $this->post['module'] ) ) {
			throw new SWUserException( "[YOU_MUST_SELECT_PAYMENT]" );
		}

		// If required, make sure that the TOS box was checked
		if ( $this->conf['order']['tos_required'] && !isset( $this->post['accept_tos'] ) ) {
			throw new SWUserException( "[YOU_MUST_ACCEPT_THE_TERMS_OF_SERVICE]" );
		}

		$this->session['order']->setRemoteIP( ip2long( $_SERVER['REMOTE_ADDR'] ) );
		$this->session['order']->setDateCreated( DBConnection::format_datetime( time() ) );
		$this->session['order']->setAcceptedTOS( $this->post['accept_tos'] == "true" ? "Yes" : "No" );
		
		/*
		if ( $this->session['order']->getAccountType() == "Existing Account" ) {
			// Send existing accounts off to the receipt page
			$this->session['order']->complete();
			$this->gotoPage( "receipt" );
		}
		*/

		// Register the new user
		if ( $this->session['order']->getAccountType() == "New Account"){
			$order = $this->session['order'];
			$user_dbo = new UserDBO();

			// User-defined data
			$user_dbo->setUsername($order->getUsername());
			$user_dbo->setPassword($order->getPassword());
			$user_dbo->setContactName($order->getContactName());
			$user_dbo->setEmail($order->getContactEmail());
			
			// Admin-defined data
			$user_dbo->setType("Client");
			$user_dbo->setLanguage("english"); // could change to user-defined
			$user_dbo->setTheme("default");
			
			add_UserDBO( $user_dbo );

			// Add account info to accountDBO

			$account_dbo = new AccountDBO();
			$account_dbo->setStatus("Active");
			$account_dbo->setType("Individual Account");
			$account_dbo->setBillingStatus("Bill");
			$account_dbo->setBillingDay(1);
			$account_dbo->setBusinessName($order->getBusinessName());
			$account_dbo->setContactName($order->getContactName());
			$account_dbo->setContactEmail($order->getContactEmail());
			$account_dbo->setAddress1($order->getAddress1());
			$account_dbo->setAddress2($order->getAddress2());
			$account_dbo->setCity($order->getCity());
			$account_dbo->setState($order->getState());
			$account_dbo->setCountry($order->getCountry());
			$account_dbo->setPostalCode($order->getPostalCode());
			$account_dbo->setPhone($order->getPhone());
			$account_dbo->setMobilePhone($order->getMobilePhone());
			$account_dbo->setFax($order->getFax());
			$account_dbo->setUsername($order->getUsername());

			add_AccountDBO($account_dbo);
			
			$this->session['order']->setAccountID($account_dbo->getID());
			
		}
		
		// If the order does not have an ID already, save it to the database
		if ( $this->session['order']->getID() == null ) {			
			add_OrderDBO( $this->session['order'] );
		}

		if ( $this->session['review']['module'] == "Check" ) {
			// Record the promise to pay by check
			$checkPayment = new PaymentDBO();
			$checkPayment->setOrderID( $this->session['order']->getID() );
			$checkPayment->setAmount( $this->session['order']->getTotal() );
			$checkPayment->setStatus( "Pending" );
			$checkPayment->setDate( DBConnection::format_datetime( time() ) );
			$checkPayment->setType( "Check" );
			add_PaymentDBO( $checkPayment );

			// Goto the receipt page
			$this->session['order']->complete();
			$this->gotoPage( "receipt", null, "payByCheck=1" );
		}


		// Collect Payment
		$registry = ModuleRegistry::getModuleRegistry();
		$paymentModule = $registry->getModule( $this->post['module'] );
		$checkoutPage = $paymentModule->getType() == "payment_processor" ?
				$paymentModule->getOrderCheckoutPage() : "ccpayment";
		
		// Redirect to the module's checkout page
		$_SESSION['module'] = $paymentModule;
		$this->gotoPage( $checkoutPage );
	}

	/**
	 * Initialize Review Page
	 */
	function init() {
		// Give access to the template
		$this->session['order'] =& $_SESSION['order'];

		// Calculate tax on the order
		$this->session['order']->calculateTaxes();

		// Setup the cart table
		$cartWidget = $this->forms['review']->getField( "cart" )->getWidget();
		$cartWidget->setOrder( $_SESSION['order'] );

		// Provide the Terms of Service config to the template
		$this->smarty->assign( "tos_required", $this->conf['order']['tos_required'] );
		$this->smarty->assign( "tos_url", $this->conf['order']['tos_url'] );

		// Supress the login link
		$this->smarty->assign( "supressWelcome", true );
	}

	/**
	 * Start New Order
	 */
	function newOrder() {
		// Start a new order
		unset( $_SESSION['order'] );
		$this->gotoPage( "cart" );
	}
}
?>
