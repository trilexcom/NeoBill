<?php
/**
 * NumberValidator.class.php
 *
 * This file contains the definition of the NumberValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Exceptions
require BASE_PATH . "solidworks/exceptions/FieldNotNumericalException.class.php";
require BASE_PATH . "solidworks/exceptions/FieldBoundsException.class.php";

/**
 * NumberValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NumberValidator extends FieldValidator {
	/**
	 * Validate a Number Field
	 *
	 * A number field must contain only numerical data and may be required to be
	 * within certain bounds.
	 *
	 * @param string $data Field data
	 * @return mixed The value is not altered by this function
	 * @throws FieldNotNumericalException, FieldBoundsException
	 */
	public function validate( $data ) {
		$data = $this->validateIsNumber( $data );
		$data = $this->validateMinValue( $data );
		$data = $this->validateMaxValue( $data );
		return $data;
	}

	/**
	 * Validate Number Field is Numerical
	 *
	 * Verify that the field only contains numerical data
	 *
	 * @param string $data Field data
	 * @return mixed The value is not altered by this function
	 * @throws FieldNotNumericalException
	 */
	protected function validateIsNumber( $data ) {
		if ( !is_numeric( $data ) ) {
			// Not a number
			throw new FieldNotNumericalException();
		}

		return $data;
	}

	/**
	 * Validate Number Field Maximum Value
	 *
	 * Verify that the field does not exceed a maximum value
	 *
	 * @param string $data Field data
	 * @return mixed The value is not altered by this function
	 * @throws FieldBoundsException
	 */
	protected function validateMaxValue( $data ) {
		if ( isset( $this->fieldConfig['max_value'] ) ) {
			// Validate upper bounds
			if ( $data > $this->fieldConfig['max_value'] ) {
				// Too big
				throw new FieldBoundsException( $data, null, $this->fieldConfig['max_value'] );
			}
		}

		return $data;
	}

	/**
	 * Validate Number Field Minimum Length
	 *
	 * Verify that the field meets a minimum value
	 *
	 * @param string $data Field data
	 * @return mixed The value is not altered by this function
	 * @throws FieldBoundsException
	 */
	protected function validateMinValue( $data ) {
		if ( isset( $this->fieldConfig['min_value'] ) ) {
			// Validate lower bounds
			if ( $data < $this->fieldConfig['min_value'] ) {
				// Too small
				throw new FieldBoundsException( $data, $this->fieldConfig['min_value'], null );
			}
		}

		return $data;
	}
}
?>