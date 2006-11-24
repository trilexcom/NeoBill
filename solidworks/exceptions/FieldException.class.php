<?php
/**
 * FieldException.class.php
 *
 * This file contains the definition of the FieldException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * FieldException
 *
 * Field exception's are thrown by the FormProcessor's validation engine whenever
 * it encounters an invalid field.  This is a generic exception and only conrete
 * children of this class should be thrown.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FieldException extends SWUserException
{
  const MESSAGE = 'The %s field is invalid (contents: %s).';

  /**
   * @var string The name of the invalid field
   */
  protected $field = "undefined";

  /**
   * @var string The internal error message for this exception
   */
  protected $message = "Invalid Field";

  /**
   * @var string The value of the invalid field
   */
  protected $value = "undefined";

  /**
   * FieldException Constructor
   */
  public function __construct( $message = null )
  {
    parent::__construct();

    if( isset( $message ) )
      {
	$this->message = $message;
      }
  }

  /**
   * Error Message String
   *
   * @return string An error message that can be displayed to the user
   */
  public function __toString() 
  { 
    return sprintf( self::MESSAGE, $this->getField(), $this->getValue() );
  }

  /**
   * Get Field
   *
   * @return string The name of the invalid field
   */
  public function getField() { return $this->field; }

  /**
   * Get Value
   *
   * @return string Field contents
   */
  public function getValue() { return $this->value; }

  /**
   * Set Field
   *
   * @param string $field Field name
   */
  public function setField( $field ) { $this->field = $field; }

  /**
   * Set Field Value
   *
   * @param string $value Field value
   */
  public function setValue( $value ) { $this->value = $value; }
}
?>