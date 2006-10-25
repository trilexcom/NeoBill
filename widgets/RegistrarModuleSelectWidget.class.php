<?php
/**
 * RegistrarModuleSelectWidget.class.php
 *
 * This file contains the definition of the RegistrarModuleSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// Module DBO
require_once BASE_PATH . "DBO/ModuleDBO.class.php";

/**
 * RegistrarModuleSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RegistrarModuleSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  function getData()
  {
    $moduleNames = array();
    if( ($registrarModules = 
	 load_array_ModuleDBO( "type='registrar' AND enabled='Yes'" ) ) != null )
      {
	foreach( $registrarModules as $moduleDBO )
	  {
	    // Add this module to the list
	    $moduleNames[$moduleDBO->getName()] = $moduleDBO->getShortDescription();
	  }
      }
    else
      {
	// No registrar modules found
	$moduleNames[] = "[NO_REGISTRAR_MODULES]";
      }

    return $moduleNames;
  }
}
?>