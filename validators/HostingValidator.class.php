<?php
/**
 * HostingValidator.class.php
 *
 * This file contains the definition of the HostingValidator class.  
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

// Hosting DBO
require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * HostingValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingValidator extends FieldValidator
{
  /**
   * Validate a Hosting Service ID
   *
   * Verifies that the hosting service exists.
   *
   * @param string $data Field data
   * @return HostingServiceDBO HostingService DBO for this HostingService ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($hostingDBO = load_HostingServiceDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "HostingService" );
      }

    return $hostingDBO;
  }
}
?>