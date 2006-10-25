<?php
/**
 * OrderItemAcceptCheckListWidget.class.php
 *
 * This file contains the definition of the OrderItemAcceptCheckListWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/CheckBoxWidget.class.php";

/**
 * OrderItemAcceptCheckListWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderItemAcceptCheckListWidget extends CheckBoxWidget
{
  /**
   * @var OrderDBO The order that the checklist will be created for
   */
  private $order = null;

  /**
   * Determine Widget Value
   *
   * Determines the correct source to use for the value of this widget.
   * The order goes like this:
   *   2. The accepted status as it currently is for the Order
   *   1. The value as entered by the user
   *
   * @param array $params Paramets passed from the template
   * @throws SWException
   * @return string The value to use
   */
  protected function determineValue( $params )
  {
    global $page;

    if( $params['option'] == null )
      {
	return null;
      }

    // Access the session
    $session =& $page->getPageSession();

    if( $this->order == null )
      {
	// No order provided
	throw new SWException( "No order provided for OrderItemAcceptCheckList" );
      }

    // 3. No value
    $value = null;

    // Checkbox will show as checked whenever "option" == "value"
    // 2. Accepted status as it currently is for the order
    $value = $this->order->getItem( $params['option'] )->getStatus() == "Rejected" ?
      $value : intval( $params['option'] );

    // 1. The value as entered by the user
    $submitValues = isset( $session[$this->formName][$this->fieldName] ) ?
      $session[$this->formName][$this->fieldName] : array();
    foreach( $submitValues as $orderItemDBO )
      {
	$value = ($orderItemDBO->getOrderItemID() == $params['option']) ?
	  $value = $params['option'] : $value;
      }

    return $value;
  }

  /**
   * Set Order
   *
   * @param OrderDBO $order The order that the checklist will be created for
   */
  public function setOrder( $order ) { $this->order = $order; }
}
?>