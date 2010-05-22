<?php
/**
 * PasswordValidator.class.php
 *
 * This file contains the definition of the PasswordValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PasswordValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PasswordValidator extends TextValidator {
	/**
	 * Validate a Password Field
	 *
	 * A password field is the same as a text except that the data is returned as
	 * a MD5 hash.
	 *
	 * @param string $data Field data
	 * @return string Data in MD5 form
	 * @throws FieldException, FieldSizeException
	 */
	public function validate( $data ) {
		return md5( parent::validate( $data ) );
	}
}
?>