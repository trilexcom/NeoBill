<?php
/**
 * TextWidget.class.php
 *
 * This file contains the definition of the TextWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * TextWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TextWidget extends HTMLWidget
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
    $myParams['value'] = $this->determineValue( $params );

    // Generate HTML for a text box control
    $myParams['type'] = "text";
    return "<input " . $this->buildParams( $params, $myParams ) . "/>";
  }
}
?>