<?php
/**
 * AccountPage.class.php
 *
 * This file contains the definition for the AccountsPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/AccountDBO.class.php";

/**
 * AccountsPage
 *
 * The Accounts Page displays a summary of current customer accounts.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AccountsPage extends Page
{

  /**
   * Initialize Accounts Page
   *
   * Gather account stats from the database and assign them to template variables.
   */
  function init()
  {
    // Account Summary
    $active_accounts   = count_all_AccountDBO( "status='Active'" );
    $inactive_accounts = count_all_AccountDBO( "status='Inactive'" );
    $pending_accounts  = count_all_AccountDBO( "status='Pending'" );
    $total_accounts    = $active_accounts + $inactive_accounts;
    $this->smarty->assign( "active_accounts_count",   $active_accounts );
    $this->smarty->assign( "inactive_accounts_count", $inactive_accounts );
    $this->smarty->assign( "pending_accounts_count",  $pending_accounts );
    $this->smarty->assign( "total_accounts",          $total_accounts );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *  none
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      default:

	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>