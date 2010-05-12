<?php
/**
 * InvalidFormException.class.php
 *
 * This file contains the definition of the InvalidFormException class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * InvalidFormException
 *
 * Thrown by FormProcessor whenever a form fails to validate.  While processing the
 * form, one or more FieldException's may have been gereated.  They are stored in
 * an InvalidFormException and it is thrown.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvalidFormException extends SWException {
	/**
	 * @var string Error message
	 */
	protected $message = "Invalid Form:";

	/**
	 * @var array An array of FieldExceptions
	 */
	private $fieldExceptions = array();

	/**
	 * @var array Form data
	 */
	private $formData = array();

	/**
	 * InvalidFormException Constructor
	 *
	 * Constructs a new InvalidFormException.
	 *
	 * @param FieldException $fieldExceptions Field exceptions generated for this form (there must be at least 1)
	 */
	public function __construct( $fieldExceptions, $formData ) {
		$this->fieldExceptions = $fieldExceptions;
		$this->formData = $formData;

		// Build error message
		foreach( $this->fieldExceptions as $exception ) {
			$this->message .= "\n\t" . $exception->__toString();
		}
	}

	/**
	 * Get Field Exceptions
	 *
	 * @return array Field Exceptions
	 */
	public function getFieldExceptions() {
		return $this->fieldExceptions;
	}

	/**
	 * Get Form Data
	 *
	 * @return array Form Data
	 */
	public function getFormData() {
		return $this->formData;
	}
}
?>