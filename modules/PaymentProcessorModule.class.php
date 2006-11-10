<?php
/**
 * PaymentProcessorModule.class.php
 *
 * This file contains the definition of the PaymentProcessorModule class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "modules/SolidStateModule.class.php";

/**
 * PaymentProcessorModule
 *
 * Provides a base class for modules of payment_processor type.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentProcessorModule extends SolidStateModule
{
  /**
   * @var string Module type is payment_processor
   */
  var $type = "payment_processor";

  /**
   * @var string Order Checkout page
   */
  var $orderCheckoutPage = null;

  /**
   * Get the Order Checkout Page
   */
  function getOrderCheckoutPage()
  {
    if( null == $this->orderCheckoutPage )
      {
	fatal_error( "PaymentProcessorModule::getOrderCheckoutPage()",
		     "An order checkout page was not provided for this module" );
      }

    return $this->orderCheckoutPage;
  }
}
?>