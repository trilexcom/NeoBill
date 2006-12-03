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
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/ServerDBO.class.php";

/**
 * ViewServerPage
 *
 * Display a Server
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewServerPage extends SolidStatePage
{
  /**
   * Initialize View Server Page
   */
  function init()
  {
    parent::init();

    // Set URL Field
    $this->setURLField( "server", $this->get['server']->getID() );

    if( isset( $this->session['template'] ) )
      {
	$this->setTemplate( $this->session['template'] );
      }

    // Store Server DBO in session
    $this->session['server_dbo'] =& $this->get['server'];
    
    // Set this page's Nav Vars
    $this->setNavVar( "id",   $this->get['server']->getID() );
    $this->setNavVar( "hostname", $this->get['server']->getHostName() );

    // Setup the IP table
    $ipField = $this->forms['view_server_ips']->getField( "ips" );
    $ipField->getWidget()->setServerID( $this->get['server']->getID() );

    // Setup the Services table
    $hsField = $this->forms['view_server_services']->getField( "services" );
    $hsField->getWidget()->setServerID( $this->get['server']->getID() );

    // Provide the control panel config page
    if( null != ($moduleName = $this->get['server']->getCPModule()) )
      {
	$registry = ModuleRegistry::getModuleRegistry();
	$CPModule = $registry->getModule( $moduleName );
	$this->smarty->assign( "ServerConfigPage", $CPModule->getServerConfigPage() );
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

      case "view_server_ips":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->deleteIP();
	  }
	break;

      case "view_server":
	if( isset( $this->post['edit'] ) )
	  {
	    $this->goto( "services_edit_server",
			 null,
			 "server=" . $this->get['server']->getID() );
	  }
	elseif( isset( $this->post['delete'] ) )
	  {
	    $this->goto( "services_delete_server",
			 null,
			 "server=" . $this->get['server']->getID() );
	  }
	break;

      case "view_server_add_ip":
	if( isset( $this->post['add'] ) )
	  {
	    $this->goto( "services_add_ip", 
			 null, 
			 "server=" . $this->session['server_dbo']->getID() );
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

    foreach( $this->post['ips'] as $ipdbo )
      {
	// Verify that this IP address is not being used
	if( !$ipdbo->isAvailable() )
	  {
	    // Can not delete IP until it is free
	    $this->setError( array( "type" => "IP_NOT_FREE",
				    "args" => array( $ipdbo->getIPString() ) ) );
	    $this->setTemplate( "ips" );
	    $this->reload();
	  }
	
	// Remove the IP address from the database
	if( !delete_IPAddressDBO( $ipdbo ) )
	  {
	    // Database error
	    $this->setError( array( "type" => "DB_DELETE_IP_FAILED",
				    "args" => array( $ipdbo->getIPString() ) ) );
	    $this->reload();
	  }

	$this->setMessage( array( "type" => "IP_DELETED",
				  "args" => array( $ipdbo->getIPString() ) ) );
      }

    // Success
    $this->setTemplate( "ips" );
  }
}

?>