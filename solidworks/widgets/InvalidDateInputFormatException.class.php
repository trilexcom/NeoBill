<?php
/**
 * InvalidDateInputFormatException.class.php
 *
 * This file contains the definition of the InvalidDateInputFormatException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/SWException.class.php";

/**
 * InvalidDateInputFormatException
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvalidDateInputFormatException extends SWException
{
  /**
   * Invalid Date Input Format Exception Constructor
   *
   * @param string $format The invalid format
   */
  public function __construct( $format = "NULL" )
  {
    parent::__construct();
    $this->message = sprintf( "Invalid date-input format: %s", $format );
  }
}
?>