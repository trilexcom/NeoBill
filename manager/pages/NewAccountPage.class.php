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

	if( isset( $this->session['new_account']['continue'] ) )
	  {
	    // Process new account form
	    $this->process_new_account();
	  }
	elseif( isset( $this->session['new_account']['cancel'] ) )
	  {
	    // Canceled
	    $this->goto( "accounts_browse" );
	  }

	break;

      case "new_account_confirm":

	if( isset( $this->session['new_account_confirm']['continue'] ) )
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
    // Pull data from session
    $account_data = $this->session['new_account'];

    if( !isset( $account_data ) )
      {
	// Missing form data 
	fatal_error( "NewAccountPage::process_new_account()",
		     "no form data received!" );
      }

    // Prepare AccountDBO
    $account_dbo = new AccountDBO();
    $account_dbo->load( $account_data );

    // Place DBO in the session for confirm page
    $this->session['new_account_dbo'] = $account_dbo;

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

    // Insert AccountDBO into database
    if( !add_AccountDBO( $account_dbo ) )
      {
	// Unable to add product to database
	$this->setError( array( "type" => "DB_ACCOUNT_ADD_FAILED",
				"args" => array( $account_dbo->getAccountName() ) ) );

	// Redisplay form
	$this->setTemplate( "default" );
      }
    else
      {
	// Account added - clear new_account data from session
	unset( $this->session['new_account'] );

	// Jump to View Account page
	$this->setMessage( array( "type" => "ACCOUNT_ADDED" ) );
	// $this->goto( "accounts_browse" );
	$this->goto( "accounts_view_account", null, "id=" . $account_dbo->getID() );
      }
  }
}

?>