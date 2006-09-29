<?php
/**
 * WelcomeEmailPage.class.php
 *
 * This file contains the definition for the EmailInvoicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the Email class
require_once BASE_PATH ."solidworks/Email.class.php";

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

// Include the AccountDBO
require_once BASE_PATH . "DBO/AccountDBO.class.php";

/**
 * WelcomeEmailPage
 *
 * This page takes the ID of the account to send a welcome email to.  
 * The body of the welcome email is read from a configuration file and the appropriate 
 * data is filled in with the customer's data.  The user is allowed to edit 
 * the raw content of the email, the subject, and the customers email address 
 * before the email is sent.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class WelcomeEmailPage extends Page
{
  /**
   * Initializes the Page
   *
   * Loads the DBO for the account ID provided as a GET paramenter
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve this Account from the database
	$dbo = load_AccountDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['account_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Account in the database
	$this->setError( array( "type" => "DB_ACCOUNT_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store Account DBO in session
	$this->session['account_dbo'] = $dbo;
      }

    // Place values on the template
    $this->smarty->assign( "email",      $dbo->getContactEmail() );
    $this->smarty->assign( "subject",    $this->conf['welcome_subject'] );
    $this->smarty->assign( "email_body", $this->conf['welcome_email'] );
  }

  /**
   * Handles actions for this Page
   *
   * Actions handled by this Page:
   *   email_invoice (Form)
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "welcome_email":

	if( isset( $this->session['welcome_email']['continue'] ) )
	  {
	    $this->send_email();
	  }
	elseif( isset( $this->session['welcome_email']['cancel'] ) )
	  {
	    $this->cancel();
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Return the user to the view account page
   */
  function cancel()
  {
    $this->goto( "accounts_view_account",
		 null,
		 "id=" . $this->session['account_dbo']->getID() );
  }

  /**
   * Email the welcome message and return to the view account page
   */
  function send_email()
  {
    // Construct an Email
    $email = new Email();
    $email->setFrom( $this->conf['company']['email'],
		     $this->conf['company']['name'] );
    $email->addRecipient( $this->session['welcome_email']['email'] );
    $email->setSubject( $this->session['welcome_email']['subject'] );
    $email->setBody( $this->session['welcome_email']['email_body'] );

    // Send the email
    if( !$email->send() )
      {
	// Error delivering invoice
	$this->setError( array( "type" => "WELCOME_EMAIL_FAILED" ) );
	$this->goto( "accounts_view_account",
		     null,
		     "id=" . $this->session['account_dbo']->getID() );
      }

    // Return to view_account with a sucess message
    $this->setMessage( array( "type" => "WELCOME_SENT" ) );
    $this->goto( "accounts_view_account",
		 null,
		 "id=" . $this->session['account_dbo']->getID() );
  }
}

?>