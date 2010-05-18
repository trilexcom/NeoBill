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
require_once BASE_PATH . "include/SolidStatePage.class.php";

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
class WelcomeEmailPage extends SolidStatePage {
	/**
	 * Initializes the Page
	 */
	function init() {
		parent::init();

		// Set URL Fields
		$this->setURLField( "account", $this->get['account']->getID() );

		// Store Account DBO in session
		$this->session['account_dbo'] =& $this->get['account'];

		// Place values on the template
		$this->smarty->assign( "email",      $this->get['account']->getContactEmail() );
		$this->smarty->assign( "subject",    $this->conf['welcome_subject'] );
		$this->smarty->assign( "email_body", $this->conf['welcome_email'] );
	}

	/**
	 * Handles actions for this Page
	 *
	 * Actions handled by this Page:
	 *   email_invoice (Form)
	 */
	function action( $action_name ) {
		switch ( $action_name ) {
			case "welcome_email":
				if ( isset( $this->session['welcome_email']['continue'] ) ) {
					$this->send_email();
				}
				elseif ( isset( $this->session['welcome_email']['cancel'] ) ) {
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
	function cancel() {
		$this->gotoPage( "accounts_view_account",
				null,
				"account=" . $this->get['account']->getID() );
	}

	/**
	 * Email the welcome message and return to the view account page
	 */
	function send_email() {
		// Construct an Email
		$email = new Email();
		$email->setFrom( $this->conf['company']['email'],
				$this->conf['company']['name'] );
		$email->addRecipient( $this->session['welcome_email']['email'] );
		$email->setSubject( $this->session['welcome_email']['subject'] );
		$email->setBody( $this->session['welcome_email']['email_body'] );

		// Send the email
		if( !$email->send() ) {
			// Error delivering invoice
			throw new SWUserException( "[WELCOME_EMAIL_FAILED]" );
		}

		// Return to view_account with a sucess message
		$this->setMessage( array( "type" => "[WELCOME_SENT]" ) );
		$this->gotoPage( "accounts_view_account",
				null,
				"account=" . $this->get['account']->getID() );
	}
}
?>