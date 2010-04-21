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

require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * LoginPage
 *
 * Handles user authentication
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LoginPage extends SolidStatePage
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
   * Initialize the Page
   */
  public function init()
  {
    parent::init();

    // Setup the theme drop-down
    $tField = $this->forms['login']->getField( "theme" );
    $tField->getWidget()->setType( "manager" );
    $tField->getValidator()->setType( "manager" );
  }

  /**
   * Login
   *
   * Validate the login.  Store the UserDBO in the session if OK, or display an error
   * if the login failed.
   */
  function login()
  {
    try
      {
	$user_dbo = load_UserDBO( $this->post['username'] );
	if( $user_dbo->getPassword() == $this->post['password'] &&
	    ($user_dbo->getType() == "Administrator" || 
	     $user_dbo->getType() == "Account Manager") )
	  {
	    // Login success
	    if( isset( $this->post['theme'] ) )
	      {
		$user_dbo->setTheme( $this->post['theme'] );
	      }
	    $_SESSION['client']['userdbo'] = $user_dbo;
	    log_notice( "Login", "User: " . $user_dbo->getUsername() . " logged in" );
	    $_SESSION['jsFunction'] = "reloadMenu()";
	    $this->gotoPage( "home" );
	  }
      }
    catch( DBNoRowsFoundException $e ) {}

    // Login failure
    log_security( "Login", 
		  "Login failed for " . $this->post['username'] );
    throw new SWUserException( "[LOGIN_FAILED]" );
  }
}
?>