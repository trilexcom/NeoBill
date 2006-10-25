<?php
/**
 * CartDomainTableWidget.class.php
 *
 * This file contains the definition of the CartDomainTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

/**
 * CartDomainTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CartDomainTableWidget extends TableWidget
{
  /**
   * @var array Column headers (column id => description)
   */
  protected $columnHeaders = array( "domainname" => "[DOMAIN_NAME]" );

  /**
   * Set Order
   *
   * @param OrderDBO $order The order to be displayed
   */
  function setOrder( $order ) 
  { 
    // Copy the order's item data into the table data array
    foreach( $order->getExistingDomains() as $orderItemDBO )
      {
	$key = $orderItemDBO->getOrderItemID();
	$this->data[$key] = array( "domainname" => $orderItemDBO->getDescription() );
      }
  }
}