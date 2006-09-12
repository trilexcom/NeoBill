<?php
/**
 * smarty_widgets.php
 *
 * This file contains functions that generate HTML code for all the form field
 * types available under the Smarty extension: {form_field}
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include an array filled with Countries and their 2 letter country code
require_once "cc.php";

/**
 * IP Address Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_ipaddress( $widget_data )
{
  $ip = long2ip( $widget_data['value'] );
  $ip_parts = explode( ".", $ip );

  // Leftmost (1st) 8 bits
  $first_widget_data = $widget_data;
  $first_widget_data['size'] = "4";
  $first_widget_data['value'] = $ip_parts[0];
  $html = widget_text( $first_widget_data );

  // 2nd 8 bits
  $second_widget_data = $widget_data;
  $second_widget_data['name'] .= "_2";
  $second_widget_data['size'] = "4";
  $second_widget_data['value'] = $ip_parts[1];
  $html .= "." . widget_text( $second_widget_data );

  // 3rd 8 bits
  $third_widget_data = $widget_data;
  $third_widget_data['name'] .= "_3";
  $third_widget_data['size'] = "4";
  $third_widget_data['value'] = $ip_parts[2];
  $html .= "." . widget_text( $third_widget_data );

  // 4th 8 bits
  $fourth_widget_data = $widget_data;
  $fourth_widget_data['name'] .= "_4";
  $fourth_widget_data['size'] = "4";
  $fourth_widget_data['value'] = $ip_parts[3];
  $html .= "." . widget_text( $fourth_widget_data );

  return $html;
}

/**
 * Checkbox Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_checkbox( $widget_data )
{
  // Build HTML for a checkbox
  $html = "<input class=\"checkbox\" type=\"checkbox\" name=\"" . 
    $widget_data['name'] . "\" " .
    "value=\"true\" ";
  
  if( $widget_data['value'] == true )
    {
      // This option is selected
      $html .= "checked ";
    }
  
  if( $widget_data['read_only'] )
    {
      $html .= "disabled ";
    }
  
  $html .= "/> ";
  return $html;
}

/**
 * Checkbox Array Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_checkarray( $widget_data )
{
  // Build HTML for a checkbox
  $html = "<input class=\"checkbox\" type=\"checkbox\" name=\"" . 
    $widget_data['name'] . "[]\" " .
    "value=\"" . $widget_data['value'] . "\" ";
  
  if( $widget_data['checked'] == true )
    {
      // This option is selected
      $html .= "checked ";
    }
  
  if( $widget_data['read_only'] )
    {
      $html .= "disabled ";
    }
  
  $html .= "/> ";
  return $html;
}

/**
 * Radio Button Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_radio( $widget_data )
{
  global $conf;

  // Build HTML for a radio button
  $html = "<input class=\"radio\" type=\"radio\" name=\"" . 
    $widget_data['name'] . "\" " .
    "value=\"" . $widget_data['option'] . "\" ";

  if( $widget_data['value'] == $widget_data['option'] )
    {
      // This option is selected
      $html .= "checked ";
    }

  if( isset( $widget_data['onclick'] ) )
    {
      $html .= "onClick=\"" . $widget_data['onclick'] . "\" ";
    }
  
  $html .= "/> ";
  $html .= $widget_data['hide_value'] ? 
    "" : translate_string( $conf['locale']['language'], 
			   $widget_data['enum'][$widget_data['option']] );

  return $html;
}

/**
 * Command Button Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_button( $widget_data )
{
  global $conf;

  // Build HTML for a submit button
  $html = "<input type=\"submit\" name=\"" . 
    $widget_data['name'] . "\" " . $size .
    "value=\"" . translate_string( $conf['locale']['language'],
				   $widget_data['description'] ) . "\"/>";
  
  return $html;
}

/**
 * Dollar-input Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_dollar( $widget_data )
{
  global $conf;

  // Format to a 9.99 format and return with a $ in front of the widget
  $widget_data['value'] = sprintf( "%01.2f", $widget_data['value'] );
  return $conf['locale']['currency_symbol'] . widget_text( $widget_data );
}

/**
 * Password-input Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_password( $widget_data )
{
  $widget_data['value'] = "";
  return widget_text( $widget_data );
}

/**
 * Text-input Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_text( $widget_data )
{
  if( $widget_data['error'] )
    {
      // Flag field with an error
      $class_name = "text_error";
    }
  else
    {
      $class_name = $widget_data['required'] ? "text_required" : "text";
    }

  // Change the type to password if this is a password field
  $type = $widget_data['type'] == "password" ? "password" : "text";

  // Generate text box
  $html = "<input type=\"" . $widget_data['type'] . 
    "\" name=\"" . $widget_data['name'] . "\" " .
    "class=\"" . $class_name . "\" " .
    "size=\"" . $widget_data['size'] . "\" " .
    "value=\"" . $widget_data['value'] . "\"/>";

  return $html;
}

/**
 * Text-area-input Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_textarea( $widget_data )
{
  // Build HTML for a text box
  $html = "<textarea cols=" . $widget_data['cols'] ." rows=" . $widget_data['rows'] . 
    " name=\"" . $widget_data['name'] . "\" ";

  if( $widget_data['error'] )
    {
      // Flag field with an error
      $class_name = "text_error";
    }
  else
    {
      $class_name = $widget_data['required'] ? "text_required" : "text";
    }
  $html .=  "class=\"" . $class_name . "\">\n";

  $html .= $widget_data['value'];
  
  $html .= "</textarea>\n";

  return $html;
}

/**
 * Telephone-input Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_telephone( $widget_data )
{
  $phone = parse_phone_number( $widget_data['value'] );

  // Country Code
  $cc_widget_data = $widget_data;
  $cc_widget_data['name'] .= "_cc";
  $cc_widget_data['size'] = "1";
  $cc_widget_data['value'] = $phone['cc'] == 0 ? 1 : $phone['cc'];
  $html = "+" . widget_text( $cc_widget_data );

  // Area Code
  $area_widget_data = $widget_data;
  $area_widget_data['name'] .= "_area";
  $area_widget_data['size'] = "2";
  $area_widget_data['value'] = $phone['area'];
  $html .= " (" . widget_text( $area_widget_data ) . ")";

  // Phone number
  $phone_widget_data = $widget_data;
  $phone_widget_data['size'] = "7";
  $phone_widget_data['value'] = $phone['number'];
  $html .= " " . widget_text( $phone_widget_data );

  return $html;
}

/**
 * Country-select Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_country( $widget_data )
{
  global $cc;

  // Copy the names and codes into this fields 'enum' setting
  $widget_data['enum'] = $cc;
  $widget_data['default_value'] = "US";

  // And hand it off to the select widget to do the rest
  $html = widget_select( $widget_data );

  return $html;
}

/**
 * Date Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_date( $widget_data )
{
  global $DB;

  $months = array( "January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" );
  for( $i = 1; $i <= 31; $i++ )
    {
      $days[$i] = $i;
    }

  if( isset( $widget_data['value'] ) )
    {
      // If the value is numeric, it's already a time stamp
      $date = is_numeric( $widget_data['value'] ) ? 
	$widget_data['value'] : $DB->datetime_to_unix( $widget_data['value'] );
    }
  else
    {
      // Use now as the date
      $date = time();
    }
  $date = getdate( $date );

  // Create a select widget for the month component
  $month_widget_data = $widget_data;
  $month_widget_data['enum'] = $months;
  $month_widget_data['value'] = $date['mon'] - 1;
  $html = widget_select( $month_widget_data ) . " / ";

  // Create a select widget for the day of the month
  $day_widget_data = $widget_data;
  $day_widget_data['name'] .= "_day";
  $day_widget_data['enum'] = $days;
  $day_widget_data['value'] = $date['mday'];

  $hidden = sprintf( "<input name=\"%s\" type=\"hidden\" value=1/>",
		     $day_widget_data['name'] );

  $html .= $widget_data['noDayField'] == "true" ?
    $hidden : widget_select( $day_widget_data ) . " / ";

  // Create a text widget for the year
  $year_widget_data = $widget_data;
  $year_widget_data['name'] .= "_year";
  $year_widget_data['value'] = $date['year'];
  $year_widget_data['size'] = "4";
  $html .= widget_text( $year_widget_data );
  
  return $html;
}

/**
 * Select Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_select( $widget_data )
{
  global $conf, $page;

  // Build HTML for a select box
  $html = "<select name=\"" . $widget_data['name'] . "\"";
  if( isset( $widget_data['onchange'] ) )
    {
      $html .= " onChange=\"" . $widget_data['onchange'] . "\"";
    }
  $html.= ">\n";

  if( isset( $widget_data['method_name'] ) )
    {
      $widget_data['enum'] = call_user_func( array( $page, 
						    $widget_data['method_name'] ) );
    }
  
  if( !isset( $widget_data['enum'] ) )
    {
      // No options for this select box provided
      $widget_data['enum'] = array();
    }

  if( !$widget_data['required'] )
    {
      // Provide a "null" option
      $html .= "\t<option value=\"\"></option>\n";
    }

  // Use the set value if provided, otherwise use the default
  $default_option = isset( $widget_data['value'] ) ? 
    $widget_data['value'] : $widget_data['default_value'];

  foreach( $widget_data['enum'] as $option => $description )
    {
      // Build an <option> tag for each configured option
      unset( $selected );
      if( $default_option == $option )
	{
	  // This option is the default - show that it is selected
	  $selected = " selected=\"selected\" ";
	}
      
      $html .= "  <option value=\"" . $option . "\" " .
	$selected . "> " . 
	translate_string( $conf['locale']['language'], $description ) .
	" </option>\n";
    }

  $html .= "</select>\n";

  return $html;
}

/**
 * Table Widget
 *
 * @param array $widget_data Widget data structure
 * @return string HTML
 */
