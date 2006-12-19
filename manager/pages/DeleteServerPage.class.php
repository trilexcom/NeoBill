<?php
/**
 * DeleteServerPage.class.php
 *
 * This file contains the definition for the DeleteServerPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * DeleteServerPage
 *
 * Delete a Server
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteServerPage extends SolidStateAdminPage
{
  /**
   * Initialize Delete Server Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "server", $this->get['server']->getID() );

    // Store Server DBO in session
    $this->session['server_dbo'] =& $this->get['server'];

    // Set this page's Nav Vars
    $this->setNavVar( "id",   $this->get['server']->getID() );
    $this->setNavVar( "hostname", $this->get['server']->getHostName() );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   delete_server (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "delete_server":
	if( isset( $this->post['delete'] ) )
	  {
	    $this->deleteServer();
	  }
	else
	  {
	    $this->goback();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Server
   *
   * Remove this Server from the database
   */
  function deleteServer()
  {
    // Delete Server
    delete_ServerDBO( $this->get['server'] );

    // Success!
    $this->setMessage( array( "type" => "[SERVER_DELETED]",
			      "args" => array( $this->session['server_dbo']->getHostName() ) ) );
    $this->goto( "services_servers" );
  }
}
?>