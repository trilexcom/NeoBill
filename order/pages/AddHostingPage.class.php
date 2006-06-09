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
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/OrderDBO.class.php";
require_once $base_path . "DBO/HostingServiceDBO.class.php";

/**
 * AddHostingPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddHostingPage extends Page
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
	if( isset( $this->session['hostingservice']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	elseif( isset( $this->session['hostingservice']['continue'] ) )
	  {
	    $this->process();
	  }
	elseif( isset( $this->session['hostingservice']['skip'] ) )
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
    if( !isset( $_SESSION['order'] ) )
      {
	// Start a new order
	$_SESSION['order'] = new OrderDBO();
      }

    $this->smarty->assign( "show_cancel", $this->getLastPage() == "cart" );
    $this->smarty->assign( "show_skip", 
			   $this->getLastPage() == "adddomain" && !$_SESSION['order']->isEmpty() );
  }

  /**
   * Populate the Service ID field with Hosting Services
   *
   * @return array Hosting services as id => description
   */
  function populateServiceIDField()
  {
    $data = array();
    $services = load_array_HostingServiceDBO();

    if( isset( $services ) )
      {
	foreach( $services as $service_dbo )
	  {
	    $data[$service_dbo->getID()] = $service_dbo->getTitle();
	  }
      }

    return $data;
  }

  /**
   * Populate the Term field with terms and pricing for the
   * selected hosting service.
   *
   * @return array Terms as term => description
   */
  function populateTermField()
  {
    $serviceid = $this->session['hostingservice']['serviceid'];
    if( !isset( $serviceid ) )
      {
	$services = load_array_HostingServiceDBO();
	$service_dbo = array_shift( $services );
      }
    else
      {
	$service_dbo = load_HostingServiceDBO( $serviceid );
      }

    $cs = $this->conf['locale']['currency_symbol'];
    return( array( "1 month" => "[1_MONTH] (" . $cs . $service_dbo->getSetupPrice1mo() . " [SETUP], " . $cs . $service_dbo->getPrice1mo() . " [RECURRING])",
		   "3 months" => "[3_MONTHS] (" . $cs . $service_dbo->getSetupPrice3mo() . " [SETUP], " . $cs . $service_dbo->getPrice3mo() . " [RECURRING])",
		   "6 months" => "[6_MONTHS] (" . $cs . $service_dbo->getSetupPrice6mo() . " [SETUP], " . $cs . $service_dbo->getPrice6mo() . " [RECURRING])",
		   "12 months" => "[12_MONTHS] (" . $cs . $service_dbo->getSetupPrice12mo() . " [SETUP], " . $cs . $service_dbo->getPrice12mo() . " [RECURRING])" ) );
  }

  /**
   * Process New Hosting Purchase
   */
  function process()
  {
    $servicedbo =
      load_HostingServiceDBO( $this->session['hostingservice']['serviceid'] );

    // Create a Hosting Order Item
    $dbo = new OrderHostingDBO();
    $dbo->setService( $servicedbo );
    $dbo->setTerm( $this->session['hostingservice']['term'] );

    // Add the item to the order
    $_SESSION['order']->addItem( $dbo );

    $this->done();
  }
}

?>
