<?php
/**
 * DeleteAccountPage.class.php
 *
 * This file contains the definition for the DeleteAccountPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

/**
 * DeleteAccountPage
 *
 * Delete an Account from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteAccountPage extends Page
{
  /**
   * Initialize Delete Account Page
   *
   * If Account ID is provided in the query string, use that to load the AccountDBO
   * from the database, then stick it in the session.  Otherwise, use the DBO already
   * in the session.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Account from the database
	$dbo = load_AccountDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['account_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Account
	$this->setError( array( "type" => "DB_ACCOUNT_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['account_dbo'] = $dbo;
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   delete_account (form)
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "delete_account":

	if( isset( $this->session['delete_account']['delete'] ) )
	  {
	    // Delete
	    $this->delete_account();
	  }
	elseif( isset( $this->session['delete_account']['cancel'] ) )
	  {
	    // Cancel
	    $this->goback( 2 );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Delete Account
   *
   * Delete AccountDBO
   */
  function delete_account()
  {
    // Delete Account DBO
    if( !delete_AccountDBO( $this->session['account_dbo'] ) )
      {
	// Delete failed
	$this->setError( array( "type" => "DB_ACCOUNT_DELETE_FAILED",
				"args" => array( $this->session['account_dbo']->getAccountName() ) ) );
	$this->goback( 1 );
      }

    // Success - go back to accounts page
    $this->setMessage( array( "type" => "ACCOUNT_DELETED",
			      "args" => array( $this->session['account_dbo']->getAccountName() ) ) );
    $this->goto( "accounts_browse" );
  }
}

?>