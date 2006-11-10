<?php
/**
 * TelephoneValidator.class.php
 *
 * This file contains the definition of the TelephoneValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Exceptions
require BASE_PATH . "solidworks/exceptions/InvalidTelephoneException.class.php";

/**
 * TelephoneValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TelephoneValidator extends TextValidator
{
  /**
   * Validate a Telephone Field
   *
   * A telephone numbers may only contain numbers, the following charaters, and a space:
   *   + ( ) -
   * Any other characters will throw an InvalidTelephoneException.  Any of the above
   * characters will be thrown out and the resulting string will be in the following
   * format:
   *  +y-x
   * Where 'y' is the international calling code and 'x' is the phone number.  If
   * there is no '+y' in the string then the international calling code is assumed
   * to be +1 (United States).  If there is a '+y' in the string, it must be followed
   * by either a '-' or a ' ', then a telephone number.
   *
   * @param string $data Field data
   * @return string This function may alter data before validating it, if so this is the result
   * @throws InvalidTelephoneException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );
    $data = $this->validatePhoneNumber( $data );
    return $data;
  }

  /**
   * Validate a Phone Number
   *
   * @param string $data Field data
   * @return string This function may alter data before validating it, if so this is the result
   * @throws InvalidTelephoneException
   */
  protected function validatePhoneNumber( $data )
  {
    // Strip out the international calling code, if there isn't one, set it to 1
    if( ereg( "^\+", $data ) )
      {
	// Extract the CC and verify that it's numerical
	$telComp = preg_split( "/[\s\-]+/", $data );
	$cc = substr( $telComp[0], 1 );
	if( !ctype_digit( $cc ) )
	  {
	    throw new InvalidTelephoneException();
	  }
	$cc = intval( $cc );

	// Remove the CC from the rest of the phone number
	$data = substr( $data, strlen( $telComp[0] ) );
      }
    else
      {
	// If no country code is given, +1 is assumed (US)
	$cc = 1;
      }

    // Remove white space and acceptable characters
    $data = ereg_replace( "([ 	]+)", "", $data );
    $data = eregi_replace("(\(|\)|\-|\+)", "", $data );

    // Verify that the field contains nothing but numbers
    if( !ctype_digit( $data ) )
      {
	throw new InvalidTelephoneException();
      }

    // Combine ICC and phone unmber like so: +icc-xxxxxxxxx
    return sprintf( "+%d-%s", $cc, $data );
  }
}
?>