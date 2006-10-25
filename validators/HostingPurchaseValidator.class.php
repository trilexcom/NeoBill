<?php
/**
 * HostingPurchaseValidator.class.php
 *
 * This file contains the definition of the HostingPurchaseValidator class.  
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

// HostingPurchase DBO
require_once BASE_PATH . "DBO/HostingServicePurchaseDBO.class.php";

/**
 * HostingPurchaseValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingPurchaseValidator extends FieldValidator
{
  /**
   * Validate a Hosting Service Purchase ID
   *
   * Verifies that the server exists.
   *
   * @param array $config Field configuration
   * @param string $data Field data
   * @return HostingServicePurchaseDBO Purchase DBO for this HostingServicePurchase ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($purchaseDBO = load_HostingServicePurchaseDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "HostingPurchase" );
      }

    return $purchaseDBO;
  }
}
?>