<?php
/**
 * ViewInvoicePage.class.php
 *
 * This file contains the definition for the ViewInvoicePage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * ViewInvoicePage
 *
 * Display an Invoice
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewInvoicePage extends SolidStatePage
{
  /**
   * Initialize View Invoice Page
   *
   * If an Invoice ID is provided in the query string, use it to load the InvoiceDBO
   * from the database, then place the DBO in the session.  Otherwise, use the DBO
   * that is already there.
   */
  function init()
  {
    parent::init();

    // Give the template acess to the invoice DBO
    $this->session['invoice_dbo'] =& $this->get['invoice'];

    // Set the invoice URL field
    $this->setURLField( "invoice", $this->get['invoice']->getID() );

    // Set this page's Nav Vars
    $this->setNavVar( "account_id", $this->get['invoice']->getAccountID() );
    $this->setNavVar( "account_name", $this->get['invoice']->getAccountName() );
    $this->setNavVar( "invoice_id", $this->get['invoice']->getID() );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   view_invoice_action (form)
   *   new_line_item (form)
   *   delete_item
   *   delete_payment
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "view_invoice_action":
	if( isset( $this->post['add_payment'] ) )
	  {
	    // Jump to the Add Payment page
	    $this->goto( "accounts_add_payment",
			 null,
			 sprintf( "&invoice=%d&account=%d",
				  $this->get['invoice']->getID(),
				  $this->get['invoice']->getAccountID() ) );
	  }
	elseif( isset( $this->post['delete'] ) )
	  {
	    // Jump to the Delete Invoice page
	    $this->goto( "billing_delete_invoice",
			 null,
			 "&invoice=" . $this->get['invoice']->getID() );
	  }
	elseif( isset( $this->post['email'] ) )
	  {
	    // Jump to the Email Invoice page
	    $this->goto( "billing_email_invoice",
			 null,
			 "&invoice=" . $this->get['invoice']->getID() );
	  }
	elseif( isset( $this->post['print'] ) )
	  {
	    // Jump to the Print Invoice page
	    $this->goto( "billing_print_invoice",
			 null,
			 "&invoice=" . $this->get['invoice']->getID() );
	  }
	break;
	
      case "new_line_item":
	$this->add_line_item();
	break;

      case "delete_item":
	$this->delete_line_item();
	break;

      case "delete_payment":
	$this->delete_payment();
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Payment
   *
   * Remove a payment from the Invoice
   */
  function delete_payment()
  {
    // Verify that a payment was provided
    if( !isset( $this->get['payment'] ) )
      {
	throw new SWException( "There is no payment to delete!" );
      }

    // Delete PaymentDBO
    if( !delete_PaymentDBO( $this->get['payment'] ) )
      {
	// Could not delete payment
	$this->setError( array( "type" => "DB_DELETE_PAYMENT_FAILED" ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "PAYMENT_DELETED" ) );
    $this->reload();
  }

  /**
   * Delete Line Item
   *
   * Remove a line item from the invoice
   */
  function delete_line_item()
  {
    // Verify that a line item was provided
    if( !isset( $this->get['item'] ) )
      {
	throw new SWException( "There is no line item to delete!" );
      }
    
    // Delete InvoiceItemDBO
    if( !delete_InvoiceItemDBO( $this->get['item'] ) )
      {
	// Could not delete line item
	$this->setError( array( "type" => "DB_DELETE_INVOICE_ITEM_FAILED",
				"args" => array( $item_dbo->getText() ) ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "INVOICE_ITEM_DELETED",
			      "args" => array( $this->get['item']->getText() ) ) );
    $this->reload();
  }

  /**
   * Add Line Item
   *
   * Create a new InvoiceLineItemDBO and attach it to the Invoice
   */
  function add_line_item()
  {
    // Create new Line Item DBO
    $lineitem_dbo = new InvoiceItemDBO();
    $lineitem_dbo->setText( $this->post['text'] );
    $lineitem_dbo->setUnitAmount( $this->post['unitamount'] );
    $lineitem_dbo->setQuantity( $this->post['quantity'] );
    $lineitem_dbo->setInvoiceID( $this->get['invoice']->getID() );

    // Save Lineitem to database
    if( !add_InvoiceItemDBO( $lineitem_dbo ) )
      {
	// Failed to save lineitem
	$this->setError( array( "type" => "DB_ADD_INVOICE_ITEM_FAILED" ) );
      }

    // Success
    $this->setMessage( array( "type" => "INVOICE_ITEM_CREATED" ) );
  }

  /**
   * Populate Outstanding Invoices Table
   *
   * @return array InvoiceDBO's
   */
  function populateOutstandingInvoices()
  {
    return $this->get['invoice']->getOutstandingInvoices();
  }
}

?>