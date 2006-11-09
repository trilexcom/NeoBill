<?php
/**
 * InactiveAccountsPage.class.php
 *
 * This file contains the definition for the InactiveAccountsPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

// AccountDBO class
require_once BASE_PATH . "DBO/AccountDBO.class.php";

/**
 * InactiveAccountsPage
 *
 * Display the Inactive Accounts table.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InactiveAccountsPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *  browse_accounts_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "inactive_accounts_action":
	if( isset( $this->session['inactive_accounts_action']['add'] ) )
	  {
	    // Goto new account page
	    $this->goto( "accounts_new_account" );
	  }
	break;

      case "search_inactive_accounts":
	$this->searchTable( "inactive_accounts", "accounts", $this->post );
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize Inactive Accounts Page
   */
  public function init()
  {
    parent::init();

    // Tell the accounts table widget to only show "pending" accounts
    $widget = $this->forms['inactive_accounts']->getField( "accounts" )->getWidget();
    $widget->setStatus( "Inactive" );
  }
}

?>