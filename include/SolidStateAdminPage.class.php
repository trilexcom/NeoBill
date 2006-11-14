<?php
/**
 * AdminPage.class.php
 *
 * This file contains the definition for the AdminPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * AdminPage
 *
 * Provides a base for Pages that restrict access to user's with "Administrator"
 * privileges.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SolidStateAdminPage extends SolidStatePage
{
  /**
   * Control Access
   *
   * Determine if the user has Administrator status.
   *
   * @return boolean True if access is granted, false otherwise
   */
  function control_access()
  {
    if( $_SESSION['client']['userdbo']->getType() != "Administrator" )
      {
	// Not an administrator
	return false;
      }

    // Is an administrator
    return true;
  }
}