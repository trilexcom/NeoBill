<?php
/**
 * client.php
 *
 * This file contains stubs for accessing the SolidState backend-server over XMLRPC.
 *
 * @package XMLRPC
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the Incutio XML-RPC Library
require_once "IXR.php";

// Load DBO's
require_once $base_path . "DBO/DomainServiceDBO.class.php";
require_once $base_path . "DBO/HostingServiceDBO.class.php";
require_once $base_path . "DBO/OrderDBO.class.php";

/**
 * Calculate Tax on an Order (client)
 *
 * @param string $username Remote username
 * @param string $password Remote password (clear text)
 * @param OrderDBO $orderdbo The Order to calculate tax for
 * @return OrderDBO Order with tax fields populated
 */
function calculateTaxOnOrderClient( $username, $password, $orderdbo )
{
  global $conf;

  $client = new IXR_Client( $conf['xmlrpc'] );
  if( !$client->query( "order.calculateTaxOnOrder", 
		       $username, 
		       md5( $password ),
		       serialize( $orderdbo ) ) )
    {
      fatal_error( "calculateTaxOnOrder()", 
		   "XMLRPC error: " . $client->getErrorMessage() );
    }

  if( !$client->getResponse() )
    {
      fatal_error( "calculateTaxOnOrder()", 
		   "Failed to calculate taxes on order" );
    }

  return unserialize( $client->getResponse() );
}

/**
 * Get Domain Services (XMLRPC Client)
 *
 * @param string $username Remote username
 * @param string $password Remote password (clear text)
 * @return array DomainServiceDBO array
 */
function getDomainServicesClient( $username, $password )
{
  global $conf;

  $client = new IXR_Client( $conf['xmlrpc'] );
  if( !$client->query( "db.getDomainServices", $username, md5( $password ) ) )
    {
      fatal_error( "getDomainServicesClient", "XMLRPC error: " . $client->getErrorMessage() );
    }

  if( !$client->getResponse() )
    {
      fatal_error( "getDomainServicesClient", 
		   "Failed to get Domain Services from the backend server!" );
    }

  return unserialize( $client->getResponse() );
}

/**
 * Get Domain Service (XMLRPC Client)
 *
 * @param string $username Remote username
 * @param string $password Remote password (clear text)
 * @param string $tld TLD
 * @return array DomainServiceDBO array
 */
function getDomainServiceClient( $username, $password, $tld )
{
  global $conf;

  $client = new IXR_Client( $conf['xmlrpc'] );
  if( !$client->query( "db.getDomainService", $username, md5( $password ), $tld ) )
    {
      fatal_error( "getDomainServiceClient", "XMLRPC error: " . $client->getErrorMessage() );
    }

  if( !$client->getResponse() )
    {
      fatal_error( "getDomainServiceClient", 
		   "Failed to get Domain Service from the backend server!" );
    }

  return unserialize( $client->getResponse() );
}

/**
 * Get Hosting Services (XMLRPC Client)
 *
 * @param string $username Remote username
 * @param string $password Remote password (clear text)
 * @return array HostingServiceDBO array
 */
function getHostingServicesClient( $username, $password )
{
  global $conf;

  $client = new IXR_Client( $conf['xmlrpc'] );
  if( !$client->query( "db.getHostingServices", $username, md5( $password ) ) )
    {
      fatal_error( "getHostingServicesClient", "XMLRPC error: " . $client->getErrorMessage() );
    }

  if( !$client->getResponse() )
    {
      fatal_error( "getHostingServicesClient", 
		   "Failed to get Hosting Services from the backend server!" );
    }

  return unserialize( $client->getResponse() );
}

/**
 * Get Hosting Service (XMLRPC Client)
 *
 * @param string $username Remote username
 * @param string $password Remote password (clear text)
 * @param integer $serviceid Hosting Service ID
 * @return array HostingServiceDBO array
 */
function getHostingServiceClient( $username, $password, $serviceid )
{
  global $conf;

  $client = new IXR_Client( $conf['xmlrpc'] );
  if( !$client->query( "db.getHostingService", $username, md5( $password ), $serviceid ) )
    {
      fatal_error( "getHostingServiceClient", "XMLRPC error: " . $client->getErrorMessage() );
    }

  if( !$client->getResponse() )
    {
      fatal_error( "getHostingServiceClient", 
		   "Failed to get Hosting Service from the backend server!" );
    }

  return unserialize( $client->getResponse() );
}

?>
