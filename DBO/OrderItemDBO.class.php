<?php
/**
 * OrderItemDBO.class.php
 *
 * This file contains the definition for the OrderItemDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once BASE_PATH . "solidworks/DBO.class.php";

/**
 * OrderItemDBO
 *
 * Represent an Order Item.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderItemDBO extends DBO
{
  /**
   * @var integer OrderItem ID
   */
  var $orderitemid = null;

  /**
   * @var integer Order ID
   */
  var $orderid = null;

  /**
   * @var double Tax amount for this item
   */
  var $taxAmount = 0;

  /**
   * @var string The status of this order item: Rejected, Pending, Accepted, or Fulfilled
   */
  var $status = "Pending";

  /**
   * Set Order Item ID
   *
   * @param integer $id Order Item ID
   */
  function setOrderItemID( $id ) { $this->orderitemid = $id; }

  /**
   * Get Order Item ID
   *
   * @return integer Order Item ID
   */
  function getOrderItemID() { return $this->orderitemid; }

  /**
   * Set Order ID
   *
   * @param integer $id Order ID
   */
  function setOrderID( $id ) { $this->orderid = $id; }

  /**
   * Get Order ID
   *
   * @return integer Order ID
   */
  function getOrderID() { return $this->orderid; }

  /**
   * Get Order DBO
   *
   * @return OrderDBO The OrderDBO this item belongs to
   */
  function getOrderDBO() { return load_OrderDBO( $this->getOrderID() ); }

  /**
   * Get Description (stub)
   *
   * @return string Description of order item
   */
  function getDescription() { return "getDescription() Not Implemented"; }

  /**
   * Get Term (stub)
   *
   * @return string Term of order item
   */
  function getTerm() { return "getTerm() Not Implemented"; }

  /**
   * Get Price
   *
   * @return double Price of this order item
   */
  function getPrice() { return 0.00; }

  /**
   * Get Price String (stub)
   *
   * @return string Price of order item formatted with currency symbol
   */
  function getPriceString() { return "getPriceString() Not Implemented"; }

  /**
   * Get Setup Fee
   *
   * @return double Setup fee for this order item
   */
  function getSetupFee() { 0.00; }

  /**
   * Get Setup Fee String (stub)
   *
   * @return string Setup fee for order item formatted with currency symbol
   */
  function getSetupFeeString() { return "getSetupFeeString() Not Implemented"; }

  /**
   * Is Taxable
   *
   * @return boolean True if this item is taxable
   */
  function isTaxable() { return "isTaxable() Not Implemented"; }

  /**
   * Get Tax Amount
   *
   * @return double Total amount of taxes
   */
  function getTaxAmount() { return $this->taxAmount; }

  /**
   * Set Tax Amount
   *
   * @param double Tax to be charged for this item
   */
  function setTaxAmount( $taxAmount ) { $this->taxAmount = $taxAmount; }

  /**
   * Set Status
   *
   * @param string $status Status is Rejected, Pending, Accepted, or Fulfilled
   */
  function setStatus( $status )
  {
    if( !( $status == "Rejected" || 
	   $status == "Pending" || 
	   $status == "Accepted" ||
	   $status == "Fulfilled" ) )
      {
	fatal_error( "OrderItemDBO::setStatus()",
		     "Invalid value for status: " . $status );
      }
    $this->status = $status;
  }

  /**
   * Get Status
   *
   * @return string Rejected, Pending, Accepted, or Fulfilled
   */
  function getStatus() { return $this->status; }

  /**
   * Execute Order Item
   *
   * @param AccountDBO $accountDBO Account this order belongs to
   * @return boolean True for success
   */
  function execute( $accountDBO )
  {
    fatal_error( "OrderItemDBO::execute()", "execute() not implemented!" );
  }

  /**
   * Load Member Data from Array
   *
   * @param array $data Data to be loaded
   */
  function load( $data )
  {
    $this->setOrderItemID( $data['orderitemid'] );
    $this->setStatus( $data['status'] );
  }
}

?>