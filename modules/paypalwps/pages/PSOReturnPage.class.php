<?php
/**
 * PSOReturnPage.class.php
 *
 * This file contains the definition of the PSOReturnPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

require_once BASE_PATH . "DBO/OrderDBO.class.php";

/**
 * PSOReturnPage
 *
 * Processes a completed Paypal transaction
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PSOReturnPage extends Page
{
  /**
   * @var Paypal Paypal Module object
   */
  var $ppModule;

  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      default:
	// No matching action - refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Initialize the Page
   */
  function init()
  {
    parent::init();

    if( !isset( $_GET['tx'] ) )
      {
	// Expected a TX value from Paypal
	fatal_error( "PSOReturnPage::init()", 
		     "Missing TX value.  Make sure PDT is turned on for the store's Paypal account." );
      }

    $registry = ModuleRegistry::getModuleRegistry();
    $this->ppModule = $registry->getModule( 'paypalwps' );

    // Process the PDT
    $pdtData = $this->ppModule->processPDT( $_GET['tx'] );

    $this->smarty->assign( "paymentStatus", $pdtData['payment_status'] );
    $this->smarty->assign( "amount", $pdtData['payment_gross'] );

    // Complete the order
    $_SESSION['order']->complete();

    // Show receipt
    $this->goto( "receipt" );
  }
}
?>