<?php
/**
 * PriceDBO.class.php
 *
 * This file contains the definition for the PriceDBO class
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PriceDBO
 *
 * Provides an abstract base class for a Price DBO.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class PriceDBO extends DBO {
    /**
     * @var float The price
     */
    protected $price = 0.00;

    /**
     * @var string Taxable flag: Yes or No
     */
    protected $taxable = "No";

    /**
     * @var integer The length (in months) of the term that this price is for (the length for 'Setup' or 'Onetime' price types must be 0)
     */
    protected $termLength = 0;

    /**
     * @var string The price type: Onetime or Recurring
     */
    protected $type = null;

    /**
     * To String
     *
     * @return string Returns the getID() method
     */
    public function __toString() {
        return $this->getID();
    }

    /**
     * Get ID
     *
     * @return string The concatenated ID for this price's database row
     */
    abstract public function getID();

    /**
     * Get Price
     *
     * @return float The price
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Get Taxable Flag
     *
     * @return string Taxable flag: Yes or No
     */
    public function getTaxable() {
        return $this->taxable;
    }

    /**
     * Get Term Length
     *
     * @return integer The length of this price's term
     */
    public function getTermLength() {
        return $this->termLength;
    }

    /**
     * Get Price Type
     *
     * @return string The type of price: Onetime or Recurring
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Is Taxable
     *
     * @return boolean True if this price is taxable
     */
    public function isTaxable() {
        return $this->taxable == "Yes";
    }

    /**
     * Set Price
     *
     * @param float $price The price
     */
    public function setPrice( $price ) {
        $this->price = $price;
    }

    /**
     * Set Taxable Flag
     *
     * @param string $taxable Taxable flag: Yes or No
     */
    public function setTaxable( $taxable ) {
        if( !($taxable == "Yes" || $taxable == "No") ) {
            throw new SWUserException( "Invalid price-taxable flag: " . $taxable );
        }

        $this->taxable = $taxable;
    }

    /**
     * Set Term Length
     *
     * @param integer $termLength The length (in months) of the term for a recurring price
     */
    public function setTermLength( $termLength ) {
        $this->termLength = $termLength;
    }

    /**
     * Set Price Type
     *
     * @param string $type Price type: Onetime or Recurring
     */
    public function setType( $type ) {
        if( !($type == "Onetime" || $type == "Recurring") ) {
            throw new SWUserException( "Invalid price type: " . $type );
        }

        $this->type = $type;
    }
}
?>