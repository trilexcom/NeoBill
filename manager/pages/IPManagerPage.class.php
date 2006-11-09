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

require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/IPAddressDBO.class.php";

/**
 * IPManagerPage
 *
 * IP Address Management page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IPManagerPage extends SolidStatePage
{
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
      case "ippool":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->deleteIP();
	  }
	break;

      case "search_ips":
	$this->searchTable( "ippool", "ipaddresses", $this->post );
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
	$this->reload();
      }

    foreach( $this->post['ipaddresses'] as $IPDBO )
      {
	// Verify that this IP address is not being used
	if( !$IPDBO->isAvailable() )
	  {
	    // Can not delete IP until it is free
	    $this->setError( array( "type" => "IP_NOT_FREE",
				    "args" => array( $IPDBO->getIPString() ) ) );
	    $this->reload();
	  }
	
	// Remove the IP address from the database
	if( !delete_IPAddressDBO( $IPDBO ) )
	  {
	    // Database error
	    $this->setError( array( "type" => "DB_DELETE_IP_FAILED",
				    "args" => array( $IPDBO->getIPString() ) ) );
	    $this->reload();
	  }
	
	// Success
	$this->setMessage( array( "type" => "IP_DELETED",
				  "args" => array( $IPDBO->getIPString() ) ) );
      }
  }
}
?>