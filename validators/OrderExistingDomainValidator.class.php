<?php
/**
 * OrderExistingDomainValidator.class.php
 *
 * This file contains the definition of the OrderExistingDomainValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * OrderExistingDomainValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderExistingDomainValidator extends FieldValidator
{
  /**
   * @var OrderDBO The order that the domains must belong to to be valid
   */
  private $order = null;

  /**
   * Set Order
   *
   * @param OrderDBO An order to validate orderitem's against
   */
  function setOrder( $orderDBO ) { $this->order = $orderDBO; }

  /**
   * Validate an OrderDomain ID
   *
   * Verifies that the domains exists in the order
   *
   * @param string $data Field data
   * @return OrderDomainDBO OrderDomain DBO for this OrderItem ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( $this->order == null )
      {
	// Can not validate an order item without an order property
	throw new SWException( "Attempted to validate an OrderItem without giving an OrderDBO!" );
      }

    if( null == ($orderDomainDBO = $this->order->getExistingDomain( intval( $data ) )) )
      {
	// Order Item does not exist
	throw new RecordNotFoundException( "OrderItem" );
      }

    return $orderDomainDBO;
  }
}
?>