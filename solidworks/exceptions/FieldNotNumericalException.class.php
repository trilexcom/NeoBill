<?php
/**
 * FieldNotNumericalException.class.php
 *
 * This file contains the definition of the FieldNotNumericalException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/exceptions/FieldException.class.php";

/**
 * FieldNotNumericalException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FieldNotNumericalException extends FieldException
{
  const MESSAGE = '[PLEASE_ENTER_A_NUMERIC_VALUE_FOR] %s.';

  /**
   * FieldNotNumericalException Constructor
   */
  public function __construct() { parent::__construct(); }

  /**
   * Error Message String
   *
   * @return string An error message that can be displayed to the user
   */
  public function __toString()
  {
    return sprintf( self::MESSAGE, $this->getField() );
  }
}
?>