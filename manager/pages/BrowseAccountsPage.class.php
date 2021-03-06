<?php
/**
 * BrowseAccountsPage.class.php
 *
 * This file contains the definition for the Browse Accounts Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * BrowseAccountsPage
 *
 * Display all active accounts.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class BrowseAccountsPage extends SolidStatePage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *   browse_accounts_action (form)
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch( $action_name ) {
			case "browse_accounts_action":
				if( isset( $this->session['browse_accounts_action']['add'] ) ) {
					// Goto new account page
					$this->gotoPage( "accounts_new_account" );
				}
				break;

			case "search_accounts":
				$this->searchTable( "active_accounts", "accounts", $this->post );
				break;

			default:
				// No matching action, refer to base class
				parent::action( $action_name );
		}
	}

	/**
	 * Initialize Browse Accounts Page
	 */
	public function init() {
		parent::init();

		// Tell the accounts table widget to only show "active" accounts
		$widget = $this->forms['active_accounts']->getField( "accounts" )->getWidget();
		$widget->setStatus( "Active" );
	}
}
?>
