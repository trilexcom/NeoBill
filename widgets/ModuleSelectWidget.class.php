<?php
/**
 * ModuleSelectWidget.class.php
 *
 * This file contains the definition of the ModuleSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ModuleSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModuleSelectWidget extends SelectWidget
{
  /**
   * @var string Type filter
   */
  protected $type = null;

  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  public function getData()
  {
    $registry = ModuleRegistry::getModuleRegistry();

    $modules = isset( $this->type ) ?
      $registry->getModulesByType( $this->type ) :
      $registry->getAllModules();

    $results = array();
    foreach( $modules as $modulename => $module )
      {
	if( $module->isEnabled() )
	  {
	    $results[$modulename] = $modulename;
	  }
      }

    return $results;
  }

  /**
   * Set Type Filter
   *
   * @param string $type Filter the list by this type of module
   */
  public function setType( $type ) { $this->type = $type; }
}
?>