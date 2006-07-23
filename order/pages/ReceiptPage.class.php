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
require_once $base_path . "solidworks/Page.class.php";

// Order DBO
require_once $base_path . "DBO/OrderDBO.class.php";

/**
 * ReceiptPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ReceiptPage extends Page
{
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
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize Review Page
   */
  function init()
  {
    if( !isset( $_SESSION['order'] ) || $_SESSION['order']->isEmpty() )
      {
	$this->goto( "cart" );
      }

    // Give access to the template
    $this->session['order'] =& $_SESSION['order'];

    // Supress the welcome message
    $this->smarty->assign( "supressWelcome", true );

    $this->smarty->assign( "orderid", $this->session['order']->getID() );
    $this->smarty->assign( "contactemail", 
			   $this->session['order']->getContactEmail() );

    // Destroy the order object
    unset( $_SESSION['order'] );

    // Logout the user
    unset( $_SESSION['client']['userdbo'] );
  }
}