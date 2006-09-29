<?php
/**
 * AddIPAddressPage.class.php
 *
 * This file contains the definition for the AddIPAddressPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "solidworks/AdminPage.class.php";

require_once BASE_PATH . "DBO/ServerDBO.class.php";
require_once BASE_PATH . "DBO/IPAddressDBO.class.php";

/**
 * AddIPAddressPage
 *
 * Add IP Addresses Page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddIPAddressPage extends AdminPage
{
  /**
   * Initialize AddIPAddress Page
   */
  function init()
  {
    $id = $_GET['serverid'];

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
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *  add_ip_address (form)
   *  add_ip_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "add_ip_address":
	if( isset( $this->session['add_ip_address']['continue'] ) )
	  {
	    // Confirm step
	    $this->confirm();
	  }
	else
	  {
	    $this->cancel();
	  }
	break;

      case "add_ip_confirm":
	if( isset( $this->session['add_ip_confirm']['continue'] ) )
	  {
	    // Add IP addresses
	    $this->add_ip_addresses();
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
   * Cancel
   *
   * Return to the IP Manager Page
   */
  function cancel()
  {
    $this->goto( "services_view_server",
		 null,
		 "id=" . $this->session['server_dbo']->getID() . "&action=ips");
  }

  /**
   * Confirm
   *
   * Verify that the IP's do not already exist in the pool, then confirm 
   * the new IP address with the user before continuing.
   */
  function confirm()
  {
    $begin_ip = $this->session['add_ip_address']['begin_address'];
    $end_ip = $this->session['add_ip_address']['end_address'];
 
    if( $end_ip == 0 || $end_ip < $begin_ip )
      {
	// If the beginning IP is not less than the ending IP, then only the
	// beginning IP is going to be added to the database.
	$end_ip = $begin_ip;
      }

    // Verify that there will be no duplicates
    for( $ip = $begin_ip; $ip <= $end_ip; $ip++ )
      {
	if( null != load_IPAddressDBO( $ip ) )
	  {
	    $this->setError( array( "type" => "DUPLICATE_IP" ) );
	    return;
	  }
      }

    // Store the IP's to be added to the database in the session
    for( $ip = $begin_ip; $ip <= $end_ip; $ip++ )
      {
	$ip_dbo = new IPAddressDBO();
	$ip_dbo->setIP( $ip );
	$ip_dbo->setServerID( $this->session['server_dbo']->getID() );
	$this->session['ip_dbo_array'][] = $ip_dbo;
      }
    $this->session['begin_ip'] = new IPAddressDBO();
    $this->session['begin_ip']->setIP( $begin_ip );
    $this->session['end_ip'] = new IPAddressDBO();
    $this->session['end_ip']->setIP( $end_ip );

    // Show the confirmation page
    $this->setTemplate( "confirm" );
  }

  /**
   * Add IP Addresses
   *
   * Add the IP addresses to the database
   */
  function add_ip_addresses()
  {
    // Add IP Addresses to database
    foreach( $this->session['ip_dbo_array'] as $ip_dbo )
      {
	if( !add_IPAddressDBO( $ip_dbo ) )
	  {
	    $this->setError( array( "type" => "DB_ADD_IP_FAILED" ) );
	    $this->cancel();
	  }
      }

    // Done
    $this->setMessage( array( "type" => "IP_ADDED" ) );
    $this->cancel();
  }
}
?>