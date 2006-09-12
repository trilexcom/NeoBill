<?php
/**
 * DeleteHostingServicePage.class.php
 *
 * This file contains the definition for the Delete Hosting Service Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/AdminPage.class.php";

require_once $base_path . "DBO/HostingServiceDBO.class.php";
require_once $base_path . "DBO/HostingServicePurchaseDBO.class.php";

/**
 * DeleteHostingServicePage
 *
 * Delete a Hosting Service from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteHostingServicePage extends AdminPage
{
  /**
   * Initialize Delete Hosting Service Page
   *
   * If the Hosting Service ID is provided in the query string, load the 
   * HostingServiceDBO from the database and place it in the session.  Otherwise,
   * use the DBO already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Hosting Service from the database
	$dbo = load_HostingServiceDBO( $id );
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
   *   delete_hosting (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "delete_hosting":

	if( isset( $this->session['delete_hosting']['delete'] ) )
	  {
	    $this->delete_hosting();
	  }
	elseif( isset( $this->session['delete_hosting']['cancel'] ) )
	  {
	    $this->cancel();
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
    $this->goto( "services_view_hosting_service",
		 null,
		 "id=" . $this->session['hosting_dbo']->getID() );
  }

  /**
   * Delete Hosting
   *
   * Delete HostingServiceDBO from database
   */
  function delete_hosting()
  {
    $id = $this->session['hosting_dbo']->getID();
    if( load_array_HostingServicePurchaseDBO( "hostingserviceid=" . $id ) != null )
      {
	// Can not delete service if any purchases exist
	$this->setError( array( "type" => "PURCHASES_EXIST" ) );
	$this->cancel();
      }

    // Delete Hosting Service DBO
    if( !delete_HostingServiceDBO( $this->session['hosting_dbo'] ) )
      {
	// Delete failed
	$this->setError( array( "type" => "DB_HOSTING_DELETE_FAILED",
				"args" => array( $this->session['hosting_dbo']->getTitle() ) ) );
	$this->cancel();
      }

    // Success - go back to web hosting services page
    $this->setMessage( array( "type" => "HOSTING_SERVICE_DELETED",
			      "args" => array( $this->session['hosting_dbo']->getTitle() ) ) );
    $this->goto( "services_web_hosting" );
  }
}

?>