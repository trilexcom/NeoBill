<?php
/**
 * ServerSelectWidget.class.php
 *
 * This file contains the definition of the ServerSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// Server DBO
require_once BASE_PATH . "DBO/ServerDBO.class.php";

/**
 * ServerSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServerSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @return array value => description
   */
  function getData()
  {
    // Query ServerDBO's
    $serverDBOs = load_array_ServerDBO();
    if( empty( $serverDBOs ) )
      {
	return array();
      }

    // Convery to an array: hosting ID => hosting service name
    $servers = array();
    foreach( $serverDBOs as $serverDBO )
      {
	$servers[$serverDBO->getID()] = $serverDBO->getHostname();
      }

    return $servers;
  }
}
?>