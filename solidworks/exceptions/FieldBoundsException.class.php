<?php
/**
 * FieldBoundsException.class.php
 *
 * This file contains the definition of the FieldBoundsException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * FieldBoundsException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FieldBoundsException extends FieldException
{
  const LARGE_MESSAGE = '[PLEASE_ENTER_A_VALUE_LESS_THAN] %d [FOR] %s.';
  const SMALL_MESSAGE = '[PLEASE_ENTER_A_VALUE_GREATER_THAN] %d [FOR] %s.';

  /**
   * @var float User's value
   */
  private $userValue = null;

  /**
   * @var float Maximum allowed value
   */
  private $max = null;

  /**
   * @var float Minimum allowed value
   */
  private $min = null;

  /**
   * FieldBoundsException Constructor
   *
   * @param float Value entered by the user
   * @param float Minimum value
   * @param float Maximum value
   */
  public function __construct( $userValue, $min, $max )
  {
    parent::__construct();
    
    $this->userValue = $userValue;
    $this->min = $min;
    $this->max = $max;
  }

  /**
   * Error Message String
   *
   * @return string An error message that can be displayed to the user
   */
  public function __toString()
  {
    if( $this->userValue < $this->min )
      {
	return sprintf( self::SMALL_MESSAGE, $this->min, $this->field );
      }
    else
      {
	return sprintf( self::LARGE_MESSAGE, $this->max, $this->field );
      }
  }
}
?>