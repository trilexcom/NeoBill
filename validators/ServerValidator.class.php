<?php
/**
 * ServerValidator.class.php
 *
 * This file contains the definition of the ServerValidator class.  
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

// Server DBO
require_once BASE_PATH . "DBO/ServerDBO.class.php";

/**
 * ServerValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServerValidator extends FieldValidator
{
  /**
   * Validate a Server ID
   *
   * Verifies that the server exists.
   *
   * @param string $data Field data
   * @return ServerDBO Server DBO for this Server ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($serverDBO = load_ServerDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "Server" );
      }

    return $serverDBO;
  }
}
?>