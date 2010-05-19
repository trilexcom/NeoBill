<?php
/**
 * AccountSelectWidget.class.php
 *
 * This file contains the definition of the AccountSelectWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * AccountSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AccountSelectWidget extends SelectWidget {
	/**
	 * Get Data
	 *
	 * @param array $config Field configuration
	 * @return array value => description
	 */
	function getData() {
		$accounts = array();

		// Query AccountDBO's
		try {
			$accountDBOs = load_array_AccountDBO();

			// Convery to an array: account ID => account name
			foreach( $accountDBOs as $accountDBO ) {
				$accounts[$accountDBO->getID()] = $accountDBO->getAccountName();
			}
		}
		catch( DBNoRowsFoundException $e ) {

		}

		return $accounts;
	}
}
?>