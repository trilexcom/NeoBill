<?php
/**
 * PasswordWidget.class.php
 *
 * This file contains the definition of the PasswordWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/HTMLWidget.class.php";

/**
 * PasswordWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PasswordWidget extends HTMLWidget
{
  /**
   * Get Widget HTML
   *
   * Returns HTML code for a password widget
   *
   * @param array $params Parameters passed from the template
   * @return string HTML code for this widget
   */
  function getHTML( $params ) 
  {
    // Get widget value if available
    $myParams['value'] = $this->determineValue( $params );

    // Generate HTML for a text box control
    $myParams['type'] = "password";
    $myParams['value'] = null;
    return "<input " . $this->buildParams( $params, $myParams ) . "/>";
  }
}
?>