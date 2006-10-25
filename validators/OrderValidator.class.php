<?php
/**
 * OrderValidator.class.php
 *
 * This file contains the definition of the OrderValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/validators/FieldValidator.class.php";

// Exceptions
require_once BASE_PATH . "exceptions/RecordNotFoundException.class.php";

// Order DBO
require_once BASE_PATH . "DBO/OrderDBO.class.php";

/**
 * OrderValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderValidator extends FieldValidator
{
  /**
   * Validate a Order ID
   *
   * Verifies that the order exists.
   *
   * @param array $config Field configuration
   * @param string $data Field data
   * @return OrderDBO Order DBO for this Order ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($orderDBO = load_OrderDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "Order" );
      }

    return $orderDBO;
  }
}
?>