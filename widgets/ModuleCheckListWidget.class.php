<?php
/**
 * ModuleCheckListWidget.class.php
 *
 * This file contains the definition of the ModuleCheckListWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/CheckBoxWidget.class.php";

/**
 * ModuleCheckListWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModuleCheckListWidget extends CheckBoxWidget
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
    global $page, $conf;

    if( null == ($module = $conf['modules'][$params['option']]) )
      {
	return null;
      }

    // Access the session
    $session =& $page->getPageSession();

    // 2. No value
    $value = null;

    // Checkbox will show as checked whenever "option" == "value"
    // 1. Enabled/Disabled
    $value = $module->isEnabled() ? $module->getName() : $value;

    return $value;
  }
}
?>