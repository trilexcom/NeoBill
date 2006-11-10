<?php
/**
 * IPAddressValidator.class.php
 *
 * This file contains the definition of the IPAddressValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * IPAddressValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IPAddressValidator extends FieldValidator
{
  /**
   * Validate a IPAddress Field
   *
   * Verifies that an IP address is in the form: 255.255.255.255.
   *
   * @param string $data Field data
   * @return string This function may alter data before validating it, if so this is the result
   * @throws FieldException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    $ip = ip2long( $data );
    if( $ip === FALSE || $ip == -1 )
      {
	// Not a valid IP address
	throw new FieldException( "[PLEASE_ENTER_A_VALID_IP_ADDRESS]" );
      }

    return $data;
  }
}
?>