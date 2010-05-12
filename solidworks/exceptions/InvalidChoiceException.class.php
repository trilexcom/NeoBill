<?php
/**
 * InvalidChoiceException.class.php
 *
 * This file contains the definition of the InvalidChoiceException class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * InvalidChoiceException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvalidChoiceException extends FieldException {
	const MESSAGE = '[PLEASE_SELECT_A_VALID_CHOICE_FOR] %s.';

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