<?php
/**
 * FieldSizeException.class.php
 *
 * This file contains the definition of the FieldSizeException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * FieldSizeException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FieldSizeException extends FieldException
{
  const LONG_MESSAGE = '[PLEASE_ENTER_A_VALUE_SHORTER_THAN] %d [CHARACTERS_FOR] %s.';
  const SHORT_MESSAGE = '[PLEASE_ENTER_A_VALUE_LONGER_THAN] %d [CHARACTERS_FOR] %s.';

  /**
   * @var integer Length of the user's data
   */
  private $length = null;

  /**
   * @var integer Maximum allowed length
   */
  private $max = null;

  /**
   * @var integer Minimum allowed length
   */
  private $min = null;

  /**
   * FieldSizeException Constructor
   *
   * @param integer Length of the data entered by the user
   * @param integer Minimum length of field
   * @param integer Maximum length of field
   */
  public function __construct( $length, $min, $max )
  {
    parent::__construct();
    
    $this->length = $length;
    $this->min = $min == null ? 0 : $min;
    $this->max = $max == null ? 0 : $max;
  }

  /**
   * Error Message String
   *
   * @return string An error message that can be displayed to the user
   */
  public function __toString()
  {
    if( $this->length < $this->min )
      {
	return sprintf( self::SHORT_MESSAGE, $this->min, $this->field );
      }
    else
      {
	return sprintf( self::LONG_MESSAGE, $this->max, $this->field );
      }
  }
}