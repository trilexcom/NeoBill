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
    $registry = ModuleRegistry::getModuleRegistry();
    $modules = $registry->getModulesByType( "registrar" );
    $moduleNames = array();
    foreach( $modules as $modulename => $module )
      {
	if( $module->isEnabled() )
	  {
	    $moduleNames[$modulename] = $module->getShortDescription();
	  }
      }

    return empty( $moduleNames ) ? array( "[NO_REGISTRAR_MODULES]" ) : $moduleNames;
  }
}
?>