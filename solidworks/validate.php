<?php
/**
 * validate.php
 *
 * This file contains the form field validation engine
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Validate Length
 *
 * Validate the length of a string.
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_length( $field_data, $posted_data )
{
  $len = strlen( $posted_data );

  if( isset( $field_data['max_length'] ) )
    {
      // Verify that the field is not too long
      if( $len > $field_data['max_length'] )
	{
	  // Field is too big
	  return array( "type" => "FIELD_TOO_BIG",
			"field_name" => $field_data['name'],
			"args"       => array ( $field_data['description'], 
						$field_data['max_length'],
						$len ) );
	}
    }

  if( isset( $field_data['min_length'] ) )
    {
      // Verify that the field is not too short
      if( $len < $field_data['min_length'] )
	{
	  // Field is too short
	  return array( "type" => "FIELD_TOO_SMALL",
			"field_name" => $field_data['name'],
			"args"       => array ( $field_data['description'], 
						$field_data['min_length'],
						$len ) );
	}
    }

  // Validated
  return null;
}

/**
 * Validate E-Mail Address
 *
 * Verifies that the posted data is a valid email address
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_email( $field_data, $posted_data )
{
  if( !ereg( '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.
	     '@'.
	     '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
	     '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $posted_data ) )
    {
      // Not a valid email address
      return array( "type" => "INVALID_EMAIL",
		    "field_name" => $field_name,
		    "args" => array( $field_data['description'] ) );
    }

  // Validated
  return null;
}

/**
 * Validate IP Address
 *
 * Verify that this is a valid IP address
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_ipaddress( $field_data, $posted_data )
{
  $field_data = $field_data;
  $field_data['max_value'] = 255;
  $field_data['min_value'] = 0;
  $field_data['description'] .= "";

  // Check leftmost (1st) 8 bits
  if( ($error = validate_number( $field_data, $posted_data[0] )) != null )
    {
      return $error;
    }
  // Check 2nd 8 bits
  if( ($error = validate_number( $field_data, $posted_data[1] )) != null )
    {
      return $error;
    }
  // Check 3rd 8 bits
  if( ($error = validate_number( $field_data, $posted_data[2] )) != null )
    {
      return $error;
    }
  // Check 4th 8 bits
  if( ($error = validate_number( $field_data, $posted_data[3] )) != null )
    {
      return $error;
    }
}

/**
 * Validate Number
 *
 * Verify that the posted data is a number and is within the defined bounds
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_number( $field_data, $posted_data )
{
  if( !is_numeric( $posted_data ) )
    {
      // Not a number
      return array( "type" => "FIELD_NAN",
		    "field_name" => $field_name,
		    "args" => array( $field_data['description'] ) );
    }

  if( isset( $field_data['max_value'] ) )
    {
      // Validate upper bounds
      if( $posted_data > $field_data['max_value'] )
	{
	  // Too big
	  return array( "type" => "FIELD_VALUE_BIG",
			"field_name" => $field_name,
			"args" => array( $field_data['max_value'],
					 $field_data['description'] ) );
	}
    }

  if( isset( $field_data['min_value'] ) )
    {
      // Validate lower bounds
      if( $posted_data < $field_data['min_value'] )
	{
	  // Too small
	  return array( "type" => "FIELD_VALUE_SMALL",
			"field_name" => $field_name,
			"args" => array( $field_data['min_value'],
					 $field_data['description'] ) );
	}
    }

  // Validated
  return null;
}

/**
 * Validate DB Select
 *
 * Verify that the posted data is in the set of acceptable values
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_db_select( $field_data, $posted_data )
{
  // Load DBOs
  $dbo_array = call_user_func( "load_array_" . $field_data['dbo'] );

  // Build an enum of valid keys (values are irrelevant)
  foreach( $dbo_array as $dbo )
    {
      $key = call_user_func( array( $dbo, "get" . $field_data['valuefield'] ) );
      $field_data['enum'][$key] = "null";
    }

  // Pass on
  return validate_select( $field_data, $posted_data );  
}

/**
 * Validate Select
 *
 * Validate that the posted data is in the set of acceptable values
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_select( $field_data, $posted_data )
{
  if( array_key_exists( $posted_data, $field_data['enum'] ) != true )
    {
      // Not a valid option
      return array( "type" => "INVALID_SELECT",
		    "field_name" => $field_data['name'],
		    "args" => array( $field_data['description'], $posted_data ) );
    }

  // Valited
  return null;
}

/**
 * Validate Checkbox
 *
 * Validate that the posted data is an acceptable checkbox value
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_checkbox( $field_data, $posted_data )
{
  // Validated
  return null;
}

/**
 * Validate Table Selection
 *
 * Validate that the posted data is in the set of acceptable values
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_table( $field_data, $posted_data )
{
  foreach( $posted_data as $posted_value )
    {
      if( array_search( $posted_value, $field_data['enum'] ) === false )
	{
	  // Not a valid option
	  return array( "type" => "INVALID_SELECT",
			"field_name" => $field_data['name'],
			"args" => array( $field_data['description'], $posted_data ) );
	}
    }

  // Valited
  return null;
}

/**
 * Validate Checkbox Array
 *
 * Validate that the posted data is in the set of acceptable values
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_checkarray( $field_data, $posted_data )
{
  foreach( $posted_data as $posted_value )
    {
      if( array_search( $posted_value, $field_data['enum'] ) === false )
	{
	  // Not a valid option
	  return array( "type" => "INVALID_SELECT",
			"field_name" => $field_data['name'],
			"args" => array( $field_data['description'], $posted_data ) );
	}
    }

  // Valited
  return null;
}

/**
 * Validate Date
 *
 * Verify that the field is a valid Date.
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_date( $field_data, $posted_data )
{
  if( !checkdate( $posted_data['month'], 
		  $posted_data['day'], 
		  $posted_data['year'] ) )
    {
      // Date entered is invalid
      return array( "type" => "INVALID_DATE",
		    "field_name" => $field_data['name'],
		    "args" => array( $field_data['description'] ) );
  continue;
    }
}

/**
 * Validate Phone Number
 *
 * Verify that the posted data is an acceptable phone number
 *
 * @param array $field_data Form field configuration from application.conf
 * @param mixed $posted_data Data from POST
 * @return mixed Error message (array) or null if no errors
 */
