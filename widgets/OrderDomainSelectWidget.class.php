<?php
/**
 * OrderDomainSelectWidget.class.php
 *
 * This file contains the definition of the OrderDomainSelectWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * OrderDomainSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class OrderDomainSelectWidget extends SelectWidget {
	/**
	 * @var OrderDBO The order to pull the domain's from
	 */
	protected $order = null;

	/**
	 * Get Data
	 *
	 * @return array value => description
	 */
	function getData() {
		if ( !isset( $this->order ) ) {
			throw new SWException( "Missing order DBO!" );
		}

		$orderItems = $this->order->getDomainItems();

		// Build an array: domain name => domain name
		$domains = array();
		foreach ( $orderItems as $domainItem ) {
			$domains[$domainItem->getFullDomainName()] = $domainItem->getFullDomainName();
		}

		return $domains;
	}

	/**
	 * Set Order
	 *
	 * @param OrderDBO The order to pull the domain's from
	 */
	public function setOrder( OrderDBO $order ) {
		$this->order = $order;
	}
}
?>