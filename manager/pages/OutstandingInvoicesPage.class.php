<?php
/**
 * OutstandingInvoicesPage.class.php
 *
 * This file contains the definition for the Outstanding Invoices Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

// InvoiceDBO class
require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * OutstandingInvoicesPage
 *
 * Display a table of outstanding invoices.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OutstandingInvoicesPage extends SolidStatePage
{
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
      case "outstanding_invoices_action":
	// Create a new invoice
	$this->goto( "accounts_add_invoice" );
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize Outstanding Invoices Page
   */
  public function init()
  {
    parent::init();

    // Tell the orders table widget to only show "pending" orders
    $widget = $this->forms['outstanding_invoices']->getField( "invoices" )->getWidget();
    $widget->setOutstanding( "Yes" );
  }
}
?>