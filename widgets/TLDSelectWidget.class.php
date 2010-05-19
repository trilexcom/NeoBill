<?php
/**
 * TLDSelectWidget.class.php
 *
 * This file contains the definition of the TLDSelectWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * TLDSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TLDSelectWidget extends SelectWidget {
	/**
	 * Get Data
	 *
	 * @param array $config Field configuration
	 * @return array value => description
	 */
	function getData() {
		// Query TLDServiceDBO's
		$tlds = array();
		try {
			// Convery to an array: TLD => TLD
			$where = $this->fieldConfig['publicitemsonly'] ? "public='Yes'" : null;
			$domainDBOs = load_array_DomainServiceDBO( $where );
			foreach ( $domainDBOs as $domainDBO ) {
				$tlds[$domainDBO->getTLD()] = $domainDBO->getTLD();
			}
		}
		catch ( DBNoRowsFoundException $e ) {

		}

		return $tlds;
	}
}
?>