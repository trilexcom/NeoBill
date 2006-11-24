<?php
/**
 * PurchasableDBO.class.php
 *
 * This file contains the definition for the PurchasableDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Exceptions
class DuplicatePriceException extends SWException
{
  public function __construct() 
  { 
    parent::__construct();
    $this->message = "[FAILED_TO_ADD_PRICE_DUPLICATE]"; 
  }
}

/**
 * PurchasableDBO
 * 
 * Abstract base class for SolidState service and product DBO's.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class PurchasableDBO extends DBO
{
  /**
   * @var array Array of pricing options (PriceDBO's) for this product/service
   */
  protected $prices = array();

  /**
   * Add Price
   *
   * @param PriceDBO PriceDBO to add to this Purchasable
   */
  public function addPrice( PriceDBO $price )
  {
    // Ensure that there are no duplicate Onetime prices
    $prices = $this->getPricing( $price->getType(), $price->getTermLength(), null );
    if( !empty( $prices ) )
      {
	throw new DuplicatePriceException();
      }

    $this->prices[] = $price;
  }

  /**
   * Get Pricing
   *
   * Queries the pricing options available for this purchasable
   *
   * @return array An array of PriceDBO's for this purchasable
   */
  public function getPricing( $type = null, $termLength = null )
  {
    $results = array();
    foreach( $this->prices as $pricedbo )
      {
	if( ($type == null || $pricedbo->getType() == $type) &&
	    ($termLength == null || $pricedbo->getTermLength() == $termLength) )
	  {
	    $results[] = $pricedbo;
	  }
      }

    return $results;
  }
}
?>