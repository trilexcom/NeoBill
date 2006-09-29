<?php
/**
 * LoginPage.class.php
 *
 * This file contains the definition of the LoginPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "solidworks/Page.class.php";

require_once BASE_PATH . "DBO/UserDBO.class.php";

/**
 * LoginPage
 *
 * Handles user authentication
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LoginPage extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   login (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "login":
	$this->login();
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Login
   *
   * Validate the login.  Store the UserDBO in the session if OK, or display an error
   * if the login failed.
   */
  function login()
  {
    $user_dbo = load_UserDBO( $this->session['login']['username'] );
    if( $user_dbo != null &&
	$user_dbo->getPassword() == $this->session['login']['password'] &&
	($user_dbo->getType() == "Administrator" || 
	 $user_dbo->getType() == "Account Manager") )
      {
	// Login success
	$_SESSION['client']['userdbo'] = $user_dbo;
	log_notice( "Login", "User: " . $user_dbo->getUsername() . " logged in" );
	$_SESSION['jsFunction'] = "reloadMenu()";
	$this->goto( "home" );
      }
    // Login failure
    log_security( "Login", 
		  "Login failed for " . $this->session['login']['username'] );
    $this->setError( array( "type" => "LOGIN_FAILED" ) );
  }
}

?>