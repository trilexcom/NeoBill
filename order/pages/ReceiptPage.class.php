<?php
/**
 * ReceiptPage.class.php
 *
 * This file contains the definition for the ReceiptPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ReceiptPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ReceiptPage extends SolidStatePage
{
  /**
   * Initialize Review Page
   */
  function init()
  {
    if( !isset( $_SESSION['order'] ) || $_SESSION['order']->isEmpty() )
      {
	$this->gotoPage( "cart" );
      }

    // Give access to the template
    $this->session['order'] =& $_SESSION['order'];

    // Supress the welcome message
    $this->smarty->assign( "supressWelcome", true );

    $this->smarty->assign( "orderid", $this->session['order']->getID() );
    $this->smarty->assign( "contactemail", 
			   $this->session['order']->getContactEmail() );

    // If the paybycheck flag is set, display the payment information
    $this->smarty->assign( "paybycheck", $_GET['payByCheck'] == 1 );

    // Destroy the order object
    unset( $_SESSION['order'] );

    // Logout the user
    unset( $_SESSION['client']['userdbo'] );
  }
}