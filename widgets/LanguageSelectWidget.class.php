<?php
/**
 * LanguageSelectWidget.class.php
 *
 * This file contains the definition of the LanguageSelectWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * LanguageSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LanguageSelectWidget extends SelectWidget {
	/**
	 * Get Data
	 *
	 * @param array $config Field configuration
	 * @return array value => description
	 */
	function getData() {
		$languages = array();

		// Read all the languages in the "language/" directory
		$langDir = opendir( "language/" );
		while ( false !== ($file = readdir( $langDir )) ) {
			if ( filetype( "language/" . $file ) == "file" ) {
				$languages[$file] = $file;
			}
		}

		return $languages;
	}
}
?>