function widget_table( $widget_data )
{
  global $conf, $page;

  if( isset( $widget_data['method_name'] ) )
    {
      // Get the table data from the callback method
      $widget_data['dbo_array'] = call_user_func( array( $page, 
							 $widget_data['method_name'] ) );
    }

  // Begin HTML
  $html = "<table>\n";

  // Generate column headers
  $html .= "\t<tr class=\"reverse\">\n\t\t<th/>\n";
  foreach( $widget_data['columns'] as $column_data )
    {
      $html .= "\t\t<th>" . 
	translate_string( $conf['locale']['language'], $column_data['header'] ) . 
	"</th>\n";
    }
  $html .= "\t</tr>\n";

  if( !isset( $widget_data['dbo_array'] ) )
    {
      // Table is empty
      $html .= "</table>\n" . 
	translate_string( $conf['locale']['language'], $widget_data['description'] ) . 
	" is empty.\n\n";
      return $html;
    }

  $page->session[$widget_data['name']]['values'] = array();

  // Create a row for each data element
  foreach( $widget_data['dbo_array'] as $dbo )
    {
      $value = call_user_func( array( $dbo, 
				      "get" . $widget_data['valuefield'] ) );
      $page->session[$widget_data['name']]['values'][] = $value;
      $html .= "\t<tr>\n";
      $html .= "\t\t<td style=\"width: 21px;\"> <input type=\"checkbox\" name=\"" . 
	$widget_data['name'] . "[]\" " . 
	"value=\"" . $value . "\"/> </td>\n";

      foreach( $widget_data['columns'] as $field_name => $column_data )
	{
	  $html .= "\t\t<td>" . 
	    call_user_func( array( $dbo, "get" . $field_name ) ) . 
	    "</td>\n";
	}

      $html .= "\t<tr>\n";
    }

  $html .= "</table>";
  return $html;
}

?>