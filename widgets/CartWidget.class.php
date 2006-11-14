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

/**
 * CartWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CartWidget extends TableWidget
{
  /**
   * @var OrderDBO The order
   */
  protected $order = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    if( !isset( $this->order ) )
      {
	// Nothing to do
	return ;
      }

    // Build the table
    foreach( $this->order->getItems() as $dbo )
      {
	// Put the row into the table
	$this->data[] = 
	  array( "orderitemid" => $dbo->getOrderItemID(),
		 "description" => $dbo->getDescription(),
		 "term" => $dbo->getTerm(),
		 "setupfee" => $dbo->getSetupFee(),
		 "price" => $dbo->getPrice() );
      }
  }

  /**
   * Set Order
   *
   * @param OrderDBO $order The order to be displayed
   */
  function setOrder( OrderDBO $order ) { $this->order = $order; }
}