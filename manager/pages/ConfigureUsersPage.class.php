<?php
/**
 * ConfigureUsersPage.class.php
 *
 * This file contains the definition for the ConfigureUsersPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * ConfigureUsersPage
 *
 * Display all Solid-State users (restricted to Administrator's only)
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ConfigureUsersPage extends AdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   users_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "users_action":

	if( isset( $this->session['users_action']['add'] ) )
	  {
	    // Goto new user page
	    $this->goto( "config_new_user" );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>
