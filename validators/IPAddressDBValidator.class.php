<?php
/**
 * IPAddressDBValidator.class.php
 *
 * This file contains the definition of the IPAddressDBValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * IPAddressDBValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IPAddressDBValidator extends FieldValidator {
	/**
	 * Validate an IP Address using the Database
	 *
	 * Verifies that the IP address exists in the database
	 *
	 * @param string $data Field data
	 * @return IPAddressDBO IPAddress DBO for this IP
	 * @throws RecordNotFoundException
	 */
	public function validate( $data ) {
		$data = parent::validate( $data );

		try {
			$ipAddressDBO = load_IPAddressDBO( intval( $data ) );
		}
		catch ( DBNoRowsFoundException $e ) {
			throw new RecordNotFoundException( "IPAddress" );
		}

		return $ipAddressDBO;
	}
}
?>