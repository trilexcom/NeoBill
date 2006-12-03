<?php
/**
 * NewAccountPage.class.php
 *
 * This file contains the definition for the NewAccountPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

// Include the AccountDBO class
require_once BASE_PATH . "DBO/AccountDBO.class.php";

/**
 * NewAccountPage
 *
 * Create a new customer account
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NewAccountPage extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   new_account (form)
   *   new_account_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "new_account":
	if( isset( $this->post['continue'] ) )
	  {
	    // Process new account form
	    $this->process_new_account();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Canceled
	    $this->goto( "accounts_browse" );
	  }
	break;

      case "new_account_confirm":
	if( isset( $this->post['continue'] ) )
	  {
	    // Go ahead
	    $this->add_account();
	  }
	else
	  {
	    // Go back
	    $this->setTemplate( "default" );
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Process New Account
   *
   * Prepare an AccountDBO, then prompt the client to confirm the new account
   */
  function process_new_account()
  {
    // Make sure the username is available
    if( load_UserDBO( $this->post['username'] ) != null )
      {
	throw new SWUserException( "[DB_USER_EXISTS]" );
      }

    // Prepare AccountDBO
    $account_dbo = new AccountDBO();
    $account_dbo->load( $this->post );

    $user_dbo = new UserDBO();
    $user_dbo->setUsername( $this->post['username'] );
    $user_dbo->setPassword( $this->post['password'] );
    $user_dbo->setEmail( $this->post['contactemail'] );
    $user_dbo->setContactName( $this->post['contactname'] );
    $user_dbo->setType( "Client" );

    // Place DBO in the session for confirm page
    $this->session['new_account_dbo'] = $account_dbo;
    $this->session['user_dbo'] = $user_dbo;

    // Ask client to confirm
    $this->setTemplate( "confirm" );
  }

  /**
   * Add Account
   *
   * Add the AccountDBO to the database
   */
  function add_account()
  {
    // Extract AccountDBO from the session
    $account_dbo =& $this->session['new_account_dbo'];

    // Insert UserBO into database
    if( !add_UserDBO( $this->session['user_dbo'] ) )
      {
	throw new SWUserException( "[DB_USER_ADD_FAILED]" );
      }
    
    // Insert AccountDBO into database
    $account_dbo->setUsername( $this->session['user_dbo']->getUsername() );
    if( !add_AccountDBO( $account_dbo ) )
      {
	// Unable to add product to database
	delete_UserDBO( $this->session['user_dbo'] );
	$this->setError( array( "type" => "DB_ACCOUNT_ADD_FAILED",
				"args" => array( $account_dbo->getAccountName() ) ) );

	// Redisplay form
	$this->setTemplate( "default" );
      }
    else
      {
	
	// Jump to View Account page
	$this->setMessage( array( "type" => "ACCOUNT_ADDED" ) );
	$this->goto( "accounts_view_account", null, "account=" . $account_dbo->getID() );
      }
  }
}

?>