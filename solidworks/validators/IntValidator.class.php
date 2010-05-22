<?php
/**
 * IntValidator.class.php
 *
 * This file contains the definition of the IntValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * IntValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IntValidator extends NumberValidator {
	/**
	 * Validate an Integer Field
	 *
	 * Integers must be numerical and within the specific range.  Any decimal component
	 * is rounded off (does not generate any error as long as it is within range).
	 *
	 * @param string $data Field data
	 * @return string This function may alter data before validating it, if so this is the result
	 * @throws FieldException, FieldSizeException
	 */
	public function validate( $data ) {
		return intval( parent::validate( $data ) );
	}
}
?>