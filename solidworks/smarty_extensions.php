<?php
/**
 * smarty_extensions.php
 *
 * This file contains all custom Smarty plugins
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once "smarty_widgets.php";

// Keeps track of the {form} ... {/form} block(s) we are in
$form_stack = array();

// State info for {dbo_table} tag
$dbo_table_print_headers = false;
$dbo_table_name = null;
$dbo_table_cols = 0;
$dbo_table_url = "";

// Register these custom functions with Smarty
$smarty->register_function( "echo",             "smarty_echo" );
$smarty->register_block(    "form",             "smarty_form" );
$smarty->register_function( "form_element",     "smarty_form_element" );
$smarty->register_function( "form_description", "smarty_form_description" );
$smarty->register_function( "form_echo",        "smarty_form_echo" );
$smarty->register_function( "dbo_echo",         "smarty_dbo_echo" );
$smarty->register_function( "dbo_assign",       "smarty_dbo_assign" );
$smarty->register_block(    "dbo_table",        "smarty_dbo_table" );
$smarty->register_block(    "dbo_table_column", "smarty_dbo_table_column" );
$smarty->register_function( "page_messages",    "smarty_page_messages" );
$smarty->register_function( "page_errors",      "smarty_page_errors" );

// Register these custom modifiers with Smarty
$smarty->register_modifier( "password",         "smarty_modifier_password" );
$smarty->register_modifier( "mailto",           "smarty_modifier_mailto" );
$smarty->register_modifier( "currency",         "smarty_modifier_currency" );
$smarty->register_modifier( "datetime",         "smarty_modifier_datetime" );
$smarty->register_modifier( "country",          "smarty_modifier_country" );

/**
 * Smarty Country Modifier
 *
 * Convert a Country Code to the country name
 *
 * @param string $value Country code
 * @return string Country name
 */
function smarty_modifier_country( $value )
{
  global $cc;

  // Return the country name according to the CC provided
  return $cc[$value];
}

/**
 * Smarty Mailto Modifier
 *
 * Convert an email address to a mailto: link
 *
 * @param string $value Email address
 * @return string Mailto link
 */
function smarty_modifier_mailto( $value )
{
  // Return the value as an email link
  return "<a href=\"mailto:" . $value . "\">" . $value . "</a>";
}

/**
 * Smarty Password Modifier
 *
 * Convert a string to a string of *'s at most 10 characters long
 *
 * @param string $value Password
 * @return string Obfuscated text
 */
function smarty_modifier_password( $value )
{
  // Return the value as all characters replaced by a '*', at most 10 chars long
  return substr( preg_replace( "/\w/", "*", $value ), 0, 10 );
}

/**
 * Smarty Currency Modifier
 *
 * Convert a number to $n.nn format
 *
 * @param double $value Currency value
 * @return string Formatted value
 */
function smarty_modifier_currency( $value )
{
  global $conf;

  // Return the numeric value with two decimal places and a $
  return sprintf( "%s%01.2f", $conf['locale']['currency_symbol'], $value );
}

/**
 * Smarty Date/Time Modifier
 *
 * Convert a MySQL DATETIME to a more presentable format
 *
 * @param string $value MySQL DATETIME
 * @param string $show_part Show only the specified part of the date/time ("date or "time")
 * @return string Formated Date / Time
 */
function smarty_modifier_datetime( $value, $show_part = null )
{
  global $DB;

  // Convert datetime to a unix time stamp
  $time = $DB->datetime_to_unix( $value );

  // Return a formated date, e.g. 12/11/2005, 11:39:00am 
  // (or just one part, date/time)
  switch( $show_part )
    {
    case "date":
      return strftime( "%m/%d/%Y", $time );
      break;

    case "time":
      return strftime( "%r", $time );
      break;

    default:
      return strftime( "%m/%e/%Y, %r", $time );

    }
}

