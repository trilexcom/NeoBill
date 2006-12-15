<?php
/**
 * PendingAccountsPage.class.php
 *
 * This file contains the definition for the PendingAccountsPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * PendingAccountsPage
 *
 * Display the Pending Accounts table.  The user may search the table as well.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PendingAccountsPage extends SolidStatePage
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
      case "pending_accounts_action":
	if( isset( $this->session['pending_accounts_action']['add'] ) )
	  {
	    // Goto new account page
	    $this->goto( "accounts_new_account" );
	  }
	break;

      case "search_pending_accounts":
	$this->searchTable( "pending_accounts", "accounts", $this->post );
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize Pending Accounts Page
   */
  public function init()
  {
    parent::init();

    // Tell the accounts table widget to only show "pending" accounts
    $widget = $this->forms['pending_accounts']->getField( "accounts" )->getWidget();
    $widget->setStatus( "Pending" );
  }
}
?>