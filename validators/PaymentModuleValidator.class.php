<?php
/**
 * PaymentModuleValidator.class.php
 *
 * This file contains the definition of the PaymentModuleValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "validators/ModuleValidator.class.php";

/**
 * PaymentModuleValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentModuleValidator extends ModuleValidator
{
  /**
   * Validate a Payment Module
   *
   * To be valid, the payment module must exist and be enabled
   *
   * @param string $data Field data
   * @return mixed The value is not altered by this function
   * @throws InvalidChoiceException
   */
  public function validate( $data )
  {
    $module = parent::validate( $data );

    if( !$module->isEnabled() || !($module->getType() == "payment_gateway" || 
				   $module->getType() == "payment_processor") )
      {
	throw new InvalidChoiceException();
      }

    return $module;
  }
}
?>