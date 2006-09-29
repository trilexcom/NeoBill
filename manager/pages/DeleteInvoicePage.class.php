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
require_once BASE_PATH . "solidworks/Page.class.php";

require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * DeleteInvoicePage
 *
 * Delete an Invoice from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteInvoicePage extends Page
{
  /**
   * Initialize Delete Invoice Page
   *
   * If the Invoice ID is provided in the query string, load the InvoiceDBO from
   * the database and place it in the session.  Otherwise, use the DBO already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve this Invoice from the database
	$dbo = load_InvoiceDBO( $id );
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
   *   delete_invoice (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "delete_invoice":

	if( isset( $this->session['delete_invoice']['delete'] ) )
	  {
	    // Delete
	    $this->delete_invoice();
	  }
	elseif( isset( $this->session['delete_invoice']['cancel'] ) )
	  {
	    // Cancel
	    $this->goback( 2 );
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
    if( !delete_InvoiceDBO( $this->session['invoice_dbo'] ) )
      {
	// Delete failed
	$this->setError( array( "type" => "DB_INVOICE_DELETE_FAILED",
				"args" => array( $this->session['invoice_dbo']->getID() ) ) );
	$this->goback( 1 );
      }

    // Success - go back to products page
    $this->setMessage( array( "type" => "INVOICE_DELETED",
			      "args" => array( $this->session['invoice_dbo']->getID() ) ) );
    $this->goto( "billing_invoices" );
  }

}

?>