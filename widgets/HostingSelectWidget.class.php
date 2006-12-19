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
    $hostings = array();
    try
      {
	// Convery to an array: hosting ID => hosting service name
	$hostingDBOs = load_array_HostingServiceDBO();
	foreach( $hostingDBOs as $hostingDBO )
	  {
	    $hostings[$hostingDBO->getID()] = $hostingDBO->getTitle();
	  }
      }
    catch( DBNoRowsFoundException $e ) {}

    return $hostings;
  }
}
?>