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
require_once $base_path . "solidworks/Page.class.php";

// AccountDBO class
require_once $base_path . "DBO/AccountDBO.class.php";

/**
 * PendingAccountsPage
 *
 * Display the Pending Accounts table.  The user may search the table as well.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PendingAccountsPage extends Page
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

      case "browse_accounts_action":

	if( isset( $this->session['browse_accounts_action']['add'] ) )
	  {
	    // Goto new account page
	    $this->goto( "accounts_new_account" );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>