<?php
/**
 * HostingSelectWidget.class.php
 *
 * This file contains the definition of the HostingSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// Hosting Service DBO
require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * HostingSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @return array value => description
   */
  function getData()
  {
    // Query HostingServiceDBO's
    $hostingDBOs = load_array_HostingServiceDBO();
    if( empty( $hostingDBOs ) )
      {
	return array();
      }

    // Convery to an array: hosting ID => hosting service name
    $hostings = array();
    foreach( $hostingDBOs as $hostingDBO )
      {
	$hostings[$hostingDBO->getID()] = $hostingDBO->getTitle();
      }

    return $hostings;
  }
}
?>