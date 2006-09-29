<?php
/**
 * EmailInvoicePage.class.php
 *
 * This file contains the definition for the EmailInvoicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the Email class
require_once BASE_PATH . "solidworks/Email.class.php";

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

// Include the InvoiceDBO
require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * EmailInvoicePage
 *
 * This page takes the ID of the invoice to be emailed.  The Invoice and content
 * of the invoice is read from a configuration file and the appropriate data is
 * filled in with the customer's data.  The user is allowed to edit the raw content
 * of the email, the invoice, and the customers email before the invoice is sent.
 *
 * @package Pages
 * @auther John Diamond <jdiamond@solid-state.org>
 */
class EmailInvoicePage extends Page
{
  /**
   * Initializes the Page
   *
   * If an invoice ID appears in the URL, then init() attempts to load that Invoice,
   * otherwise, it uses an invoice already in the session.
   */
  function init()
  {
    global $DB;

    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve this Invoice from the database
	$dbo = load_InvoiceDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['invoice_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Invoice
	$this->setError( array( "type" => "DB_INVOICE_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store Invoice DBO in session
	$this->session['invoice_dbo'] = $dbo;

	// Set this page's Nav Vars
	$this->setNavVar( "invoice_id", $dbo->getID() );
      }

    $account_dbo = $dbo->getAccountDBO();

    // Replace tokens in subject field
    $subject = $this->conf['invoice_subject'];
    $subject = str_replace( "{company_name}", $this->conf['company']['name'], $subject );
    $subject = str_replace( "{period_begin_date}",
			    strftime( "%D", 
				      $DB->datetime_to_unix( $dbo->getPeriodBegin() ) ),
			    $subject );
    $subject = str_replace( "{period_end_date}",
			    strftime( "%D", 
				      $DB->datetime_to_unix( $dbo->getPeriodEnd() ) ),
			    $subject );

    $this->smarty->assign( "email", $account_dbo->getContactEmail() );
    $this->smarty->assign( "subject", $subject );
    $this->smarty->assign( "body",  $dbo->text( $this->conf['invoice_text'] ) );
  }

  /**
   * Handles actions for this Page
   *
   * Actions handled by this Page:
   *   email_invoice (Form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "email_invoice":

	if( isset( $this->session['email_invoice']['continue'] ) )
	  {
	    $this->send_invoice();
	  }
	elseif( isset( $this->session['email_invoice']['cancel'] ) )
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
   * Cancel Form
   *
   * Return the user to the view invoice page
   */
  function cancel()
  {
    $this->goto( "billing_view_invoice",
		 null,
		 "id=" . $this->session['invoice_dbo']->getID() );
  }

  /**
   * Send Invoice Email
   *
   * Email the invoice and return to the view_invoice page
   */
  function send_invoice()
  {
    // Construct an Email
    $email = new Email();
    $email->setFrom( $this->conf['company']['email'],
		     $this->conf['company']['name'] );
    $email->addRecipient( $this->session['email_invoice']['email'] );
    $email->setSubject( $this->session['email_invoice']['subject'] );
    $email->setBody( $this->session['email_invoice']['invoice'] );

    // Send the email
    if( !$email->send() )
      {
	// Error delivering invoice
	$this->setError( array( "type" => "INVOICE_EMAIL_FAILED" ) );
	$this->goto( "billing_view_invoice",
		     null,
		     "id=" . $this->session['invoice_dbo']->getID() );
      }

    // Return to view_invoice with a sucess message
    $this->setMessage( array( "type" => "INVOICE_SENT" ) );
    $this->goto( "billing_view_invoice",
		 null,
		 "id=" . $this->session['invoice_dbo']->getID() );
  }
}

?>