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
require_once $base_path . "solidworks/Page.class.php";

// InvoiceDBO class
require_once $base_path . "DBO/InvoiceDBO.class.php";

/**
 * OutstandingInvoicesPage
 *
 * Display a table of outstanding invoices.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OutstandingInvoicesPage extends Page
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

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>