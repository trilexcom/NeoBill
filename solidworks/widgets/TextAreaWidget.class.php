<?php
/**
 * TextAreaWidget.class.php
 *
 * This file contains the definition of the TextAreaWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * TextAreaWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TextAreaWidget extends HTMLWidget {
	/**
	 * Get Widget HTML
	 *
	 * Returns HTML code for this widget
	 *
	 * @param array $params Parameters passed from the template
	 * @return string HTML code for this widget
	 */
	function getHTML( $params ) {
		// Get widget value if available
		$value = $this->determineValue( $params );

		// Generate HTML for a text box control
		unset( $myParams['type'] );
		$paramStr = $this->buildParams( $params, $myParams );
		return sprintf( "\n<textarea %s>%s</textarea>\n", $paramStr, $value );
	}
}
?>