function validate_phone( $field_data, $posted_data )
{
  if( !is_numeric( $posted_data['cc'] ) ||
      !is_numeric( $posted_data['area'] ) ||
      !is_numeric( $posted_data['number'] ) )
    {
      // Invalid characters
      return array( "type" => "INVALID_PHONE_NUMBER",
		    "field_name" => $field_data['name'],
		    "args" => array( $field_data['description'] ) );
    }

  $cc_field_data = $field_data;
  $cc_field_data['max_value'] = 999;
  $cc_field_data['min_value'] = 1;
  $cc_field_data['description'] .= " (country code)";
  if( ($error = validate_number( $cc_field_data, $posted_data['cc'] )) != null )
    {
      return $error;
    }

  $area_field_data = $field_data;
  $area_field_data['min_value'] = 0;
  $area_field_data['max_value'] = 999;
  $area_field_data['description'] .= " (area code)";
  if( ($error = validate_number( $area_field_data, $posted_data['area'] )) != null )
    {
      return $error;
    }

  $phone_field_data = $field_data;
  $phone_field_data['min_value'] = 100;
  $phone_field_data['max_value'] = 999999999;
  if( ($error = validate_number( $field_data, $posted_data['number'] )) != null )
    {
      return $error;
    }

  // Validated
  return null;
}

/**
 * Format Phone Number
 *
 * Given the three components of a phone number in an array, arrange them into
 * a properly formatted string: CC-AREACODE-PHONENUMBER
 *
 * @param array $phone Phone number components
 * @return string Formatted phone number
 */
function format_phone_number( $phone )
{
  return $phone['cc'] . "-" . $phone['area'] . "-" . $phone['number'];
}

/**
 * Parse Phone Number
 *
 * Takes a formatted phone number string (see format_phone_number) and 
 * explode the components into an array.
 *
 * @param string $phone_string Phone number in CC-AREACODE-PHONENUMBER format
 * @return array Phone number components
 */
function parse_phone_number( $phone_string )
{
  // Seperate the phone number by dashes
  $pieces = explode( "-", $phone_string );
  $phone['cc'] = $pieces[0];
  $phone['area'] = $pieces[1];
  $phone['number'] = $pieces[2];

  return $phone;
}

/**
 * Form Field Filter
 *
 * Remove PHP and HTML tags from a string
 *
 * @param array $field_data Form field configuration from application.conf
 * @param string $posted_data Data from POST
 * @return string Filtered data
 */
function form_field_filter( $field_data, $posted_data )
{
  // Remove PHP and HTML tags
  $sanitized = strip_tags( $posted_data );

  return $sanitized;
}

?>
