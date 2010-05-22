<?php
/**
 * ChoiceValidator.class.php
 *
 * This file contains the definition of the ChoiceValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ChoiceValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ChoiceValidator extends FieldValidator {
	/**
	 * Get Valid Choices
	 *
	 * Returns an array of values that are considered valid for this choice
	 *
	 * @return array An array of valid choices
	 */
	function getValidChoices() {
		// Return the keys from the enum config setting
		return is_array( $this->fieldConfig['enum'] ) ?
				array_keys( $this->fieldConfig['enum'] ) : array();
	}

	/**
	 * Validate a Choice Field
	 *
	 * To be valid, the value submitted must be in the set of acceptable choices.
	 *
	 * @param string $data Field data
	 * @return mixed The value is not altered by this function
	 * @throws InvalidChoiceException
	 */
	public function validate( $data ) {
		return $this->validateChoice( $data );
	}

	/**
	 * Validate Choice
	 *
	 * Uses the dataset returned by getValidChoices() to determine if the data
	 * supplied by the submission is valid.
	 *
	 * @param string $data Field data
	 * @return mixed The value is not altered by this function
	 * @throws InvalidChoiceException
	 */
	protected function validateChoice( $data ) {
		if ( !in_array( $data, $this->getValidChoices() ) ) {
			throw new InvalidChoiceException( $data );
		}

		return $data;
	}
}
?>