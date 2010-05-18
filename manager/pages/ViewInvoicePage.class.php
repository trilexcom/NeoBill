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

/**
 * ViewInvoicePage
 *
 * Display an Invoice
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewInvoicePage extends SolidStatePage {
	/**
	 * Initialize View Invoice Page
	 *
	 * If an Invoice ID is provided in the query string, use it to load the InvoiceDBO
	 * from the database, then place the DBO in the session.  Otherwise, use the DBO
	 * that is already there.
	 */
	function init() {
		parent::init();

		// Give the template acess to the invoice DBO
		$this->session['invoice_dbo'] =& $this->get['invoice'];

		$invoiceID = $this->get['invoice']->getID();

		// Set the invoice URL field
		$this->setURLField( "invoice", $invoiceID );

		// Set this page's Nav Vars
		$this->setNavVar( "account_id", $this->get['invoice']->getAccountID() );
		$this->setNavVar( "account_name", $this->get['invoice']->getAccountName() );
		$this->setNavVar( "invoice_id", $invoiceID );

		// Setup the Invoice Item table
		$iiField = $this->forms['view_invoice_items']->getField( "items" );
		$iiField->getWidget()->setInvoiceID( $invoiceID );
		$iiField->getValidator()->setInvoiceID( $invoiceID );

		// Setup the Payment table
		$ptField = $this->forms['view_invoice_payments']->getField( "payments" );
		$ptField->getWidget()->setInvoiceID( $invoiceID );
		$ptField->getValidator()->setInvoiceID( $invoiceID );

		// Setup the Outstanding Invoices Table
		$oiField = $this->forms['view_invoice_outstanding_invoices']->getField( "invoices" );
		$oiField->getWidget()->setPriorToInvoice( $this->get['invoice'] );
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
	function action( $action_name ) {
		switch ( $action_name ) {
			case "view_invoice_action":
				if ( isset( $this->post['add_payment'] ) ) {
					// Jump to the Add Payment page
					$this->gotoPage( "accounts_add_payment",
							null,
							sprintf( "&invoice=%d&account=%d",
							$this->get['invoice']->getID(),
							$this->get['invoice']->getAccountID() ) );
				}
				elseif ( isset( $this->post['delete'] ) ) {
					// Jump to the Delete Invoice page
					$this->gotoPage( "billing_delete_invoice",
							null,
							"&invoice=" . $this->get['invoice']->getID() );
				}
				elseif ( isset( $this->post['email'] ) ) {
					// Jump to the Email Invoice page
					$this->gotoPage( "billing_email_invoice",
							null,
							"&invoice=" . $this->get['invoice']->getID() );
				}
				elseif ( isset( $this->post['print'] ) ) {
					// Jump to the Print Invoice page
					$this->gotoPage( "billing_print_invoice",
							null,
							"&invoice=" . $this->get['invoice']->getID() );
				}
				break;

			case "new_line_item":
				$this->add_line_item();
				break;

			case "view_invoice_items":
				if ( isset( $this->post['remove'] ) ) {
					$this->delete_line_item();
				}
				break;

			case "view_invoice_payments":
				if ( isset( $this->post['remove'] ) ) {
					$this->delete_payment();
				}
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
	function delete_payment() {
		// Delete Payments
		foreach ( $this->post['payments'] as $dbo ) {
			delete_PaymentDBO( $dbo );
		}

		// Success
		$this->setMessage( array( "type" => "[PAYMENT_DELETED]" ) );
		$this->reload();
	}

	/**
	 * Delete Line Item
	 *
	 * Remove a line item from the invoice
	 */
	function delete_line_item() {
		// Delete Invoice Items
		foreach ( $this->post['items'] as $dbo ) {
			delete_InvoiceItemDBO( $dbo );
		}

		// Success
		$this->setMessage( array( "type" => "[INVOICE_ITEM_DELETED]" ) );
		$this->reload();
	}

	/**
	 * Add Line Item
	 *
	 * Create a new InvoiceLineItemDBO and attach it to the Invoice
	 */
	function add_line_item() {
		// Create new Line Item DBO
		$lineitem_dbo = new InvoiceItemDBO();
		$lineitem_dbo->setText( $this->post['text'] );
		$lineitem_dbo->setUnitAmount( $this->post['unitamount'] );
		$lineitem_dbo->setQuantity( $this->post['quantity'] );
		$lineitem_dbo->setInvoiceID( $this->get['invoice']->getID() );
		
		// Save Lineitem to database
		add_InvoiceItemDBO( $lineitem_dbo );

		// Success
		$this->setMessage( array( "type" => "[INVOICE_ITEM_CREATED]" ) );
	}
}

?>