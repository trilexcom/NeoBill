<?php
/**
 * ConfigureNewUserPage.class.php
 *
 * This file contains the definition for the ConfigureNewUserPage class
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
 * ConfigureNewUserPage
 *
 * Add a new Solid-State user
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ConfigureNewUserPage extends AdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   new_user_action (form)
   *   new_user (form)
   *   new_user_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    
    switch( $action_name )
      {
	
      case "new_user_action":

	if( isset( $this->session['new_user_action']['add'] ) )
	  {
	    $this->goto( "config_new_user" );
	  }
	elseif( isset( $this->session['new_user_action']['view'] ) )
	  {
	    $this->goto( "config_users" );
	  }

	break;

      case "new_user":

	// Client submited a new_user form - process it
	$this->process_new_user();

	break;

      case "new_user_confirm":

	if( isset( $this->session['new_user_confirm']['continue'] ) )
	  {
	    // Go ahead
	    $this->add_user();
	  }
	else
	  {
	    // Go back
	    $this->setTemplate( "default" );
	  }

	break;
	
      default:

	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Process New User
   *
   * Verify the username requested does not already exist, then
   * ask the client to confirm the new User.
   */
  function process_new_user()
  {
    // Pull form data from the session
    $user_data = $this->session['new_user'];

    if( !isset( $user_data ) )
      {
	// Missing form data
	fatal_error( "ConfigureNewUserPage::process_new_user()",
		     "no form data received!" );
      }

    if( $user_data['password'] != $user_data['repassword'] )
      {
	// Password not entered correctly
	$this->setError( array( "type"       => "PASSWORD_MISMATCH",
				"field_name" => "password" ) );

	// Destroy the password values so they're not echoed to the form
	unset( $this->session['new_user']['password'] );
	unset( $this->session['new_user']['repassword'] );

	// Redisplay form
	return;
      }

    // Verify this username does not already exist
    if( load_UserDBO( $user_data['username'] ) != null )
      {
	// Username already exists
	$this->setError( array( "type"       => "DB_USER_EXISTS", 
				"field_name" => "username",
				"args"       => array( $user_data['username'] ) ) );

	// Redisplay form
	return;
      }

    // Prepare UserDBO for database insertion
    $user_dbo = new UserDBO();
    $user_dbo->load( $user_data );
    $user_dbo->setPassword( $user_data['password'] );

    // Place DBO in the session for the confirm & receipt page
    $this->session['new_user_dbo'] = $user_dbo;

    // Ask client to confirm
    $this->setTemplate( "confirm" );
  }

  /**
   * Add User
   *
   * Create a new UserDBO and add it to the database
   */
  function add_user()
  {
    // Extract UserDBO from session
    $user_dbo = $this->session['new_user_dbo'];

    if( !isset( $user_dbo ) )
      {
	// UserDBO is not in the session!
	fatal_error( "ConfigureNewUserPage::add_user()",
		     "UserDBO not found!" );
      }

    // Insert UserDBO into database
    if( !add_UserDBO( $user_dbo ) )
      {
	// Unable to add user
	echo mysql_error();
	$this->setError( array( "type" => "DB_USER_ADD_FAILED",
				"args" => array( $user_dbo->getUsername() ) ) );

	// Return to form
	$this->setTemplate( "default" );
      }
    else
      {
	// User added
	// Clear new_user data from the session
	unset( $this->session['new_user'] );

	// Show receipt
	$this->setTemplate( "receipt" );
      }
  }

  /**
   * Populate the Language Preference Box
   *
   * @return array An array of languages
   */
  function populateLanguage()
  {
    global $translations;

    $langauges = array();
    foreach( $translations as $language => $phrases )
      {
	if( is_array( $phrases ) )
	  {
	    $languages[$language] = $language;
	  }
      }

    return $languages;
  }
}

?>