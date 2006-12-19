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
    $servers = array();
    try
      {
	// Convery to an array: hosting ID => hosting service name
	$serverDBOs = load_array_ServerDBO();
	foreach( $serverDBOs as $serverDBO )
	  {
	    $servers[$serverDBO->getID()] = $serverDBO->getHostname();
	  }
      }
    catch( DBNoRowsFoundException $e ) {}

    return $servers;
  }
}
?>