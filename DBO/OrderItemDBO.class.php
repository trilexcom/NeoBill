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

/**
 * OrderItemDBO
 *
 * Represent an Order Item.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class OrderItemDBO extends SaleDBO {
    /**
     * @var integer OrderItem ID
     */
    protected $orderitemid = null;

    /**
     * @var integer Order ID
     */
    protected $orderid = null;

    /**
     * @var string The status of this order item: Rejected, Pending, Accepted, or Fulfilled
     */
    protected $status = "Pending";

    /**
     * @var array An array of tax rules that apply to this item
     */
    protected $taxRules = array();

    /**
     * Convert to a String
     *
     * @return string Order Item ID
     */
    public function __toString() {
        return $this->getOrderItemID();
    }

    /**
     * Set Order Item ID
     *
     * @param integer $id Order Item ID
     */
    public function setOrderItemID( $id ) {
        $this->orderitemid = $id;
    }

    /**
     * Get Order Item ID
     *
     * @return integer Order Item ID
     */
    public function getOrderItemID() {
        return $this->orderitemid;
    }

    /**
     * Set Order ID
     *
     * @param integer $id Order ID
     */
    public function setOrderID( $id ) {
        $this->orderid = $id;
    }

    /**
     * Get Order ID
     *
     * @return integer Order ID
     */
    public function getOrderID() {
        return $this->orderid;
    }

    /**
     * Get Order DBO
     *
     * @return OrderDBO The OrderDBO this item belongs to
     */
    public function getOrderDBO() {
        return load_OrderDBO( $this->getOrderID() );
    }

    /**
     * Get Description (stub)
     *
     * @return string Description of order item
     */
    abstract public function getDescription();

    /**
     * Set Status
     *
     * @param string $status Status is Rejected, Pending, Accepted, or Fulfilled
     */
    public function setStatus( $status ) {
        if( !( $status == "Rejected" ||
                $status == "Pending" ||
                $status == "Accepted" ||
                $status == "Fulfilled" ) ) {
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
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set Tax Rules
     *
     * @param array An array of tax rules that apply to this item
     */
    public function setTaxRules( $taxRules ) {
        $this->taxRules = $taxRules;
    }

    /**
     * Get Tax Rules
     *
     * @return array An array of tax rules that apply to this item
     */
    public function getTaxRules() {
        return $this->taxRules;
    }

    /**
     * Execute Order Item
     *
     * @param AccountDBO $accountDBO Account this order belongs to
     * @return boolean True for success
     */
    abstract function execute( $accountDBO );
}

?>