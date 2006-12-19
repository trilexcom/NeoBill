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

/**
 * HostingPurchaseValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingPurchaseValidator extends FieldValidator
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

    try { $purchaseDBO = load_HostingServicePurchaseDBO( intval( $data ) ); }
    catch( DBNoRowsFoundException $e ) { throw new RecordNotFoundException( "HostingPurchase" ); }

    // Verify that this purchase is for a specific account
    if( isset( $this->accountID ) && $purchaseDBO->getAccountID() != $this->accountID )
      {
	throw new FieldException( "Purchase/Account mismatch" );
      }

    return $purchaseDBO;
  }
}
?>