/**
 * Smarty Echo
 *
 * Echo the correct translation for a given phrase ID
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_echo( $params, &$smarty )
{
  global $conf, $translations;

  return translate( $conf['locale']['language'], $params['phrase'] );
}

/**
 * Smarty DBO Table Column
 *
 * Handles the dbo_table_column tag.
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_dbo_table_column( $params, $content, &$smarty, &$repeat )
{
  global $dbo_table_print_headers, $dbo_table_name, $dbo_table_cols, $page, $dbo_table_url, $conf;

  $header     = translate_string( $conf['language'], $params['header'] );
  $sort_field = $params['sort_field'];
  $style      = $params['style'];

  // Access the Page's session data
  $session =& $page->getPageSession();

  // Access table properties
  $properties =& $session[$dbo_table_name ."_properties"];

  if( !isset( $content ) )
    {
      // Do nothing for opening block call
      return;
    }

  // Closing block call
  if( $dbo_table_print_headers )
    {
      // Only print the column header
      if( isset( $sort_field ) )
	{
	  // Set the sorting direction
	  $sort_dir = "ASC";
	  if( $properties['sortby'] == $sort_field )
	    {
	      // This field is already sorted - now sort in the opposite direction
	      $sort_dir = $properties['sortdir'] == "ASC" ? "DESC" : "ASC";
	    }

	  echo "<th style=\"" . $style . "\"> <a href=\"" . $page->getUrl() . 
	    "&table=" . $dbo_table_name . 
	    "&sortby=" . $sort_field .  
	    "&sortdir=" . $sort_dir .
	    $dbo_table_url .
	    "\">" . $header . "</a> </th>\n";
	}
      else
	{
	  echo "<th style=\"" . $style . "\"> " . $header . " </th>\n";
	}

      // Increment column counter
      $dbo_table_cols++;      
    }
  else
    {
      // evaluate this column
      echo "<td> " . $content . "</td>";
    }
}

/**
 * Smarty DBO Table
 *
 * Query the database and display DBOs in an organized table which can be
 * browsed and sorted in a common interface.
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_dbo_table( $params, $content, &$smarty, &$repeat )
{
  global $dbo_table_print_headers, $dbo_table_name, $dbo_table_cols, $page, $conf, $dbo_table_url;

  // Access the Page's session data
  $session =& $page->getPageSession();

  // Grab parameters
  $dbo_table_name = $params['name'];
  $title          = translate_string( $conf['locale']['language'], $params['title'] );
  $dbo_class      = $params['dbo_class'];
  $method_name    = $params['method_name'];
  $size           = $params['size'];
  $sortby         = $params['sortby'];
  $sortdir        = $params['sortdir'];
  $style          = $params['style'];
  $search         = $params['search'] == "true";
  $dbo_table_url  = $params['url'];

  // Append the filter paramater if it has already been defined in the session
  $filter = $session[$dbo_table_name."_properties"]['filter'];
  if( isset( $params['filter'] ) )
    {
      if( isset( $filter ) )
	{
	  $filter .= " AND " . $params['filter'];
	}
      else
	{
	  $filter = $params['filter'];
	}
    }

  // Check if a search criteria is provided
  $search_form = "search_" . $dbo_table_name;
  if( isset( $session[$search_form] ) )
    {
      // Construct a filter from the search parameters
      foreach( $conf['forms'][$search_form]['fields'] as 
	       $search_field_name => $search_field_data )
	{
	  // Only process configured fields
	  if( isset( $session[$search_form][$search_field_name] ) &&
	      $search_field_data['type'] != "submit" )
	    {
	      // Process this search field
	      if( isset( $filter ) )
		{
		  $filter .= " AND";
		}
	      $filter .= 
		" " . $search_field_name . " LIKE '%" .
		$session[$search_form][$search_field_name] . "%'";
	    }
	}
    }

  // Count the total number of rows
  if( isset( $method_name ) )
    {
      // Use a callback
      $count = count( call_user_func( array( $page, $method_name ) ) );
    }
  else
    {
      // Use the DBO class
      $count = call_user_func( "count_all_" . $dbo_class, $filter );
    }

  // Access properties
  $properties =& $session[$dbo_table_name ."_properties"];

  if( !isset( $size ) )
    {
      // Defualt size is the number of rows returned
      $size = $count;
    }

  if( !isset( $dbo_class ) )
    {
      // No DBO provided
      return "DBO not provided!";
    }

  if( isset( $content ) )
    {
      // End of block - tell dbo_table_column to not print headers any more
      $dbo_table_print_headers = false;

      // Shift a DBO off the top of the DBO array
      $session[$dbo_table_name] = 
	@array_shift( $session[$dbo_table_name . "_array"] );

      if( $session[$dbo_table_name] == null )
	{
	  // No more DBOs
	  $repeat = false;

	  // Close table HTML
	  $start = $properties['start'];
	  $content .= "</tr>\n";
	  $content .= "<tr class=\"footer\">\n";
	  $content .= "  <td colspan=\"" . $dbo_table_cols . "\">\n";

	  if( $start > 0 )
	    {
	      // Provide "prev" and "begin" links
	      $start_val = ($start - $size) > 0 ? ($start - $size) : 0;
	      $content .= 
		" (<a href=\"" . $page->getUrl() . "&table=" . $dbo_table_name .
		"&start=0" . $dbo_table_url . "\">Begin</a>) ";
	      $content .=
		"<a href=\"" . $page->getUrl() . "&table=" . $dbo_table_name .
		"&start=" . $start_val . $dbo_table_url . "\">Prev</a>";
	    }
	  else
	    {
	      // This is the first page of data - no prev link
	      $content .= "(Begin) Prev";
	    }

	  $content .= " | ";

	  if( $start + $size < $count )
	    {
	      // Provide "next" and "end" links
	      $content .= 
		"<a href=\"" . $page->getUrl() . "&table=" . $dbo_table_name . 
		"&start=" . ($start + $size) . $dbo_table_url . "\">Next</a>";
	      $content .= 
		" (<a href=\"" . $page->getUrl() . "&table=" . $dbo_table_name .
		"&start=" . ($count - $size) . $dbo_table_url . "\">End</a>)";
	    }
	  else
	    {
	      // This is the last page of data - no next link
	      $content .= "Next (End)";
	    }

	  $content .= "  </td>\n";
	  $content .= "</tr>";
	  $content .= "</table>\n";
	  echo $content;
	}
      else
	{
	  // Loop until no more DBOs
	  $repeat = true;
	  echo $content . "</tr>\n<tr>";
	}

      return;
    }
  else
    {
      // Beginning of block - Tell dbo_table_column to print the headers on first call
      $dbo_table_print_headers = true;
      $dbo_table_cols = 0;

      unset( $session[$dbo_table_name] );

      // Set default properties
      if( !isset($properties['start'] ) )
	{
	  $properties['start'] = 0;
	}

      // Sorting
      if( isset( $sortby ) )
	{
	  $properties['sortby'] = $sortby;
	  $properties['sortdir'] = isset( $sortdir ) ? $sortdir : "ASEC";
	}

      // Read any properties from GET
      if( $_GET['table'] == $dbo_table_name )
	{
	  // Some properties set in GET
	  if( isset( $_GET['sortby'] ) )
	    {
	      // Set sortby
	      $properties['sortby'] = $_GET['sortby'];

	      // Reset start position to 0
	      $properties['start'] = 0;
	    }
	  if( isset( $_GET['sortdir'] ) )
	    {
	      // Set sort direction
	      $properties['sortdir'] = $_GET['sortdir'];
	    }
	  if( isset( $_GET['start'] ) )
	    {
	      // Set start position
	      $properties['start'] = $_GET['start'];
	    }
	}

      // Bring the starting position within bounds
      if( $size < $count && ($properties['start'] + $size) > $count )
	{
	  $properties['start'] = $count - $size;
	}

      // Query the DBO, store results in the session
      if( isset( $method_name ) )
	{
	  // Use a call back
	  $session[$dbo_table_name . "_array"] =
	    call_user_func( array( $page, $method_name ) );
	}
      else
	{
	  // Use the DBO class
	  $session[$dbo_table_name . "_array"] = 
	    call_user_func( "load_array_" . $dbo_class,
			    $filter,
			    $properties['sortby'],
			    $properties['sortdir'], 
			    $size,
			    $properties['start'] );
	}

      // Prepare table HTML
      $args = "";
      if( isset( $style ) )
	{
	  // Add a style tag to table args
	  $args .= "style=\"" . $style . "\"";
	}
      $html = "<p> " . $title . " "; 
      $html .= $properties['start'] + 1;
      $html .= " - ";

      // Make sure the upper limit is < number of rows returned
      $top_val = 
	$properties['start'] + $size > $count ? $count : $properties['start'] + $size;

      $html .= $top_val;
      $html .= " of " . $count . " </p>\n";
      $html .= "<table " . $args . ">\n";
      $html .= "  <tr>\n";

      // Output table HTML
      echo $html;
    }

}

/**
 * Smarty DBO Assign
 *
 * Assign a DBO value to a Smarty template variable
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_dbo_assign( $params, &$smarty )
{
  global $page;

  $dbo_var_name = $params['dbo'];
  $field_name   = $params['field'];
  $smarty_var   = $params['var'];

  // Access the Page's session data
  $session =& $page->getPageSession();

  if( !isset( $session[$dbo_var_name] ) )
    {
      // DBO not found
      return;
    }

  $dbo = $session[$dbo_var_name];

  if( !is_callable( array( $dbo, "get" . $field_name ) ) )
    {
      // DBO Accessor does not exist
      fatal_error( "smarty_dbo_assign",
		   "Error: could not get field: " . $field_name . " from " .$dbo_var_name );
    }

  // Call "getFieldName" on this DBO and return as a smarty variable
  $smarty->assign( $smarty_var,
		   call_user_func( array( $dbo, "get" . $field_name ) ) );
}

/**
 * Smarty DBO Echo
 *
 * Print the value of a DBO field
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_dbo_echo( $params, &$smarty )
{
  global $page;

  $dbo_var_name = $params['dbo'];
  $field_name   = $params['field'];

  // Access the Page's session data
  $session =& $page->getPageSession();

  if( !isset( $session[$dbo_var_name] ) )
    {
      // DBO not found
      return;
    }

  $dbo = $session[$dbo_var_name];

  if( !is_callable( array( $dbo, "get" . $field_name ) ) )
    {
      // DBO Accessor does not exist
      fatal_error( "smarty_dbo_echo",
		   "Error: could not get field: " . $field_name . " from " .$dbo_var_name );
    }

  // Call "getFieldName" on this DBO and return
  return call_user_func( array( $dbo, "get" . $field_name ) );
}

/**
 * Smarty Form
 *
 * Define the beggining and end of a SolidWorks form
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form( $params, $content, &$smarty, &$repeat )
{
  global $conf, $form_stack;

  $form_name = $params['name'];

  // Verify form name parameter is supplied
  if( !isset( $form_name ) )
    {
      fatal_error( "smarty_form()", "No form name provided!" );
    }

  // Verify form is configured
  $form_data = $conf['forms'][$form_name];
  if( !isset( $form_data ) )
    {
      fatal_error( "smarty_form()",
		   "Form (" . $form_name . ") is not configured!" );
    }

  if( isset( $content ) )
    {
      // End of block - pop this form name from the stack
      array_pop( $form_stack );

      // Set method
      $form_method = $form_data['method'];
      if( !isset( $form_method ) )
	{
	  $form_method="POST";
	}

      // Set action
      $page_name = $form_data['page'];
      if( !isset( $page_name ) )
	{
	  // No page name provided
	  fatal_error( "smarty_form()", "Form page is not configured!" );
	}
      $action = $conf['controller'] . "?page=" . $page_name . "&submit=" . $form_name;

      // Output the content enclosed within the form tags
      return "<form method=\"" . $form_method . 
	"\" action=\"" . $action . "\">" . 
	$content . 
	"</form>";
    }

  // Beginning of block - Push form name onto stack
  array_push( $form_stack, $form_name );
}

/**
 * Smarty Page Messages
 *
 * Output any page messages
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_page_messages( $params, &$smarty )
{
  global $conf, $page;

  $messages = $_SESSION['messages'];

  if( !isset( $messages ) )
    {
      // No messages to display
      return null;
    }
  
  // Build message box HTML
  $html = "<p class=\"message\">\n";

  // Write all the error messages currently in the session
  foreach( $messages as $message_data )
    {
      // Insert arguments into error message
      $message = translate( $conf['locale']['language'], $message_data['type'] );
      if( isset( $message_data['args'] ) )
	{
	  foreach( $message_data['args'] as $i => $arg )
	    {
	      $s = translate_string( $conf['locale']['language'], $arg );
	      $message = str_replace( "{" . $i . "}", $s, $message );
	    }
	}
      $html .= $message . "<br/>\n";
    }
      
  $html .= "</p>\n";

  // Remove messages from session
  unset( $_SESSION['messages'] );

  return $html;
}

/**
 * Smarty Page Errors
 *
 * Output any page errors
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_page_errors( $params, &$smarty )
{
  global $conf, $page;

  $errors = $_SESSION['errors'];

  if( !isset( $errors ) )
    {
      // No errors to display
      return null;
    }
  
  // Build error box HTML
  $html = "<p class=\"error\">\n";

  // Write all the error errors currently in the session
  foreach( $errors as $error_data )
    {
      // Insert arguments into error errors
      $error = translate( $conf['locale']['language'], $error_data['type'] );
      if( isset( $error_data['args'] ) )
	{
	  foreach( $error_data['args'] as $i => $arg )
	    {
	      $s = translate_string( $conf['locale']['language'], $arg );
	      $error = str_replace( "{" . $i . "}", $s, $error );
	    }
	}
      $html .= $error . "<br/>\n";
    }
      
  $html .= "</p>\n";

  // Remove errors from session
  unset( $_SESSION['errors'] );

  return $html;
}

/**
 * Smarty Form Element
 *
 * Display a form field element
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form_element( $params, &$smarty )
{
  global $form_stack, $page, $cc;
  $conf =& $page->conf;
  $DB =& $page->DB;

  $form_name        = end( $form_stack );
  $form_field       = $params['field'];
  $field_size       = $params['size'];
  $dbo_var_name     = $params['dbo'];
  $option           = $params['option'];
  $hide_value       = $params['hide_value'] == "true";
  $readonly         = $params['readonly'] == "true";
  $value            = $params['value'];

  // Access the Page's session data
  $session =& $page->getPageSession();

  // Verify form configuration exists
  $form_data = $conf['forms'][$form_name];
  if( !isset( $form_data ) )
    {
      // Form is not configured
      return "Form (" . $form_name . ") is not valid!";
    }

  // Verify the field exists
  $field_data = $form_data['fields'][$form_field];
  if( !isset( $field_data ) )
    {
      // Field description is not configured
      return "Form field (" . 
	$form_field_description .
	") is not configured!";
    }

  if( isset( $dbo_var_name ) )
    {
      // Access DBO if provided
      $dbo = $session[$dbo_var_name];
    }

  if( isset( $field_data['hash'] ) )
    {
      // Option values are supplied in the session
      if( !isset( $session[$field_data['hash']] ) )
	{
	  echo "the hash specified for select element is not in the session!";
	}
      $field_data['enum'] = $session[$field_data['hash']];
    }

  // The following chain of if's determine the field's value (if any)
  if( !isset( $value ) && isset( $field_data['default_value'] ) )
    {
      // Value parameter takes precedence over the default value
      $value = $field_data['default_value'];
    }
  if( isset( $dbo ) )
    {
      // Get value for this field from the DBO
      if( !is_callable( array( $dbo, "get" . $form_field ) ) )
	{
	  // DBO Accessor does not exist
	  fatal_error( "smarty_form_element",
		       "Error: could not get field: " . $form_field . " from " .$dbo_var_name );
	}
      
      // Call "getFieldName" on this DBO to get the field value
      $value = call_user_func( array( $dbo, "get" . $form_field ) );
    }
  if( $field_data['type'] != "checkarray" &&
      isset( $session[$form_name][$form_field] ) )
    {
      // Get the value for this field from the session
      $value = $session[$form_name][$form_field];
    }

  // Set field parameters to be used by the widget functions
  $field_data['name'] = $params['field'];
  $field_data['form_name'] = $form_name;
  $field_data['value'] = $value;
  $field_data['error'] = field_has_error( $field_data['name'] );
  $field_data['read_only'] = $readonly;
  $field_data['size'] = $field_size;
  $field_data['option'] = $option;
  $field_data['hide_value'] = $hide_value;
  $field_data['cols'] = isset( $params['cols'] ) ? $params['cols'] : 30;
  $field_data['rows'] = isset( $params['rows'] ) ? $params['rows'] : 2;
  $field_data['onchange'] = $params['onchange'];
  $field_data['checked'] = $params['checked'];

  // Build HTML
  switch( $field_data['type'] )
    {

    case "table":
      $html = widget_table( $field_data );
      break;

    case "date":
      $html = widget_date( $field_data );
      break;

    case "textarea":
      $html = widget_textarea( $field_data );
      break;

    case "radio":
      $html = widget_radio( $field_data );
      break;

    case "checkbox":
      $html = widget_checkbox( $field_data );
      break;

    case "checkarray":
      $html = widget_checkarray( $field_data );
      break;

    case "db_select":
      // Retrieve options from the database
      $dbo_array = call_user_func( "load_array_" . $field_data['dbo'],
				   $field_data['filter'] );

      // And place them in the field's select options
      if( isset( $dbo_array ) )
	{
	  foreach( $dbo_array as $dbo )
	    {
	      $key = call_user_func( array( $dbo, "get" . $field_data['valuefield'] ) );
	      $value = call_user_func( array( $dbo, "get" . $field_data['displayfield'] ) );
	      $field_data['enum'][$key] = $value;
	    }
	}

      $html = widget_select( $field_data );
      break;

    case "select":
      $html = widget_select( $field_data );
      break;

    case "cancel":
    case "submit":
      $html = widget_button( $field_data );
      break;

    case "password":
      $html = widget_password( $field_data );
      break;

    case "float":
    case "int":
    case "email":
    case "text":
      $html = widget_text( $field_data );
      break;

    case "dollar":
      $html = widget_dollar( $field_data );
      break;

    case "telephone":
      $html = widget_telephone( $field_data );
      break;

    case "country":
      $html = widget_country( $field_data );
      break;

    case "ipaddress":
      $html = widget_ipaddress( $field_data );
      break;

    default:
      return "Field type (" . $field_data['type'] . ") not recognized!";

    }

  return $html;
}

/**
 * Smarty Form Echo
 *
 * Output the value of the specified form field
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form_echo( $params, &$smarty )
{
  global $conf, $form_stack, $page;

  $form_name        = end( $form_stack );
  $form_field       = $params['field'];

  // Access the Page's session data
  $session =& $page->getPageSession();

  // Verify form configuration exists
  $form_data = $conf['forms'][$form_name];
  if( !isset( $form_data ) )
    {
      // Form is not configured
      return "Form (" . $form_name . ") is not valid!";
    }

  // Verify the field exists
  $field_data = $form_data['fields'][$form_field];
  if( !isset( $field_data ) )
    {
      // Field description is not configured
      return "Form field (" . 
	$form_field_description .
	") is not configured!";
    }

  // Return value
  return $session[$form_name][$form_field];
}

/**
 * Field Has Error
 *
 * Determine if the specified field had an error in form validation.
 *
 * @param string $field_name Field name
 * @return boolean True if field has error
 */
