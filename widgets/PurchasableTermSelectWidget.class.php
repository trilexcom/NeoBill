<?php
/**
 * PurchasableTermSelectWidget.class.php
 *
 * This file contains the definition of the PurchasableTermSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PurchasableTermSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PurchasableTermSelectWidget extends SelectWidget
{
  /**
   * @var PurchasableDBO The Purchasable to display terms for
   */
  protected $purchasable = null;

  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  function getData()
  {
    global $conf;
    $cs = $conf['locale']['currency_symbol'];

    $terms = array();
    foreach( $this->purchasable->getPricing( "Recurring" ) as $price )
      {
	$terms[$price->getID()] =
	  sprintf( "%d [MONTHS] - %s%01.2f", 
		   $price->getTermLength(), 
		   $cs, 
		   $price->getPrice() );

      }

    return $terms;
  }

  /**
   * Set Purchasable DBO
   *
   * @param PurchasableDBO The purchasable to display terms for
   */
  function setPurchasable( PurchasableDBO $purchasable ) 
  { 
    $this->purchasable = $purchasable; 
  }
}
?>