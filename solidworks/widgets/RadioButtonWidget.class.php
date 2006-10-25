<?php
/**
 * RadioButtonWidget.class.php
 *
 * This file contains the definition of the RadioButtonWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/HTMLWidget.class.php";

/**
 * RadioButtonWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RadioButtonWidget extends HTMLWidget
{
  /**
   * Get Widget HTML
   *
   * Returns HTML code for this widget
   *
   * @param array $params Parameters passed from the template
   * @return string HTML code for this widget
   */
  function getHTML( $params ) 
  {
    // Get widget value if available
    $value = $this->determineValue( $params );

    // Determine if this radio button is "checked"
    if( $params['option'] == $value )
      {
	// This option is checked
	$myParams['checked'] = "checked";
      }

    // Generate HTML for a text box control
    $myParams['type'] = "radio";
    $myParams['value'] = $params['option'];
    return sprintf( "<input %s/> %s",
		    $this->buildParams( $params, $myParams ),
		    $this->fieldConfig['enum'][$params['option']] );
  }
}
?>