<?php
/**
 * SubmitWidget.class.php
 *
 * This file contains the definition of the SubmitWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * SubmitWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SubmitWidget extends HTMLWidget {
	/**
	 * Get Widget HTML
	 *
	 * Returns HTML code for this widget
	 *
	 * @param array $params Parameters passed from the template
	 * @return string HTML code for this widget
	 */
	function getHTML( $params ) {
		// Generate HTML for a text box control
		$myParams['value'] = $this->fieldConfig['description'];
		$myParams['type'] = "submit";
		return "<input " . $this->buildParams( $params, $myParams ) . "/>";
	}
}
?>