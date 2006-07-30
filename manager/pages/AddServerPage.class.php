<?php
/**
 * AddServerPage.class.php
 *
 * This file contains the definition for the AddServerPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once $base_path . "solidworks/AdminPage.class.php";

require_once $base_path . "DBO/ServerDBO.class.php";

/**
 * AddServerPage
 *
 * Add Server Page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddServerPage extends AdminPage
{
  /**
   * Initialize AddServer Page
   */
  function init()
  {

  }

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
      case "add_server":
	if( isset( $this->session['add_server']['continue'] ) )
	  {
	    $this->add_server();
	  }
	elseif( isset( $this->session['add_server']['cancel'] ) )
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
    $this->goto( "services_servers" );
  }

  /**
   * Add Server
   *
   * Create a new ServerDBO and store it in the database
   */
  function add_server()
  {
    // Create a new Server DBO
    $server_dbo = new ServerDBO();
    $server_dbo->setHostName( $this->session['add_server']['hostname'] );
    $server_dbo->setLocation( $this->session['add_server']['location'] );

    // Add ServerDBO to database
    if( !add_ServerDBO( $server_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_ADD_SERVER_FAILED" ) );
	$this->cancel();
      }

    // Success
    $this->setMessage( array( "type" => "SERVER_ADDED" ) );
    $this->goto( "services_view_server",
		 null,
		 "id=" . $server_dbo->getID() );
  }
}

?>