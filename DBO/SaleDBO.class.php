<?php
/**
 * SaleDBO.class.php
 *
 * This file contains the definition for the SaleDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * SaleDBO
 *
 * Represent a Sale.  This class is abstract.  It is implemented by the
 * OrderItemDBO and PurchaseDBO classes.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class SaleDBO extends DBO
{
  /**
   * @var PurchasableDBO The purchased item
   */
  protected $purchasable = null;

  /**
   * @var string Purchase term length (in months)
   */
  protected $term = null;

  /**
   * Constructor
   */
  public function __construct()
  {
  }

  /**
   * Get Onetime price
   *
   * @return float Onetime price or null if none exists
   */
  public function getOnetimePrice()
  {
    $prices = $this->purchasable->getPricing( "Onetime" );
    if( empty( $prices ) )
      {
	return null;
      }

    return $prices[0]->getPrice();
  }

  /**
   * Get Taxes on Onetime Price
   *
   * @return float Total amount due for taxes on the onetime price
   */
  public function getOnetimeTaxes()
  {
    $priceDBO = array_shift( $this->purchasable->getPricing( "Onetime" ) );
    if( $priceDBO == null || !$priceDBO->isTaxable() )
      {
	return 0;
      }

    $taxes = 0.00;
    foreach( $this->getTaxRules() as $taxRuleDBO )
      {
	$taxes += $this->getOnetimePrice() * ($taxRuleDBO->getRate() / 100.00);
      }

    return $taxes;
  }

  /**
   * Get Purchasable
   *
   * @return PurchasableDBO Returns the purchasable
   */
  public function getPurchasable() { return $this->purchasable; }

  /**
   * Get Recurring Price
   *
   * @return float Recurring price of this purchase or null if none exists
   */
  public function getRecurringPrice()
  {
    $prices = $this->purchasable->getPricing( "Recurring", $this->getTerm() );
    if( empty( $prices ) )
      {
	return null;
      }

    return $prices[0]->getPrice();
  }

  /**
   * Get Taxes on Recurring Price
   *
   * @return float Total amount due for taxes on the recurring price
   */
  public function getRecurringTaxes()
  {
    $priceDBO = array_shift( $this->purchasable->getPricing( "Recurring", 
							     $this->getTerm() ) );
    if( $priceDBO == null || !$priceDBO->isTaxable() )
      {
	return 0;
      }

    $taxes = 0.00;
    foreach( $this->getTaxRules() as $taxRuleDBO )
      {
	$taxes += $this->getRecurringPrice() * ($taxRuleDBO->getRate() / 100.00);
      }

    return $taxes;
  }

  /**
   * Get Tax Rules
   *
   * @return array An array of tax rules that apply to this purchase
   */
  abstract protected function getTaxRules();

  /**
   * Get Purchase Term
   *
   * @return integer Purchase term length (in months)
   */
  public function getTerm() { return $this->term; }

  /**
   * Set Purchasable
   *
   * @param PurchasableDBO The purchased item
   */
  public function setPurchasable( PurchasableDBO $purchasable )
  {
    $this->purchasable = $purchasable;
  }

  /**
   * Set Purchase Term
   *
   * @param integer $term Purchase term (in months)
   */
  public function setTerm( $term ) { $this->term = $term; }
}
?>