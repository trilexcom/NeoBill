<?php
/**
 * CCNumberValidator.class.php
 *
 * This file contains the definition of the CCNumberValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * CCNumberValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CCNumberValidator extends TextValidator
{
  /**
   * Validate a Credit Card Number
   *
   * Strips out unwanted characters, then applies a simple length test (13-16
   * digits) and the MOD 10 algorithm.
   *
   * @param string $data Field data
   * @return string Credit card number (digits only)
   * @throws FieldException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    // Strip out unwanted characters
    $data = ereg_replace( "[^0-9]", "", $data );

    // Test the number's length
    if( strlen( $data ) < 13 || strlen( $data ) > 16 )
      {
	throw new FieldException();
      }

    // Apply the MOD 10 algorithm
    $revNumber = strrev( $data );
    $numSum = 0;
    for( $i = 0; $i < strlen( $revNumber ); $i++ )
      {
	$currentNum = substr( $revNumber, $i, 1 );

	// Double every second digit
	$currentNum = ($i % 2 == 1) ? $currentNum * 2 : $currentNum;

	// Add digits of 2-digit numbers together
	if( $currentNum > 9 )
	  {
	    $firstNum = $currentNum % 10;
	    $secondNum = ($currentNum - $firstNum) / 10;
	    $currentNum = $firstNum + $secondNum;
	  }

	$numSum += $currentNum;
      }
    if( $numSum % 10 != 0 )
      {
	// The CC number failed the MOD 10 test
	throw new FieldException();
      }


    return $data;
  }
}
?>