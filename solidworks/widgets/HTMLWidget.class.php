<?php
/**
 * HTMLWidget.class.php
 *
 * This file contains the definition of the HTMLWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * HTMLWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HTMLWidget
{
  /**
   * @var array Field configuration
   */
  protected $fieldConfig = array();

  /**
   * @var string Field name
   */
  protected $fieldName = null;

  /**
   * @var string Form name
   */
  protected $formName = null;

  /**
   * HTMLWidget Constructor
   *
   * @param string $formName The name of the form this widget belongs to
   * @param string $fieldName The name of the field this widget represents
   * @param array $fieldConfig The configuration for this field
   */
  public function __construct( $formName, $fieldName, $fieldConfig )
  {
    $this->formName = $formName;
    $this->fieldName = $fieldName;
    $this->fieldConfig = $fieldConfig;
  }

  /**
   * Determine Widget Value
   *
   * Determines the correct source to use for the value of this widget.
   * The order goes like this:
   *   5. No value
   *   4. The default value set in the config file
   *   3. The value given by the 'value' parameter of the {form_field} tag
   *   2. The value of this field in the specified DBO
   *   1. The value as entered by the user
   *
   * @param string $fieldName The name of the field this widget represents
   * @param array $config Field configuration
   * @param array $params Paramets passed from the template
   * @throws SWException
   * @return string The value to use
   */
  protected function determineValue( $params )
  {
    global $page;

    // Access the session
    $session =& $page->getPageSession();

    // 5. No value
    $value = null;

    // 4. Config file
    $value = isset( $this->fieldConfig['default_value'] ) ? 
      $this->fieldConfig['default_value'] : $value;

    // 3. {form_field} parameter
    $value = isset( $params['value'] ) ? $params['value'] : $value;

    // 2. DBO
    if( isset( $params['dbo'] ) )
      {
	$dbo = $session[$params['dbo']];

	// Get value for this field from the DBO
	if( !is_callable( array( $dbo, "get" . $this->fieldName ) ) )
	  {
	    // DBO Accessor does not exist
	    throw new SWException( "Could not access field: " . $this->fieldName . " in " .
				   get_class( $dbo ) );
	  }
	
	// Call "getFieldName" on this DBO to get the field value
	$value = call_user_func( array( $dbo, "get" . $this->fieldName ) );
      }

    // 1. User
    if( isset( $session[$this->formName][$this->fieldName] ) )
      {
	$value = is_object( $session[$this->formName][$this->fieldName] ) ?
	  $session[$this->formName][$this->fieldName]->__toString() :
	  $session[$this->formName][$this->fieldName];
      }

    return $value;
  }

  /**
   * Build Parameter List
   *
   * Builds a parameter string for the widget
   *
   * @param array $params Smarty parameter list
   * @param array $myParams An extra list of parameters (highest precedence)
   * @return string HTML parameter string
   */
  protected function buildParams( $params, $myParams )
  {
    // If the array parameter is true, add '[]' to the end of the field name
    $fieldName = strtolower( $params['array'] ) == "true" ?
      $this->fieldName . "[]" : $this->fieldName;

    // Start the parameter list with the basics
    $finalParams = array( "name" => $fieldName,
			  "size" => $this->fieldConfig['size'],
			  "class" => $this->fieldConfig['class'] );

    // Strip out irrelevant parameters passed to the {form_field} tag
    unset( $params['field'] );
    unset( $params['dbo'] );

    // Add in the parameters passed to the {form_field} tag
    $finalParams = array_merge( $finalParams, $params );

    // Add in the extra parameters
    $finalParams = isset( $myParams ) ? 
      array_merge( $finalParams, $myParams ) : $finalParams;

    // Return HTML
    return $this->generateParams( $finalParams );
  }

  /**
   * Generate Params HTML
   *
   * Generate HTML for a parameter list from values of an array
   *
   * @param array $params Parameter as key => value
   * @return string HTML parameter string
   */
  protected function generateParams( $params )
  {
    // Generate HTML for the parameter list
    $html = "";
    foreach( $params as $param => $value )
      {
	$html .= sprintf( "%s=\"%s\" ", $param, $value );
      }

    return $html;
  }

  /**
   * Get Widget HTML
   *
   * Returns HTML code for this widget
   *
   * @param array $params Parameters passed from the template
   * @return string HTML code for this widget
   */
  public function getHTML( $params ) 
  { 
    return "<b>Undefined Widget</b>"; 
  }
}
?>