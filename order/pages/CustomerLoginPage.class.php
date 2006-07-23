<?php
/**
 * CustomerLoginPage.class.php
 *
 * This file contains the definition of the CustomerLoginPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/UserDBO.class.php";

/**
 * CustomerLoginPage
 *
 * Handles user authentication
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CustomerLoginPage extends Page
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
	if( isset( $this->session['login']['login'] ) )
	  {
	    $this->login();
	  }
	elseif( isset( $this->session['login']['back'] ) )
	  {
	    $this->goback();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize the Page
   */
  function init()
  {
    // Suppress the login link
    $this->smarty->assign( "username", " " );
  }

  /**
   * Login Customer
   */
  function login()
  {
    $userDBO = load_UserDBO( $this->session['login']['username'] );
    if( $userDBO && $userDBO->getPassword() == $this->session['login']['password'] )
      {
	// Only customers are allowed to login to the order form
	if( $userDBO->getType() != "Client" )
	  {
	    $this->setError( array( "type" => "ONLY_CUSTOMERS_CAN_LOGIN" ) );
	    return;
	  }

	// Login success
	$_SESSION['client']['userdbo'] = $userDBO;
	log_notice( "CustomerLoginPage::login()", 
		    "User: " . $userDBO->getUsername() . " logged in." );
	$this->goto( "cart" );
      }

    // Login failure
    log_security( "CustomerLoginPage::login()",
		  "Login failed for: " . $this->session['login']['username'] );
    $this->setError( array( "type" => "LOGIN_FAILED" ) );
  }
}
?>