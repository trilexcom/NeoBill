<?php
/**
 * IPSelectWidget.class.php
 *
 * This file contains the definition of the IPSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * IPSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IPSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @return array value => description
   */
  function getData()
  {
    // Query IPDBO's
    $ipDBOs = load_array_IPAddressDBO();
    if( empty( $ipDBOs ) )
      {
	return array();
      }

    // Convery to an array: hosting ID => hosting service name
    $ips = array();
    foreach( $ipDBOs as $ipDBO )
      {
	$ips[$ipDBO->getIP()] = $ipDBO->getHostnameIP();
      }

    return $ips;
  }
}
?>