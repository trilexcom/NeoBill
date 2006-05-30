<?php
/**
 * IPManagerPage.class.php
 *
 * This file contains the definition for the IPManagerPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/IPAddressDBO.class.php";

/**
 * IPManagerPage
 *
 * IP Address Management page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IPManagerPage extends Page
{
  /**
   * Initialize IPManager Page
   */
  function init()
  {

  }

  /**
   * Action
   *
   * Actions handled by this page:
   *  remove_ip
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "remove_ip":
	$this->deleteIP();
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete IP Address
   *
   * Removes an IPAddress
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
	fatal_error( "IPManagerPage::deleteIP()", 
		     "error, that IP address does not exist: " . $ip_string );
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
  }
}
?>
