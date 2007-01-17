<?php
/**
 * AddOnPage.class.php
 *
 * This file contains the definition for the AddOn Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * AddOnPage
 *
 * Display a list of Add-Ons being offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddOnPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   addon_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
  }
}
?>