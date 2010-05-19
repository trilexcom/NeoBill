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

/**
 * PaymentModuleSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentModuleSelectWidget extends SelectWidget {
	/**
	 * Get Data
	 *
	 * @param array $config Field configuration
	 * @return array value => description
	 */
	public function getData() {
		$registry = ModuleRegistry::getModuleRegistry();
		$modules = $registry->getModulesByType( "payment_gateway" );
		$paymentModules = array();
		foreach ( $modules as $modulename => $module ) {
			if ( $module->isEnabled() ) {
				$paymentModules[$modulename] = $modulename;
			}
		}
		
		return $paymentModules;
	}
}
?>