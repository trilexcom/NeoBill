<?php
/**
 * server.php
 *
 * This file contains the XML-RPC server
 *
 * @package XMLRPC
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the Incutio XML-RPC Library
require_once "IXR.php";

// Load configuration
require_once "../config.inc.php";
require_once $base_path . "solidworks/configuration.php";
require_once $base_path . "util/settings.php";

// Load DBO's
require_once $base_path . "DBO/DomainServiceDBO.class.php";
require_once $base_path . "DBO/HostingServiceDBO.class.php";
require_once $base_path . "DBO/TaxRuleDBO.class.php";
require_once $base_path . "DBO/OrderDBO.class.php";

// Load all settings
load_settings( $conf );

// Define a mapping of XML-RPC calls and real functions
$map = array( "config.load_OrderSettings" => "load_OrderSettings_RPCServer",
	      "db.load_DomainServiceDBO" => "load_DomainServiceDBO_RPCServer", 
	      "db.load_array_DomainServiceDBO" => "load_array_DomainServiceDBO_RPCServer",
	      "db.getDomainServices" => "getDomainServicesServer",
	      "db.getDomainService" => "getDomainServiceServer",
	      "db.getHostingServices" => "getHostingServicesServer",
	      "db.getHostingService" => "getHostingServiceServer",
	      "order.calculateTaxOnOrder" => "calculateTaxOnOrderServer" );

// Create the XML-RPC server
$server = new IXR_Server( $map );

/**
 * Calculate Tax on Order
 *
 * Calculates tax owed on an OrderDBO
 *
 * @param string $params[0] Remote Username
 * @param string $params[1] Remote Password
 * @param OrderDBO $params[2] Order DBO
 * @return OrderDBO Order with tax fields populated
 */
function calculateTaxOnOrderServer( $params )
{
  global $DB;

  // Verify the request is from the Order interface
  if( !verify_remote_order( $params[0], $params[1] ) )
    {
      // Access denied
      return 0;
    }

  $orderdbo = unserialize( $params[2] );

  // Get all applicable taxes for the customers residence
  $filter = 
    "country=" . $DB->quote_smart( $orderdbo->getCountry() ) . " AND (" .
    "allstates=" . $DB->quote_smart( "YES" ) . " OR " .
    "state=" . $DB->quote_smart( $orderdbo->getState() ) . ")";
  $taxruledbo_array = load_array_TaxRuleDBO( $filter );

  foreach( $orderdbo->orderitems as $orderitemdbo )
    {
      if( $orderitemdbo->isTaxable() )
	{
	  // Calculate and add up all the tax rules that apply
	  $tax_amount = 0.00;
	  foreach( $taxruledbo_array as $taxruledbo )
	    {
	      $rate = $taxruledbo->getRate() / 100.00;
	      $tax_amount += 
		($orderitemdbo->getPrice() * $rate) + 
		($orderitemdbo->getSetupFee() * $rate);
	    }
	  $orderitemdbo->setTaxAmount( $tax_amount );
	}
    }

  return serialize( $orderdbo );
}

/**
 * Get Domain Services (XMLRPC Server)
 *
 * @param string $params[0] Remote Username
 * @param string $params[1] Remote Password
 * @return mixed DomainServiceDBO array or False on error
 */
function getDomainServicesServer( $params )
{
  if( $params[0] == "orders" )
    {
      // Verify the request is from the Order interface
      if( !verify_remote_order( $params[0], $params[1] ) )
	{
	  return false;
	}

      return serialize( load_array_DomainServiceDBO() );
    }

  return false;
}

/**
 * Get Domain Service (XMLRPC Server)
 *
 * @param string $params[0] Remote Username
 * @param string $params[1] Remote Password
 * @param string $params[2] TLD
 * @return mixed DomainServiceDBO array or False on error
 */
function getDomainServiceServer( $params )
{
  if( $params[0] == "orders" )
    {
      // Verify the request is from the Order interface
      if( !verify_remote_order( $params[0], $params[1] ) )
	{
	  return false;
	}

      return serialize( load_DomainServiceDBO( $params[2] ) );
    }

  return false;
}

/**
 * Get Hosting Services (XMLRPC Server)
 *
 * @param string $params[0] Remote Username
 * @param string $params[1] Remote Password
 * @return mixed HostingServiceDBO array or False on error
 */
function getHostingServicesServer( $params )
{
  if( $params[0] == "orders" )
    {
      // Verify the request is from the Order interface
      if( !verify_remote_order( $params[0], $params[1] ) )
	{
	  return false;
	}

      return serialize( load_array_HostingServiceDBO() );
    }

  return false;
}

/**
 * Get Hosting Service (XMLRPC Server)
 *
 * @param string $params[0] Remote Username
 * @param string $params[1] Remote Password
 * @param integer $params[2] Hosting Service ID
 * @return mixed HostingServiceDBO array or False on error
 */
function getHostingServiceServer( $params )
{
  if( $params[0] == "orders" )
    {
      // Verify the request is from the Order interface
      if( !verify_remote_order( $params[0], $params[1] ) )
	{
	  return false;
	}

      return serialize( load_HostingServiceDBO( intval( $params[2] ) ) );
    }

  return false;
}

/**
 * Verify Remote Order Interface
 *
 * @param string $username Username
 * @param string $password Password (md5)
 * @return boolean False for Access Denied
 */
function verify_remote_order( $username, $password )
{
  global $conf;

  return ($username == "orders" && $password == $conf['order']['remote_password'] );
}

?>
