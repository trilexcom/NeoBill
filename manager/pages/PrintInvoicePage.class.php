<?php
/**
 * PrintInvoicePage.class.php
 *
 * This file contains the definition for the PrintInvoicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// Include the InvoiceDBO
require_once $base_path . "DBO/InvoiceDBO.class.php";

/**
 * PrintInvoicePage
 *
 * This page takes the ID of the invoice to be printed.  The Invoice and content
 * of the invoice is read from a configuration file and the appropriate data is
 * filled in with the customer's data.
 *
 * @package Pages
 * @auther John Diamond <jdiamond@solid-state.org>
 */
class PrintInvoicePage extends Page
{
  /**
   * Initializes the Page
   *
   * If an invoice ID appears in the URL, then init() attempts to load that Invoice,
   * otherwise, it uses an invoice already in the session.
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
	echo "Error: Invoice ID not provided!";
	exit();
      }

    if( !isset( $dbo ) )
      {
	// Could not find Invoice
	$this->setError( array( "type" => "DB_INVOICE_NOT_FOUND",
				"args" => array( $id ) ) );
      }

    $account_dbo = $dbo->getAccountDBO();

    $this->smarty->assign( "body",  $dbo->text( $this->conf['invoice_text'] ) );
  }
}