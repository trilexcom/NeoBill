<?php
/**
 * CustomerLoginPage.class.php
 *
 * This file contains the definition of the CustomerLoginPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "include/SolidStatePage.class.php";
require_once BASE_PATH . "DBO/UserDBO.class.php";

/**
 * CustomerLoginPage
 *
 * Handles user authentication
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CustomerLoginPage extends SolidStatePage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *   login (form)
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch( $action_name ) {
			case "login":
				if( isset( $this->post['login'] ) ) {
					$this->login();
				}
				elseif( isset( $this->post['back'] ) ) {
					$this->goback();
				}
				break;

			default:
				// No matching action, refer to base class
				parent::action( $action_name );
		}
	}

	/**
	 * Initialize the Page
	 */
	function init() {
		// Suppress the login link
		$this->smarty->assign( "username", " " );
	}

	/**
	 * Login Customer
	 */
	function login() {
		if ( $this->post['user']->getPassword() == $this->post['password'] ) {
			// Only customers are allowed to login to the order form
			if ( $this->post['user']->getType() != "Client" ) {
				$this->setError( array( "type" => "ONLY_CUSTOMERS_CAN_LOGIN" ) );
				return;
			}

			// Login success
			$_SESSION['client']['userdbo'] = $this->post['user'];
			log_notice( "CustomerLoginPage::login()",
					"User: " . $this->post['user']->getUsername() . " logged in." );
			$this->gotoPage( "cart" );
		}

		// Login failure
		log_security( "CustomerLoginPage::login()", "Login failed." );
		$this->setError( array( "type" => "LOGIN_FAILED" ) );
	}
}
?>