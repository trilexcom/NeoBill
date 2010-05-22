<?php
/**
 * BooleanValidator.class.php
 *
 * This file contains the definition of the BooleanValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * BooleanValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class BooleanValidator extends NumberValidator {
	/**
	 * Validate a Boolean Field
	 *
	 * @param string $data Field data
	 * @return string This function may alter data before validating it, if so this is the result
	 * @throws FieldException, FieldSizeException
	 */
	public function validate( $data ) {
		return (boolean) $data;
	}
}
?>