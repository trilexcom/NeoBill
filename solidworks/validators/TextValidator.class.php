<?php
/**
 * TextValidator.class.php
 *
 * This file contains the definition of the TextValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/validators/FieldValidator.class.php";

// Exceptions
require_once BASE_PATH . "solidworks/exceptions/FieldSizeException.class.php";

/**
 * TextValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TextValidator extends FieldValidator
{
  /**
   * Validate a Text Field
   *
   * A text field may contain any kind of data.  The only restrictions placed on
   * text data are minimum/maximum lengths (optional).
   *
   * @param string $data Field data
   * @return string This function may alter data before validating it, if so this is the result
   * @throws FieldException, FieldSizeException
   */
  public function validate( $data )
  {
    $data = $this->validateMinLength( $data );
    $data = $this->validateMaxLength( $data );
    return $data;
  }

  /**
   * Validate Text Field Maximum Length
   *
   * Verify that the field meets any maximum length
   *
   * @param string $data Field data
   * @return string This function may alter data before validating it, if so this is the result
   * @throws FieldException, FieldSizeException
   */
  protected function validateMaxLength( $data )
  {
    $len = strlen( $data );

    if( isset( $this->fieldConfig['max_length'] ) )
      {
	// Verify that the field is not too long
	if( $len > $this->fieldConfig['max_length'] )
	  {
	    // Field is too big
	    throw new FieldSizeException( $len, null, $this->fieldConfig['max_length'] );
	  }
      }

    return $data;
  }

  /**
   * Validate Text Field Minimum Length
   *
   * Verify that the field meets any minimum length
   *
   * @param string $data Field data
   * @return string This function may alter data before validating it, if so this is the result
   * @throws FieldException, FieldSizeException
   */
  protected function validateMinLength( $data )
  {
    $len = strlen( $data );

    if( isset( $this->fieldConfig['min_length'] ) )
      {
	// Verify that the field is not too short
	if( $len < $this->fieldConfig['min_length'] )
	  {
	    // Field is too short
	    throw new FieldSizeException( $len, $this->fieldConfig['min_length'], null );
	  }
      }

    return $data;
  }
}
?>