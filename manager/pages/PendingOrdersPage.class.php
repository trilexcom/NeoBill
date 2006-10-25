<?php
/**
 * PendingOrdersPage.class.php
 *
 * This file contains the definition for the Pending Orders Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

// OrderDBO class
require_once BASE_PATH . "DBO/OrderDBO.class.php";

/**
 * PendingOrdersPage
 *
 * Display all pending orders.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PendingOrdersPage extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   browse_accounts_action (form)
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