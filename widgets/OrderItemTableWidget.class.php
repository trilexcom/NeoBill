<?php
/**
 * OrderItemTableWidget.class.php
 *
 * This file contains the definition of the OrderItemTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * OrderItemTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderItemTableWidget extends TableWidget
{
  /**
   * @var OrderDBO Order
   */
  protected $order = null;

  /**
   * @var booelean When false the table will only show accepted items
   */
  protected $showAllFlag = true;

  /**
   * Determine Widget Value
   *
   * Determines the correct source to use for the value of this widget.
   * The order goes like this:
   *   1. The enabled/disabled status of the module
   *
   * @param array $params Paramets passed from the template
   * @throws SWException
   * @return string The value to use
   */
  protected function determineValue( $params )
  {
    if( $this->order == null || 
	null == ($orderitemdbo =& $this->order->getItem( intval( $params['option'] ) )) )
      {
	return null;
      }

    // 2. No value
    $value = null;

    // Checkbox will show as checked whenever "option" == "value"
    // 1. Enabled/Disabled
    $value = $orderitemdbo->getStatus() == "Rejected" ? 
      $value : $orderitemdbo->getOrderItemID();

    return $value;
  }

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
	// Nothing to show
	return ;
      }

    $items = $this->showAllFlag ? $this->order->getItems() : $this->order->getAcceptedItems();
    if( $items == null )
      {
	// Nothing to show
	return ;
      }

    // Build the table
    foreach( $items as $dbo )
      {
	// Put the row into the table
	$this->data[] = 
	  array( "id" => $dbo->getID(),
		 "orderitemid" => $dbo->getOrderItemID(),
		 "description" => $dbo->getDescription(),
		 "term" => $dbo->getTerm(),
		 "setupfee" => $dbo->getOnetimePrice(),
		 "price" => $dbo->getRecurringPrice() );
      }
  }

  /**
   * Set Order
   *
   * @param OrderDBO $order The order
   */
  public function setOrder( OrderDBO $order ) { $this->order = $order; }

  /**
   * Show Accepted Items Only
   */
  public function showAcceptedItemsOnly() { $this->showAllFlag = false; }
}