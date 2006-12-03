<?php
/**
 * ConfigureEditUserPage.class.php
 *
 * This file contains the definition for the ConfigureEditUserPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

// Include UserDBO
require_once BASE_PATH . "DBO/UserDBO.class.php";

/**
 * ConfigureEditUserPage
 *
 * Edit a Solid-State User
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ConfigureEditUserPage extends SolidStateAdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_user (form)
   *   edit_user_pass (form)
   *   edit_user_action (form)
   *   delete (form)
   *   delete_user_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_user":
	// Update user information
	$this->update_user();
	break;

      case "edit_user_pass":
	// Update user's password
	$this->update_password();
	break;

      case "edit_user_action":
      case "delete":
	// Confirm this user's removal
	$this->confirm_delete_user();
	break;

      case "delete_user_confirm":
	if( isset( $this->post['continue'] ) )
	  {
	    // Delete the user
	    $this->delete_user();
	  }
	else
	  {
	    // Go back
	    $this->goback();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize Edit User Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "user", $this->get['user']->getUsername() );

    // Store user DBO in session so it can be displayed in the edit form
    $this->session['edit_user_dbo'] =& $this->get['user'];
  }

  /**
   * Control Page Access
   *
   * This page is limited to either an Administrator or the user whose account
   * is being edited.
   *
   * @return boolean True if access is granted
   */
  function control_access()
  {
    // Allow the user currently logged in to edit his own info, but no
    // other Account Manager's
    return ($_SESSION['client']['userdbo']->getType() == "Administrator") ||
      ($this->get['user'] == $_SESSION['client']['userdbo']->getUsername());
  }

  /**
   * Delete User
   *
   * Remove UserDBO from database
   */
  function delete_user()
  {
    // Remove DBO from the database
    if( !delete_UserDBO( $this->get['user'] ) )
      {
	// Failed to delete user
	$this->setError( array( "type" => "DB_USER_DELETE_FAILED",
				"args" => array( $user_dbo->getUsername() ) ) );
	return;
      }

    // Jump to 'Users' page, pass confirmation message
    $this->setMessage( array( "type" => "[USER_DELETED]" ) );
    $this->goto( 'config_users' );
  }

  /**
   * Confirm Delete User
   *
   * Prompt the client to confirm the User removal
   */
  function confirm_delete_user()
  {
    if( $_SESSION['client']['userdbo']->getUsername() == 
	$this->get['user']->getUsername() )
      {
	// Can not delete self
	$this->setError( array( "type" => "USER_SELF_DELETE" ) );
	return;
      }

    // Ask the user to confirm the delete
    $this->setTemplate( "del_confirm" );
  }

  /**
   * Update User
   */
  function update_user()
  {
    if( ($_SESSION['client']['userdbo']->getUsername() == 
	 $this->get['user']->getUsername()) &&
	$this->post['type'] != $this->get['user']->getType() )
      {
	// Client can not change his own user type
	$this->session['edit_user']['type'] = $this->get['user']->getType();
	$this->setError( array( "type" => "USER_TYPE_CHANGE", 
				"field_name" => "type" ) );

	return;
      }

    // Load form contents into DBO
    $this->get['user']->setContactName( $this->post['contactname'] );
    $this->get['user']->setEmail( $this->post['email'] );
    $this->get['user']->setType( $this->post['type'] );
    $this->get['user']->setLanguage( $this->post['language'] );

    // Commit changes
    if( !update_UserDBO( $this->get['user'] ) )
      {
	// DB update failed
	$this->setError( array( "type" => "DB_USER_UPDATE_FAILED",
				"args" => array( $this->get['user']->getUsername() ) ) );
	return;
      }

    // Success - Display message
    $this->setMessage( array( "type" => "USER_UPDATED", 
			      "args" => array( $this->get['user']->getUsername() ) ) );

    // Load language preference
    $_SESSION['client']['userdbo'] = $this->get['user'];
    $this->conf['locale']['language'] = $this->get['user']->getLanguage();
    $_SESSION['jsFunction'] = "reloadMenu()";
    $this->goto( "config_edit_user", null, "user=" . $this->get['user']->getUsername() );
  }

  /**
   * Update User's Password
   */
  function update_password()
  {
    if( !isset( $this->post['password'] ) || 
	$this->post['password'] != $this->post['repassword'] )
      {
	// Password not entered correctly
	$this->setError( array( "type"       => "PASSWORD_MISMATCH",
				"field_name" => "password" ) );

	// Redisplay form
	return;
      }

    // Set new password
    $this->get['user']->setPassword( $this->post['password'] );

    // Commit changes
    if( !update_UserDBO( $this->get['user'] ) )
      {
	// DB update failed
	throw new SWException( "Failed to update User record" );
      }

    // Display message
    $this->setMessage( array( "type" => "USER_PASS_UPDATED", 
			      "args" => array( $this->get['user']->getUsername() ) ) );
  }
}
?>