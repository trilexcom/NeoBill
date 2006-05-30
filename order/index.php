<?php
/**
 * index.php
 *
 * This file controls the SolidState Order interface
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Load config file
require_once "../config.inc.php";

// Load SolidWorks
require_once $base_path . "solidworks/solidworks.php";

// Some last minute configuration
$order_conf['xmlrpc'] = $order_conf['url'] . "/xmlrpc/server.php";

// Load settings from the remote server
$client = new IXR_Client( $order_conf['xmlrpc'] );
if( !$client->query( "config.load_OrderSettings", 
		     "orders", 
		     md5( $order_conf['remote_password'] ) ) )
{
  fatal_error( "load_OrderSettings", 
	       "XMLRPC error: " . $client->getErrorMessage() );
}

if( $client->getResponse() == "Access Denied" )
{
  fatal_error( "load_OrderSettings",
	       "Access was denied by the SolidState Server" );
  session_destory();
}

$conf = array_merge( $conf, $client->getResponse(), $order_conf );

// Hand off to SolidWorks
solidworks( $conf, $smarty );
?>
