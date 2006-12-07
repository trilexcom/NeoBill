<?php
/**
 * FieldMissingException.class.php
 *
 * This file contains the definition of the FieldMissingException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * FieldMissingException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FieldMissingException extends FieldException
{
  const MESSAGE = '[PLEASE_ENTER_A_VALUE_FOR]: %s.';

  /**
   * FieldMissingException Constructor
   */
  public function __construct( $fieldName = null )
  {
    parent::__construct();

    $this->setField( $fieldName );
  }

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