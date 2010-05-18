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
require BASE_PATH . "include/SolidStatePage.class.php";

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
class PrintInvoicePage extends SolidStatePage {
	/**
	 * Initializes the Page
	 *
	 * If an invoice ID appears in the URL, then init() attempts to load that Invoice,
	 * otherwise, it uses an invoice already in the session.
	 */
	function init() {
		parent::init();
		$this->smarty->assign( "body",
				$this->get['invoice']->text( $this->conf['invoice_text'] ) );
	}
}
?>