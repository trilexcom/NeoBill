<?php
/**
 * CartWidget.class.php
 *
 * This file contains the definition of the CartWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

/**
 * CartWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CartWidget extends TableWidget
{
  /**
   * @var array Column headers (column id => description)
   */
  protected $columnHeaders = array( "description" => "[ITEM]",
				    "term" => "[TERM]",
				    "setupfee" => "[SETUP_FEE]",
				    "price" => "[PRICE]" );

  /**
   * Set Order
   *
   * @param OrderDBO $order The order to be displayed
   */
  function setOrder( $order ) 
  { 
    // Copy the order's item data into the table data array
    foreach( $order->getItems() as $orderItemDBO )
      {
	$key = $orderItemDBO->getOrderItemID();
	$this->data[$key] = array( "description" => $orderItemDBO->getDescription(),
				   "term" => $orderItemDBO->getTerm(),
				   "setupfee" => $orderItemDBO->getSetupFeeString(),
				   "price" => $orderItemDBO->getPriceString() );
      }
  }
}