<?php
/**
 * LanguageValidator.class.php
 *
 * This file contains the definition of the LanguageValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * LanguageValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LanguageValidator extends ChoiceValidator {
	/**
	 * Get Valid Choices
	 *
	 * Returns all the valid languages
	 *
	 * @return array An array of valid language choices
	 */
	function getValidChoices() {
		$languages = array();

		// Read all the languages in the "language/" directory
		$langDir = opendir( "language/" );
		while ( false !== ($file = readdir( $langDir )) ) {
			if ( is_file( "language/" . $file ) ) {
				$languages[$file] = $file;
			}
		}

		return $languages;
	}
}
?>