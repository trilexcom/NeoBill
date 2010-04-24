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
require BASE_PATH . "include/SolidStatePage.class.php";

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
class EmailInvoicePage extends SolidStatePage
{
  /**
   * Initializes the Page
   *
   * If an invoice ID appears in the URL, then init() attempts to load that Invoice,
   * otherwise, it uses an invoice already in the session.
   */
  function init()
  {
    parent::init();

    // Set URL Field values
    $this->setURLField( "invoice", $this->get['invoice']->getID() );

    // Set this page's Nav Vars
    $this->setNavVar( "invoice_id", $this->get['invoice']->getID() );

    // Retrieve the Account DBO for this invoice
    $account_dbo = $this->get['invoice']->getAccountDBO();

    // Replace tokens in subject field
    $subject = $this->conf['invoice_subject'];
    $subject = str_replace( "{company_name}", $this->conf['company']['name'], $subject );
    $subject = str_replace( "{period_begin_date}",
			    date( "m/d/y",
				      DBConnection::datetime_to_unix( $this->get['invoice']->getPeriodBegin() ) ),
			    $subject );
    $subject = str_replace( "{period_end_date}",
			    date( "m/d/y",
				      DBConnection::datetime_to_unix( $this->get['invoice']->getPeriodEnd() ) ),
			    $subject );

    $this->smarty->assign( "email", $account_dbo->getContactEmail() );
    $this->smarty->assign( "subject", $subject );
    $this->smarty->assign( "body",  
			   $this->get['invoice']->text( $this->conf['invoice_text'] ) );
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
	if( isset( $this->post['continue'] ) )
	  {
	    $this->send_invoice();
	  }
	elseif( isset( $this->post['cancel'] ) )
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
    $this->gotoPage( "billing_view_invoice",
		 null,
		 "invoice=" . $this->get['invoice']->getID() );
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
    $email->addRecipient( $this->post['email'] );
    $email->setSubject( $this->post['subject'] );
    $email->setBody( $this->post['invoice'] );

    // Send the email
    if( !$email->send() )
      {
	// Error delivering invoice
	throw new SWUserException( "[INVOICE_EMAIL_FAILED]" );
      }

    // Return to view_invoice with a sucess message
    $this->setMessage( array( "type" => "[INVOICE_SENT]" ) );
    $this->gotoPage( "billing_view_invoice",
		 null,
		 "invoice=" . $this->get['invoice']->getID() );
  }
}
?>