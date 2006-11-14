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

/**
 * DomainPurchaseValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainPurchaseValidator extends FieldValidator
{
  /**
   * @var integer Account ID
   */
  protected $accountID = null;

  /**
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  public function setAccountID( $id ) { $this->accountID = $id; }

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

    // Verify that this purchase is for a specific account
    if( isset( $this->accountID ) && $purchaseDBO->getAccountID() != $this->accountID )
      {
	throw new FieldException( "Purchase/Account mismatch" );
      }

    return $purchaseDBO;
  }
}
?>