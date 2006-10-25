<?php
/**
 * PaymentMethodValidator.class.php
 *
 * This file contains the definition of the PaymentMethodValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/validators/ChoiceValidator.class.php";

/**
 * PaymentMethodValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentMethodValidator extends FieldValidator
{
  /**
   * Validate a Payment Method
   *
   * To be valid, the payment method must exist and be enabled
   *
   * @param string $data Field data
   * @return mixed The value is not altered by this function
   * @throws InvalidChoiceException
   */
  public function validate( $data )
  {
    global $conf;

    // Check is the only native option
    if( $data == "Check" )
      {
	return $data;
      }

    // Search payment modules
    foreach( $conf['modules'] as $moduleName => $module )
      {
	if( $data == $moduleName && 
	    $module->isEnabled() &&
	    ($module->getType() == "payment_gateway" || 
	     $module->getType() == "payment_processor") )
	  {
	    return $data;
	  }
      }

    // No matches found
    throw new InvalidChoiceException();
  }
}
?>