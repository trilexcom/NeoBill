<?php
/**
 * CountrySelectWidget.class.php
 *
 * This file contains the definition of the CountrySelectWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Countries list
require BASE_PATH . "solidworks/cc.php";

/**
 * CountrySelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CountrySelectWidget extends SelectWidget {
	/**
	 * Get Data
	 *
	 * @param array $config Field configuration
	 * @return array value => description
	 */
	function getData() {
		global $cc;
		return $cc;
	}
}
?>