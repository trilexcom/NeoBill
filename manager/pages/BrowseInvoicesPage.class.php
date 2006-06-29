<?php
/**
 * BrowseInvoicesPage.class.php
 *
 * This file contains the definition for the Browse Invoices Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// InvoiceDBO class
require_once $base_path . "DBO/InvoiceDBO.class.php";

/**
 * BrowseInvoicesPage
 *
 * Display all Invoices
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class BrowseInvoicesPage extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   browse_invoices_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "browse_invoices_action":
	// Create a new invoice
	$this->goto( "accounts_add_invoice" );
	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>