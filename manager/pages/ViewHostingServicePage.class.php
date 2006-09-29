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
require_once BASE_PATH . "solidworks/Page.class.php";

require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * ViewHostingServicePage
 *
 * Display a hosting service.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewHostingServicePage extends Page
{
  /**
   * Initialize View Hosting Service Page
   *
   * If a hosting service ID is provided in the query string, use it to load the
   * HostingServiceDBO from the database, then place the DBO in the session.
   * Otherwise, use the DBO that is already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Hosting Service from the database
	$dbo = load_HostingServiceDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['hosting_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Hosting Service
	$this->setError( array( "type" => "DB_HOSTING_SERVICE_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['hosting_dbo'] = $dbo;
      }
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

	if( isset( $this->session['view_hosting_action']['edit'] ) )
	  {
	    // Edit this Hosting Service
	    $this->goto( "services_edit_hosting",
			 null,
			 "id=" . $this->session['hosting_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_hosting_action']['delete'] ) )
	  {
	    // Delete this Hosting Service
	    $this->goto( "services_delete_hosting",
			 null,
			 "id=" . $this->session['hosting_dbo']->getID() );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>