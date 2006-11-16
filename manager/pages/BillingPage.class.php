<?php
/**
 * BillingPage.php.class
 *
 * This file contains the definition for the BillingPage class
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
 * BillingPage
 *
 * Display a summary of invoices and payments
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class BillingPage extends SolidStatePage
{

  /**
   * Initialize Billing Page
   *
   * Gather billing statistics from the database and assign them to template variables
   */
  function init()
  {
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
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   none
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