<?php
/**
 * PaymentMethodValidator.class.php
 *
 * This file contains the definition of the PaymentMethodValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PaymentMethodValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentMethodValidator extends FieldValidator {
	/**
	 * Validate a Payment Method
	 *
	 * To be valid, the payment method must exist and be enabled
	 *
	 * @param string $data Field data
	 * @return mixed The value is not altered by this function
	 * @throws InvalidChoiceException
	 */
	public function validate( $data ) {
		// Check is the only native option
		if ( $data == "Check" ) {
			return $data;
		}

		// Search payment modules
		$registry = ModuleRegistry::getModuleRegistry();
		$modules = array_merge( $registry->getModulesByType( "payment_gateway" ),
				$registry->getModulesByType( "payment_processor" ) );
		foreach ( $modules as $moduleName => $module ) {
			if ( $data == $moduleName && $module->isEnabled() ) {
				return $data;
			}
		}

		// No matches found
		throw new InvalidChoiceException();
	}
}
?>