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

/**
 * ProductSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductSelectWidget extends SelectWidget {
	/**
	 * Get Data
	 *
	 * @return array value => description
	 */
	function getData() {
		// Query ProductDBO's
		$products = array();
		try {
			$productDBOs = load_array_ProductDBO();

			// Convery to an array: product ID => product name
			foreach ( $productDBOs as $productDBO ) {
				$products[$productDBO->getID()] = $productDBO->getName();
			}
		}
		catch ( DBNoRowsFoundException $e ) {

		}

		return $products;
	}
}
?>