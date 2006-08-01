<?php
/**
 * ViewServerPage.class.php
 *
 * This file contains the definition for the ViewServerPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/ServerDBO.class.php";

/**
 * ViewServerPage
 *
 * Display a Server
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewServerPage extends Page
{
  /**
   * Initialize View Server Page
   *
   * If the server ID is provided in the query string, use it to load the ServerDBO
   * from the database, then store the DBO in the session.  Otherwise, use the DBO
   * already there.
   */
  function init()
  {
    if( isset( $this->session['template'] ) )
      {
	$this->setTemplate( $this->session['template'] );
      }

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
   *   info
   *   ips
   *   delete_ip
   *   view_server_add_ip (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "info":
	$this->session['template'] = "default";
	$this->setTemplate( "default" );
	break;

      case "ips":
	$this->session['template'] = "ips";
	$this->setTemplate( "ips" );
	break;

      case "services":
	$this->session['template'] = "services";
	$this->setTemplate( "services" );
	break;

      case "delete_ip":
	$this->deleteIP();
	break;

      case "view_server":
	if( isset( $this->session['view_server']['edit'] ) )
	  {
	    $this->goto( "services_edit_server",
			 null,
			 "id=" . $this->session['server_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_server']['delete'] ) )
	  {
	    $this->goto( "services_delete_server",
			 null,
			 "id=" . $this->session['server_dbo']->getID() );
	  }
	break;

      case "view_server_add_ip":
	if( isset( $this->session['view_server_add_ip']['add'] ) )
	  {
	    $this->goto( "services_add_ip", 
			 null, 
			 "serverid=" . $this->session['server_dbo']->getID() );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete IP Address
   *
   * Removes an IPAddress from this Server
   */
  function deleteIP()
  {
    if( $_SESSION['client']['userdbo']->getType() != "Administrator" )
      {
	$this->setError( array( "type" => "ACCESS_DENIED" ) );
	return;
      }

    // Verify the IP address and convert it to a long integer
    if( !isset( $_GET['ip'] ) )
      {
	return;
      }
    $ip_string = form_field_filter( null, $_GET['ip'] );
    $ip = ip2long( $ip_string );
    if( ($ip_dbo = load_IPAddressDBO( $ip )) == null )
      {
	fatal_error( "ViewServerPage::deleteIP()",
		     "that IP address does not exist: " . $ip_string );
      }

    // Verify that this IP address is not being used
    if( !$ip_dbo->isAvailable() )
      {
	// Can not delete IP until it is free
	$this->setError( array( "type" => "IP_NOT_FREE",
				"args" => array( $ip_string ) ) );
	$this->setTemplate( "ips" );
	return;
      }

    // Remove the IP address from the database
    if( !delete_IPAddressDBO( $ip_dbo ) )
      {
	// Database error
	$this->setError( array( "type" => "DB_DELETE_IP_FAILED",
				"args" => array( $ip_string ) ) );
	return;
      }

    // Success
    $this->setMessage( array( "type" => "IP_DELETED",
			      "args" => array( $ip_string ) ) );
    $this->setTemplate( "ips" );
  }

}

?>