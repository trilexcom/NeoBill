<?php
/**
 * InvalidDateException.class.php
 *
 * This file contains the definition of the InvalidDateException class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * InvalidDateException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvalidDateException extends FieldException {
	const MESSAGE = '[PLEASE_ENTER_A_VALID_DATE_FOR] %s.  [DATES_MUST_BE]';

	/**
	 * Error Message String
	 *
	 * @return string An error message that can be displayed to the user
	 */
	public function __toString() {
		return sprintf( self::MESSAGE, $this->getField() );
	}
}
?>