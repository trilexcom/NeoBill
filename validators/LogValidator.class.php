<?php
/**
 * LogValidator.class.php
 *
 * This file contains the definition of the LogValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/validators/FieldValidator.class.php";

// Exceptions
require_once BASE_PATH . "exceptions/RecordNotFoundException.class.php";

/**
 * LogValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LogValidator extends FieldValidator
{
  /**
   * Validate an Log ID
   *
   * Verifies that the log exists.
   *
   * @param string $data Field data
   * @return LogDBO Log DBO for this Log ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($logDBO = load_LogDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "Log" );
      }

    return $logDBO;
  }
}
?>