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
require_once $base_path . "solidworks/AdminPage.class.php";

// Include UserDBO
require_once $base_path . "DBO/UserDBO.class.php";

/**
 * ConfigureEditUserPage
 *
 * Edit a Solid-State User
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ConfigureEditUserPage extends AdminPage
{
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

    if( $_SESSION['client']['userdbo']->getType() == "Administrator" )
      {
	// Allow access to Administrator's
	return true;
      }

    if( isset( $this->session['edit_user_dbo'] ) && 
	$this->session['edit_user_dbo']->getUsername() == 
	$_SESSION['client']['userdbo']->getUsername() )
      {
	// Allow the client access to his own data
	return true;
      }

    // Deny access
    return false;
  }

  /**
   * Initialize Edit User Page
   */
  function init()
  {
    // Load UserDBO
    $username = isset( $_GET['my_info'] ) ? 
      $_SESSION['client']['userdbo']->getUsername() : 
      form_field_filter( null, $_GET['username'] );

    if( isset( $this->session['edit_user_dbo'] ) && !isset( $_GET['username'] ) )
      {
	// User already loaded
	return;
      }

    // Retrieve the user from the database
    $userdbo = load_userDBO( $username );

    if( !isset( $userdbo ) )
      {
	// Could not find username
	$this->setError( array( "type" => "DB_USER_NOT_FOUND",
				"args" => array( $username ) ) );
      }
    else
      {
	// Store user DBO in session so it can be displayed in the edit form
	$this->session['edit_user_dbo'] = $userdbo;
      }
  }

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

	if( isset( $this->session['delete_user_confirm']['continue'] ) )
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
   * Delete User
   *
   * Remove UserDBO from database
   */
  function delete_user()
  {
    $user_dbo = $this->session['edit_user_dbo'];
    if( !isset( $user_dbo ) )
      {
	// Missing a UserDBO to delete!
	fatal_error( "ConfigureEditUserPage::delete_user()",
		     "User to delete is not loaded" );
      }

    // Remove DBO from the database
    if( !delete_UserDBO( $user_dbo ) )
      {
	// Failed to delete user
	$this->setError( array( "type" => "DB_USER_DELETE_FAILED",
				"args" => array( $user_dbo->getUsername() ) ) );
	return;
      }

    // Show receipt
    // $this->setTemplate( "del_receipt" );

    // Jump to 'Users' page, pass confirmation message
    $this->goto( 'config_users', array( array( "type" => "USER_DELETED",
					       "args" => array( $user_dbo->getUsername() ) ) ) );
  }

  /**
   * Confirm Delete User
   *
   * Prompt the client to confirm the User removal
   */
  function confirm_delete_user()
  {
    $user_dbo = $this->session['edit_user_dbo'];
    if( !isset( $user_dbo ) )
      {
	// Missing a UserDBO to delete!
	fatal_error( "ConfigureEditUserPage::confirm_delete_user()",
		     "User to delete is not loaded" );
      }

    if( $_SESSION['client']['userdbo']->getUsername() == $user_dbo->getUsername() )
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
    // Pull form data from the session
    $user_data = $this->session['edit_user'];

    if( !isset( $user_data ) )
      {
	// Missing form data
	fatal_error( "ConfigureEditUserPage::update_user()",
		     "no form data received!" );
      }

    // Access UserDBO being edited
    $user_dbo =& $this->session['edit_user_dbo'];

    if( $_SESSION['client']['userdbo']->getUsername() == $user_dbo->getUsername() &&
	$user_data['type'] != $user_dbo->getType() )
      {
	// Client can not change his own user type
	$this->session['edit_user']['type'] = $user_dbo->getType();
	$this->setError( array( "type" => "USER_TYPE_CHANGE", 
				"field_name" => "type" ) );

	return;
      }

    // Load form contents into DBO
    $user_dbo->setFirstName( $user_data['firstname'] );
    $user_dbo->setLastName( $user_data['lastname'] );
    $user_dbo->setEmail( $user_data['email'] );
    $user_dbo->setType( $user_data['type'] );

    // Commit changes
    if( !update_UserDBO( $user_dbo ) )
      {
	// DB update failed
	$this->setError( array( "type" => "DB_USER_UPDATE_FAILED",
				"args" => array( $user_dbo->getUsername() ) ) );
      }

    // Success - Display message
    $this->setMessage( array( "type" => "USER_UPDATED", 
			      "args" => array( $user_dbo->getUsername() ) ) );
  }

  /**
   * Update User's Password
   */
  function update_password()
  {
    // Pull form data from the session
    $user_data = $this->session['edit_user_pass'];

    if( !isset( $user_data ) )
      {
	// Missing form data
	fatal_error( "ConfigureEditUserPage::update_password()",
		     "Error: no form data received!" );
      }

    $user_dbo =& $this->session['edit_user_dbo'];

    if( !isset( $user_data['password'] ) || 
	$user_data['password'] != $user_data['repassword'] )
      {
	// Password not entered correctly
	$this->setError( array( "type"       => "PASSWORD_MISMATCH",
				"field_name" => "password" ) );

	// Redisplay form
	return;
      }

    // Set new password
    $user_dbo->setPassword( $user_data['password'] );

    // Commit changes
    if( !update_UserDBO( $user_dbo ) )
      {
	// DB update failed
	echo "Update failed";
      }

    // Display message
    $this->setMessage( array( "type" => "USER_PASS_UPDATED", 
			      "args" => array( $user_dbo->getUsername() ) ) );
  }
}

?>