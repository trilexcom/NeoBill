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

require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * AddServerPage
 *
 * Add Server Page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddServerPage extends SolidStateAdminPage
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
      case "add_server":
	if( isset( $this->post['continue'] ) )
	  {
	    $this->add_server();
	  }
	elseif( isset( $this->post['cancel'] ) )
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
   * Add Server
   *
   * Create a new ServerDBO and store it in the database
   */
  function add_server()
  {
    // Create a new Server DBO
    $server_dbo = new ServerDBO();
    $server_dbo->setHostName( $this->post['hostname'] );
    $server_dbo->setLocation( $this->post['location'] );

    // Add ServerDBO to database
    if( !add_ServerDBO( $server_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_ADD_SERVER_FAILED" ) );
	$this->goback();
      }

    // Success
    $this->setMessage( array( "type" => "SERVER_ADDED" ) );
    $this->goto( "services_view_server",
		 null,
		 "server=" . $server_dbo->getID() );
  }
}
?>