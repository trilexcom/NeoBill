<?php
/**
 * InvalidTelephoneException.class.php
 *
 * This file contains the definition of the InvalidTelephoneException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/exceptions/FieldException.class.php";

/**
 * InvalidTelephoneException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvalidTelephoneException extends FieldException
{
  const MESSAGE = '[PLEASE_ENTER_A_VALID_TELEPHONE_NUMER_FOR] %s.  [TELEPHONE_NUMBERS_MUST_BE]';

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