<?php
/**
 * DateValidator.class.php
 *
 * This file contains the definition of the DateValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DateValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CCExpireValidator extends TextValidator {
	/**
	 * Validate a Credit Card Expiration date
	 *
	 * Expects a date in the following format: MM/YY.
	 *
	 * @param string $data Field data
	 * @return int Date as a timestamp value
	 * @throws InvalidDateException
	 */
	public function validate( $data ) {
		$data = parent::validate( $data );

		// Seperate the components of the expiration date
		$components = explode( "/", $data );
		if ( $components[0] == $data ) {
			// Seperator not found
			throw new FieldException();
		}

		// Test the length of the components
		if ( strlen( $components[0] ) > 2 || strlen( $components[1] ) > 2 ) {
			throw new FieldException();
		}

		// Construct a timestamp that is exactly 1 second before midnight on the last
		// day of the expiration month
		$month = intval( $components[0] ) + 1 == 13 ? 1 : intval( $components[0] );
		$year = 2000 + intval( $components[1] );
		$day = 1;
		$expireTS = mktime( 0, 0, 0, $month, $day, $year ) - 1;

		if ( $expiraTS === false || $expireTS == -1 || $expireTS < time() ) {
			// The expire date is either invalid or already past
			throw new FieldException();
		}

		return $data;
	}
}
?>