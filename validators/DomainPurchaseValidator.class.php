<?php
/**
 * DomainPurchaseValidator.class.php
 *
 * This file contains the definition of the DomainPurchaseValidator class.  
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

// DomainPurchase DBO
require_once BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * DomainPurchaseValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainPurchaseValidator extends FieldValidator
{
  /**
   * Validate a Domain Service Purchase ID
   *
   * Verifies that the server exists.
   *
   * @param string $data Field data
   * @return DomainServicePurchaseDBO Purchase DBO for this DomainServicePurchase ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($purchaseDBO = load_DomainServicePurchaseDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "DomainPurchase" );
      }

    return $purchaseDBO;
  }
}
?>