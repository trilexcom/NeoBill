<?php
/**
 * DeleteInvoicePage.class.php
 *
 * This file contains the definition for the Delete Invoice Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * DeleteInvoicePage
 *
 * Delete an Invoice from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteInvoicePage extends SolidStatePage
{
  /**
   * Initialize Delete Invoice Page
   */
  function init()
  {
    parent::init();

    // Provide the template with access to the Invoice DBO
    $this->session['invoice_dbo'] =& $this->get['invoice'];

    // Set URL Fields
    $this->setURLField( "invoice", $this->get['invoice']->getID() );

    // Set this page's Nav Vars
    $this->setNavVar( "invoice_id", $this->get['invoice']->getID() );

    // Setup the item table
    $widget = $this->forms['delete_invoice_items']->getField( "items" )->getWidget();
    $widget->setInvoiceID( $this->get['invoice']->getID() );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   delete_invoice (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "delete_invoice":
	if( isset( $this->post['delete'] ) )
	  {
	    // Delete
	    $this->delete_invoice();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel
	    $this->goback();
	  }
	break;
	
      default:
	// No matching action, refer to base class
	parent::action( $action_name );
	break;
      }
  }

  /**
   * Delete Invoice
   *
   * Delete InvoiceDBO from database.
   */
  function delete_invoice()
  {
    // Delete Invoice DBO
    if( !delete_InvoiceDBO( $this->get['invoice'] ) )
      {
	// Delete failed
	$this->setError( array( "type" => "DB_INVOICE_DELETE_FAILED",
				"args" => array( $this->session['invoice_dbo']->getID() ) ) );
	$this->reload();
      }

    // Success - go back to products page
    $this->setMessage( array( "type" => "INVOICE_DELETED",
			      "args" => array( $this->session['invoice_dbo']->getID() ) ) );
    $this->goto( "billing_invoices" );
  }

}

?>