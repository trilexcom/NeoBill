<?php
/**
 * PaymentGatewayModuleValidator.class.php
 *
 * This file contains the definition of the PaymentGatewayModuleValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "validators/PaymentModuleValidator.class.php";

/**
 * PaymentGatewayModuleValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentGatewayModuleValidator extends PaymentModuleValidator
{
  /**
   * Validate a Payment Gateway Module
   *
   * To be valid, the payment gateway module must exist and be enabled
   *
   * @param string $data Field data
   * @return mixed The value is not altered by this function
   * @throws InvalidChoiceException
   */
  public function validate( $data )
  {
    $module = parent::validate( $data );

    if( $module->getType() != "payment_gateway" )
      {
	throw new InvalidChoiceException();
      }

    return $module;
  }
}
?>