function field_has_error( $field_name )
{
  global $conf, $form_stack, $page;

  $form_name = end( $form_stack );

  if( !isset( $form_name ) )
    {
      // Missing a form name
      fatal_error( "field_has_error()",
		   "field_has_error must be called from within a {form} {/form} block" );
    }

  $form_conf = $conf['forms'][$form_name];
  $page_name = $form_conf['page'];

  // Access the Page's session data
  $session =& $page->getPageSession();

  $errors = $session['form_errors'];

  if( !isset( $errors ) )
    {
      // no errors, return
      return false;
    }

  // Search errors for field name
  foreach( $errors as $error )
    {
      if( $error['field_name'] == $field_name )
	{
	  // Error for field was found
	  return true;
	}
    }

  return false;
}

/**
 * Smarty Form Description
 *
 * Output the description for a form field
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form_description( $params, &$smarty )
{
  global $conf, $form_stack;

  $form_name        = end( $form_stack );
  $form_field       = $params['field'];
  $colon            = $params['colon'];

  // Verify form configuration exists
  $form_data = $conf['forms'][$form_name];
  if( !isset( $form_data ) )
    {
      // Form is not configured
      return "Form (" . $form_name . ") is not valid!";
    }

  // Verify the field exists
  $field_data = $form_data['fields'][$form_field];
  $form_field_description = translate_string( $conf['locale']['language'],
					      $field_data['description'] );
  if( !isset( $form_field_description ) )
    {
      // Field description is not configured
      return "Form field description (" . 
	$form_field_description .
	") is not configured!";
    }

  if( $colon != "false" )
    {
      // Add a colon unless explicity told not to
      $form_field_description .= ": ";
    }

  if( $field_data['required'] )
    {
      // Append a red '*' to required fields
      $form_field_description .= "<b>*</b> ";
    }

  // Output the field description
  return $form_field_description;
}
