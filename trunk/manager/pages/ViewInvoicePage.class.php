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
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/InvoiceDBO.class.php";

/**
 * ViewInvoicePage
 *
 * Display an Invoice
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewInvoicePage extends Page
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
	if( isset( $this->session['view_invoice_action']['add_payment'] ) )
	  {
	    // Jump to the Add Payment page
	    $this->goto( "accounts_add_payment",
			 null,
			 "&invoiceid=" . $this->session['invoice_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_invoice_action']['delete'] ) )
	  {
	    // Jump to the Delete Invoice page
	    $this->goto( "billing_delete_invoice",
			 null,
			 "&id=" . $this->session['invoice_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_invoice_action']['email'] ) )
	  {
	    // Jump to the Email Invoice page
	    $this->goto( "billing_email_invoice",
			 null,
			 "&id=" . $this->session['invoice_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_invoice_action']['print'] ) )
	  {
	    // Jump to the Print Invoice page
	    $this->goto( "billing_print_invoice",
			 null,
			 "&id=" . $this->session['invoice_dbo']->getID() );
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
    $payment_id = intval( $_GET['paymentid'] );

    // Verify Payment exists
    if( ($payment_dbo = load_PaymentDBO( $payment_id ) ) == null )
      {
	// Payment not found
	fatal_error( "ViewInvoicePage::delete_payment()",
		     "could not retrieve PaymentDBO" );
      }

    // Delete PaymentDBO
    if( !delete_PaymentDBO( $payment_dbo ) )
      {
	// Could not delete payment
	$this->setError( array( "type" => "DB_DELETE_PAYMENT_FAILED" ) );
      }

    // Success
    $this->setMessage( array( "type" => "PAYMENT_DELETED" ) );

    // Reload InvoiceDBO
    $this->session['invoice_dbo'] = 
      load_InvoiceDBO( $this->session['invoice_dbo']->getID() );
  }

  /**
   * Delete Line Item
   *
   * Remove a line item from the invoice
   */
  function delete_line_item()
  {
    $item_id = intval( $_GET['itemid'] );

    // Verify InvoiceItem exists
    if( ($item_dbo = load_InvoiceItemDBO( $item_id ) ) == null )
      {
	// Item not found
	fatal_error( "ViewInvoicePage::delete_line_item()",
		     "error: could not retrieve InvoiceItemDBO" );
      }

    // Delete InvoiceItemDBO
    if( !delete_InvoiceItemDBO( $item_dbo ) )
      {
	// Could not delete line item
	$this->setError( array( "type" => "DB_DELETE_INVOICE_ITEM_FAILED",
				"args" => array( $item_dbo->getText() ) ) );
      }

    // Success
    $this->setMessage( array( "type" => "INVOICE_ITEM_DELETED",
			      "args" => array( $item_dbo->getText() ) ) );

    // Reload InvoiceDBO
    $this->session['invoice_dbo'] = 
      load_InvoiceDBO( $this->session['invoice_dbo']->getID() );
  }

  /**
   * Add Line Item
   *
   * Create a new InvoiceLineItemDBO and attach it to the Invoice
   */
  function add_line_item()
  {
    $text       = $this->session['new_line_item']['text'];
    $unitamount = $this->session['new_line_item']['unitamount'];
    $quantity   = $this->session['new_line_item']['quantity'];
    $invoiceid  = $this->session['invoice_dbo']->getID();

    // Create new Line Item DBO
    $lineitem_dbo = new InvoiceItemDBO();
    $lineitem_dbo->setText( $text );
    $lineitem_dbo->setUnitAmount( $unitamount );
    $lineitem_dbo->setQuantity( $quantity );
    $lineitem_dbo->setInvoiceID( $invoiceid );

    // Save Lineitem to database
    if( !add_InvoiceItemDBO( $lineitem_dbo ) )
      {
	// Failed to save lineitem
	$this->setError( array( "type" => "DB_ADD_INVOICE_ITEM_FAILED" ) );
	$this->goback( 1 );
      }

    // Success
    $this->setMessage( array( "type" => "INVOICE_ITEM_CREATED" ) );
    $this->goto( "billing_view_invoice",
		 null,
		 "id=" . $this->session['invoice_dbo']->getID() );
  }

  /**
   * Populate Outstanding Invoices Table
   *
   * @return array InvoiceDBO's
   */
  function populateOutstandingInvoices()
  {
    return $this->session['invoice_dbo']->getOutstandingInvoices();
  }
}

?>