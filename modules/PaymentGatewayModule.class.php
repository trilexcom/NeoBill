<?php
/**
 * PaymentGatewayModule.class.php
 *
 * This file contains the definition of the PaymentGatewayModule class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "modules/SolidStateModule.class.php";

/**
 * PaymentGatewayModule
 *
 * Provides a base class for modules of payment_gateway type.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class PaymentGatewayModule extends SolidStateModule {
	/**
	 * @var string Module type is payment_gateway
	 */
	protected $type = "payment_gateway";

	/**
	 * Authorize a Credit Card Transaction
	 *
	 * @param ContactDBO $contactDBO Billing contact
	 * @param string $cardNumber Credit card number
	 * @param string $expireDate CC expiration date (MMYY)
	 * @param string $cardCode CVV2/CVC2/CID code
	 * @param PaymentDBO $paymentDBO Payment DBO for this transaction
	 * @return boolean False when there is an error processing the transaction
	 */
	abstract public function authorize( $contactDBO, $cardNumber, $expireDate, $cvv, &$paymentDBO );

	/**
	 * Authorize and Capture a Credit Card Transaction
	 *
	 * @param ContactDBO $contactDBO Billing contact
	 * @param string $cardNumber Credit card number (XXXXXXXXXXXXXXXXXXXX)
	 * @param string $expireDate CC expiration date (MMYY)
	 * @param string $cardCode CVV2/CVC2/CID code
	 * @param PaymentDBO $paymentDBO Payment DBO for this transaction
	 * @return boolean False when there is an error processing the transaction
	 */
	abstract public function authorizeAndCapture( $contactDBO, $cardNumber, $expireDate, $cardCode, &$paymentDBO );

	/**
	 * Capture a Previously Authorized Transaction
	 *
	 * @param PaymentDBO $paymentDBO Previously authorized payment DBO
	 * @return boolean False on a processing error
	 */
	abstract public function capture( &$paymentDBO );

	/**
	 * Refund the Customer
	 *
	 * @param PaymentDBO $paymentDBO Previously authorized & captured payment DBO
	 * @return boolean False on a processing error
	 */
	abstract public function refund( &$paymentDBO );

	/**
	 * Void an Authorized Transaction
	 *
	 * @param PaymentDBO $paymentDBO Previously authorized payment DBO
	 * @return boolean False on a processing error
	 */
	abstract public function void( &$paymentDBO );
}
?>