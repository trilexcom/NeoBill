<?php
/**
 * ServersPage.class.php
 *
 * This file contains the definition for the ServersPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/ServerDBO.class.php";

/**
 * ServersPage
 *
 * Server Management page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServersPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "servers_action":
	if( isset( $this->post['add'] ) )
	  {
	    $this->goto( "services_add_server" );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}
?>