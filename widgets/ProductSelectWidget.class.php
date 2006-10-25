<?php
/**
 * ProductSelectWidget.class.php
 *
 * This file contains the definition of the ProductSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// Product  DBO
require_once BASE_PATH . "DBO/ProductDBO.class.php";

/**
 * ProductSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @return array value => description
   */
  function getData()
  {
    // Query ProductDBO's
    $productDBOs = load_array_ProductDBO();
    if( empty( $productDBOs ) )
      {
	return array();
      }

    // Convery to an array: product ID => product name
    $products = array();
    foreach( $productDBOs as $productDBO )
      {
	$products[$productDBO->getID()] = $productDBO->getName();
      }

    return $products;
  }
}
?>