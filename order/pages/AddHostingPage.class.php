<?php
/**
 * AddHostingPage.class.php
 *
 * This file contains the definition for the AddHostingPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/OrderDBO.class.php";
require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * AddHostingPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddHostingPage extends SolidStatePage
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
      case "hostingservice":
	if( isset( $this->post['cancel'] ) )
	  {
	    $this->cancel();
	  }
	elseif( isset( $this->post['continue'] ) )
	  {
	    $this->process();
	  }
	elseif( isset( $this->post['skip'] ) )
	  {
	    $_SESSION['order']->skipHosting( true );
	    $this->done();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goto( "cart" );
  }

  /**
   * Done Processing New Hosting Purchase
   */
  function done()
  {
    $this->goto( "cart" );
  }

  /**
   * Initialize the Page
   */
  function init()
  {
    if( load_array_HostingServiceDBO() == null )
      {
	$this->done();
      }

    if( !isset( $_SESSION['order'] ) )
      {
	// Start a new order
	$_SESSION['order'] = new OrderDBO();
      }

    // Show prices for the selected hosting package
    $termWidget = $this->forms['hostingservice']->getField( "term" )->getWidget();
    if( isset( $_POST['service'] ) )
      {
	$termWidget->setHostingService( load_HostingServiceDBO( intval( $_POST['service'] ) ) );
      }
    else
      {
	$services = load_array_HostingServiceDBO();
	$termWidget->setHostingService( array_shift( $services ) );
      }

    $this->smarty->assign( "show_cancel", $this->getLastPage() == "cart" );
    $this->smarty->assign( "show_skip", 
			   $this->getLastPage() == "adddomain" && !$_SESSION['order']->isEmpty() );
  }

  /**
   * Process New Hosting Purchase
   */
  function process()
  {
    // Create a Hosting Order Item
    $dbo = new OrderHostingDBO();
    $dbo->setService( $this->post['service'] );
    $dbo->setTerm( $this->post['term'] );

    // Add the item to the order
    $_SESSION['order']->addItem( $dbo );

    $this->done();
  }
}
?>