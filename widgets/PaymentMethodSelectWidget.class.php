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

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// DOMAINTERM Service DBO
require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

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

    $methods = array();
    foreach( $conf['modules'] as $modulename => $module )
      {
	if( $module->isEnabled() && 
	    ($module->getType() == "payment_gateway" || 
	     $module->getType() == "payment_processor") )
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