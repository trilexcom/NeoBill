<?php
/**
 * HomePage.class.php
 *
 * This file contains the definition for the HomePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

require BASE_PATH . "util/billing.php";

/**
 * HomePage
 *
 * Display a billing and accounts summary.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HomePage extends SolidStatePage
{
  /**
   * Initialize the Home Page
   *
   * Gather billing stats and account stats from the database, then assign those
   * stats to template variables.
   */
  function init()
  {
    parent::init();

    // Current month
    $now = getDate( time() );
    $this->smarty->assign( "month", $now['month'] );

    // Invoice Summary
    $stats = outstanding_invoices_stats();
    $this->smarty->assign( "os_invoices_count",             $stats['count'] );
    $this->smarty->assign( "os_invoices_total",             $stats['total'] );
    $this->smarty->assign( "os_invoices_count_past_due",    $stats['count_past_due'] );
    $this->smarty->assign( "os_invoices_total_past_due",    $stats['total_past_due'] );
    $this->smarty->assign( "os_invoices_count_past_due_30", $stats['count_past_due_30'] );
    $this->smarty->assign( "os_invoices_total_past_due_30", $stats['total_past_due_30'] );

    // Payment Summary
    $stats = payments_stats();
    $this->smarty->assign( "payments_count", $stats['count'] );
    $this->smarty->assign( "payments_total", $stats['total'] );

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
   *   logout
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "logout":

	// Logout
	log_notice( "Logout", 
		    "User: " . $_SESSION['client']['userdbo']->getUsername() . " logged out" );
	session_destroy();
	$this->goto( "home" );

	break;
	

      default:

	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>