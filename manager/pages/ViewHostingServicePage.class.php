<?php
/**
 * ViewHostingServicePage.class.php
 *
 * This file contains the definition for the View Hosting Service Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ViewHostingServicePage
 *
 * Display a hosting service.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewHostingServicePage extends SolidStatePage
{
  /**
   * Initialize View Hosting Service Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "hservice", $this->get['hservice']->getID() );

    // Store service DBO in session
    $this->session['hosting_dbo'] =& $this->get['hservice'];
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   view_hosting_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "view_hosting_action":
	if( isset( $this->post['edit'] ) )
	  {
	    // Edit this Hosting Service
	    $this->gotoPage( "services_edit_hosting",
			 null,
			 "hservice=" . $this->get['hservice']->getID() );
	  }
	elseif( isset( $this->post['delete'] ) )
	  {
	    // Delete this Hosting Service
	    $this->gotoPage( "services_delete_hosting",
			 null,
			 "hservice=" . $this->get['hservice']->getID() );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}
?>