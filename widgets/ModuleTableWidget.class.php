<?php
/**
 * ModuleTableWidget.class.php
 *
 * This file contains the definition of the ModuleTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

/**
 * ModuleTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModuleTableWidget extends TableWidget
{
  /**
   * Determine Widget Value
   *
   * Determines the correct source to use for the value of this widget.
   * The order goes like this:
   *   1. The enabled/disabled status of the module
   *
   * @param array $params Paramets passed from the template
   * @throws SWException
   * @return string The value to use
   */
  protected function determineValue( $params )
  {
    global $conf;

    if( null == ($module = $conf['modules'][$params['option']]) )
      {
	return null;
      }

    // 2. No value
    $value = null;

    // Checkbox will show as checked whenever "option" == "value"
    // 1. Enabled/Disabled
    $value = $module->isEnabled() ? $module->getName() : $value;

    return $value;
  }

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    global $conf;

    parent::init( $params );

    // Build the table
    foreach( $conf['modules'] as $modulename => $module )
      {
	// Put the row into the table
	$this->data[] = 
	  array( "name" => $modulename,
                 "configpage" => $module->getConfigPage(),
		 "type" => $module->getType(),
		 "description" => $module->getDescription() );
      }
  }
}