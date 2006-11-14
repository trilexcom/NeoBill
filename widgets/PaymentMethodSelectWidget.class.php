<?php
/**
 * PaymentMethodSelectWidget.class.php
 *
 * This file contains the definition of the PaymentMethodSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PaymentMethodSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentMethodSelectWidget extends SelectWidget
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

    $registry = ModuleRegistry::getModuleRegistry();
    $modules = array_merge( $registry->getModulesByType( "payment_gateway" ),
			    $registry->getModulesByType( "payment_processor" ) );

    $methods = array();
    foreach( $modules as $modulename => $module )
      {
	if( $module->isEnabled() )
	  {
	    $methods[$modulename] = $module->getShortDescription();
	  }
      }

    if( $conf['order']['accept_checks'] )
      {
	$methods['Check'] = "[CHECK_OR_MONEY_ORDER]";
      }

    return $methods;
  }
}
?>