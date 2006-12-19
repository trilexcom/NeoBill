<?php
/**
 * PaymentValidator.class.php
 *
 * This file contains the definition of the PaymentValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PaymentValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentValidator extends FieldValidator
{
  /**
   * @var integer Invoice ID
   */
  protected $invoiceID = null;

  /**
   * Set Invoice ID
   *
   * @param integer $id Invoice ID
   */
  public function setInvoiceID( $id ) { $this->invoiceID = $id; }

  /**
   * Validate a Payment ID
   *
   * Verifies that the payment exists.
   *
   * @param string $data Field data
   * @return PaymentDBO Payment DBO for this Payment ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    try { $paymentDBO = load_PaymentDBO( intval( $data ) ); }
    catch( DBNoRowsFoundException $e ) { throw new RecordNotFoundException( "Payment" ); }

    // Verify that this payment belongs to the invocie specified
    if( isset( $this->invoiceID ) && $paymentDBO->getInvoiceID() != $this->invoiceID )
      {
	throw new FieldException( "Invoice/Payment mismatch" );
      }

    return $paymentDBO;
  }
}
?>