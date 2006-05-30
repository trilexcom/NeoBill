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
require_once $base_path . "solidworks/AdminPage.class.php";

require_once $base_path . "DBO/ServerDBO.class.php";

/**
 * DeleteServerPage
 *
 * Delete a Server
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteServerPage extends AdminPage
{
  /**
   * Initialize Delete Server Page
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

    if( $this->session['server_dbo']->getPurchases() != null )
      {
	// Can not delete Server until all purchases are removed
	$this->setError( array( "type" => "SERVER_NOT_FREE" ) );
	$this->cancel();
      }
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
	if( isset( $this->session['delete_server']['delete'] ) )
	  {
	    $this->deleteServer();
	  }
	else
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
   * Delete Server
   *
   * Remove this Server from the database
   */
  function deleteServer()
  {
    if( $this->session['server_dbo']->getPurchases() != null )
      {
	// Can not delete Server until all purchases are removed
	$this->setError( array( "type" => "SERVER_NOT_FREE" ) );
	$this->cancel();
      }

    // Delete all IP Addresses
    if( ($ip_dbo_array = $this->session['server_dbo']->getIPAddresses() ) != null )
      {
	foreach( $ip_dbo_array as $ip_dbo )
	  {
	    if( !delete_IPAddressDBO( $ip_dbo ) )
	      {
		$this->setError( array( "type" => "DB_DELETE_IP_FAILED",
					"args" => array( $ip_dbo->getIPString() ) ) );
		$this->cancel();
	      }
	  }
      }

    // Delete Server
    if( !delete_ServerDBO( $this->session['server_dbo'] ) )
      {
	$this->setError( array( "type" => "DB_DELETE_SERVER_FAILED" ) );
	$this->cancel();
      }

    // Success!
    $this->setMessage( array( "type" => "SERVER_DELETED",
			      "args" => array( $this->session['server_dbo']->getHostName() ) ) );
    $this->goto( "services_servers" );
  }

  /**
   * Cancel
   */
  function cancel()
  {
    // Return to the view server page
    $this->goto( "services_view_server",
		 null,
		 "id=" . $this->session['server_dbo']->getID() );
  }
}

?>
