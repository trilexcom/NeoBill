<?php
/**
 * SelectWidget.class.php
 *
 * This file contains the definition of the SelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/HTMLWidget.class.php";

/**
 * SelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SelectWidget extends HTMLWidget
{
  /**
   * Get Data
   *
   * @return array value => description
   */
  function getData()
  {
    return $this->fieldConfig['enum'];
  }

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

    // Create <select> tag
    $html = sprintf( "<select %s>\n", 
		     $this->buildParams( $params, 
					 $myParams ) );

    // Add a "null" option if enabled
    if( strtolower( $params['nulloption'] ) == "true" )
      {
	$html .= "\t<option value=\"\"></option>\n";
      }

    foreach( $this->getData() as $optValue => $optDesc )
      {
	//Determin if this is the selected value
	if( $value == $optValue )
	  {
	    // This is the selected option
	    $optParams['selected'] = "selected";
	  }
	else
	  {
	    unset( $optParams['selected'] );
	  }

	// Add option HTML
	$optParams['value'] = $optValue;
	$html .= sprintf( "\t<option %s>%s</option>\n",
			  $this->generateParams( $optParams ),
			  $optDesc );
      }

    // Close <select> tag
    $html .= "</select>\n";

    return $html;
  }
}
?>