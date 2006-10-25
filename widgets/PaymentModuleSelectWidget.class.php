<?php
/**
 * PaymentModuleSelectWidget.class.php
 *
 * This file contains the definition of the PaymentModuleSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// DOMAINTERM Service DBO
require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

/**
 * PaymentModuleSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentModuleSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  public function getData()
  {
    global $conf;

    $modules = array();
    foreach( $conf['modules'] as $modulename => $module )
      {
	if( $module->isEnabled() && $module->getType() == "payment_gateway" )
	  {
	    $modules[$modulename] = $modulename;
	  }
      }

    return $modules;
  }
}
?>