<?php
/**
 * EditServerPage.class.php
 *
 * This file contains the definition for the EditServerPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/AdminPage.class.php";

require_once $base_path . "DBO/ServerDBO.class.php";

/**
 * EditServerPage
 *
 * Edit Server info.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditServerPage extends AdminPage
{
  /**
   * Initialize Edit Server Page
   *
   * If the server ID is provided in the query string, use it to load the ServerDBO
   * from the database, then store the DBO in the session.  Otherwise, use the DBO
   * already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Server from the database
	$dbo = load_ServerDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['server_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Server
	$this->setError( array( "type" => "DB_SERVER_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store Server DBO in session
	$this->session['server_dbo'] = $dbo;

	// Set this page's Nav Vars
	$this->setNavVar( "id",   $dbo->getID() );
	$this->setNavVar( "hostname", $dbo->getHostName() );
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_server (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_server":
	if( isset( $this->session['edit_server']['save'] ) )
	  {
	    $this->save();
	  }
	elseif( isset( $this->session['edit_server']['cancel'] ) )
	  {
	    $this->cancel();
	  }

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
    $this->goto( "services_view_server",
		 null,
		 "id=" . $this->session['server_dbo']->getID() );
  }

  /**
   * Save
   *
   * Store the changes in the database
   */
  function save()
  {
    // Update the ServerDBO
    $server_dbo = $this->session['server_dbo'];
    $server_dbo->setLocation( $this->session['edit_server']['location'] );
    $server_dbo->setHostName( $this->session['edit_server']['hostname'] );

    // Save changes in the database
    if( !update_ServerDBO( $server_dbo ) )
      {
	$this->setError( array( "type" => "DB_SERVER_UPDATE_FAILED" ) );
	$this->cancel();
      }

    // Success
    $this->setMessage( array( "type" => "SERVER_UPDATED" ) );
    $this->cancel();
  }
}

?>
