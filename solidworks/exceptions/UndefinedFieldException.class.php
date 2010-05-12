<?php
/**
 * UndefinedFieldException.class.php
 *
 * This file contains the definition of the UndefinedFieldException class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * UndefinedFieldException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class UndefinedFieldException extends FieldException {
	/**
	 * @var string Error Message
	 */
	protected $message = "The %s field is undefined and was ignored (contents: %s).";
}
?>