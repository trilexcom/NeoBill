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
require_once $base_path . "solidworks/DBO.class.php";

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
  var $orderitemid;

  /**
   * @var integer Order ID
   */
  var $orderid;

  /**
   * @var double Amount of taxes on this item
   */
  var $taxamount;

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
  function getPrice() { return "getPrice() Not Implemented"; }

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
  function getSetupFee() { return "getSetupFee() Not Implemented"; }

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
   * Set Tax Amount
   *
   * @param double $taxAmount Total amount of taxes
   */
  function setTaxAmount( $taxamount ) { $this->taxamount = $taxamount; }

  /**
   * Get Tax Amount
   *
   * @return double Total amount of taxes
   */
  function getTaxAmount() { return $this->taxamount; }
}

?>
