<?php
/**
 * RecordNotFoundException.class.php
 *
 * This file contains the definition of the RecordNotFoundException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/exceptions/FieldException.class.php";

/**
 * RecordNotFoundException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RecordNotFoundException extends FieldException
{
  const MESSAGE = '%s [RECORD_NOT_FOUND]';

  /**
   * @var string Record type
   */
  private $recordType = "Undefined";

  /**
   * RecordNotFoundException Constructor
   */
  public function __construct( $recordType )
  {
    parent::__construct();
    $this->recordType = $recordType;
  }

  /**
   * Error Message String
   *
   * @return string An error message that can be displayed to the user
   */
  public function __toString()
  {
    return sprintf( self::MESSAGE, $this->recordType );
  }
}
?>