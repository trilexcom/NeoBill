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

// Keeps track of the {form} ... {/form} block(s) we are in
$form_stack = array();

// Register these custom functions with Smarty
$smarty->register_function( "echo",             "smarty_echo" );
$smarty->register_block(    "form",             "smarty_form" );
$smarty->register_function( "form_element",     "smarty_form_element" );
$smarty->register_function( "form_description", "smarty_form_description" );
$smarty->register_function( "form_echo",        "smarty_form_echo" );
$smarty->register_function( "dbo_echo",         "smarty_dbo_echo" );
$smarty->register_function( "dbo_assign",       "smarty_dbo_assign" );
$smarty->register_function( "page_messages",    "smarty_page_messages" );
$smarty->register_function( "page_errors",      "smarty_page_errors" );
$smarty->register_block(    "form_table",       "smarty_form_table" );
$smarty->register_block(    "form_table_column","smarty_form_table_column" );
$smarty->register_block(    "form_table_footer","smarty_form_table_footer" );
$smarty->register_function( "form_table_checkbox", "smarty_form_table_checkbox" );

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
  // Convert datetime to a unix time stamp
  $time = DBConnection::datetime_to_unix( $value );

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
  global $conf;
  return "[". $params['phrase'] . "]";
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
      return null;
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
  global $conf, $form_stack, $page;

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

      // Compose the form action field
      if( $form_method == "POST" )
	{
	  $action = $page->getURL() . "&submit=" . $form_name;
	}
      else
	{
	  $action = $page->getURL();
	  $content = sprintf( "<input type=\"hidden\" name=\"page\" value=\"%s\"/>\n%s",
			      $page_name,
			      $content );
	}

      // Output the content enclosed within the form tags
      return "<form name=\"" . $form_name . "\" method=\"" . $form_method . 
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
      $message = $message_data['type'];
      if( isset( $message_data['args'] ) )
	{
	  foreach( $message_data['args'] as $i => $arg )
	    {
	      $message = str_replace( "{" . $i . "}", $arg, $message );
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

  if( !isset( $errors ) && !isset( $_SESSION['exceptions'] ) )
    {
      // No errors to display
      return null;
    }
  
  // Build error box HTML
  $html = "<p class=\"error\">\n";

  // Write all the error errors currently in the session
  if( isset( $errors ) )
    {
      foreach( $errors as $error_data )
	{
	  // Insert arguments into error errors
	  $error = $error_data['type'];
	  if( isset( $error_data['args'] ) )
	    {
	      foreach( $error_data['args'] as $i => $arg )
		{
		  $error = str_replace( "{" . $i . "}", $arg, $error );
		}
	    }
	  $html .= $error . "<br/>\n";
	}
    }

  // Write all the exceptions currently in the session
  if( isset( $_SESSION['exceptions'] ) )
    {
      foreach( $_SESSION['exceptions'] as $message )
	{
	  $html .= $message . "<br/>\n";
	}
    }

  $html .= "</p>\n";

  // Remove errors from session
  unset( $_SESSION['errors'] );
  unset( $_SESSION['exceptions'] );

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

  // Create the widget HTML
  $html = $page->getForm($form_name)->getFieldHTML( $form_field, $params );
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
  $form_field_description = $field_data['description'];
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

/**
 * Smarty Form Table
 *
 * Displays a TableWidget
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form_table( $params, $content, &$smarty, &$repeat )
{
  global $form_stack, $page, $tableWidget;

  // Access the TableWidget
  $tableWidget = $page->getForm( end( $form_stack ) )->getField( $params['field'] )->getWidget();
  if( !($tableWidget instanceof TableWidget) )
    {
      // The widget is not a TableWidget object
      throw new SWException( sprintf( "Field is not a TableWidget:\n\tForm: %s\n\tField: %s\n",
				      end( $form_stack ),
				      $params['field'] ) );
    }

  // Output something
  if( isset( $content ) )
    {
      // {/form_table} - End of the block
      try
	{
	  // Advance the table to the next row...
	  $row = $tableWidget->next();
	  $smarty->assign( $params['field'], $row );
	  
	  if( $tableWidget->showHeaders() )
	    {
	      $tableWidget->doNotShowHeaders();
	      echo $content;
	    }
	  else
	    {
	      echo "\t</tr>\n\t<tr>\n" . $content;
	    }

	  // ... and loop
	  $repeat = true;
	}
      catch( EndOfTableException $e )
	{
	  // No more records, stop looping
	  $repeat = false;
	  echo "\t</tr>\n\t<tr>\n" . $content;
	  echo $tableWidget->getTableFooterHTML();
	}
      catch( TableEmptyException $e )
	{
	  // Table is empty
	  $repeat = false;
	  echo $content;
	  echo $tableWidget->getTableEmptyHTML();
	  echo $tableWidget->getTableFooterHTML();
	}
    }
  else
    {
      // {form_table} - Beginning of the block
      $tableWidget->init( $params );
      echo $tableWidget->getTableHeaderHTML();
    }
}

/**
 * Smarty Form Table Column
 *
 * Handles the form_table_column tag.
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form_table_column( $params, $content, &$smarty, &$repeat )
{
  global $tableWidget;

  if( isset( $content ) )
    {
      // {/form_table_column} - End of the block
      if( $tableWidget->showHeaders() )
	{
	  // Display column header on the first loop through
	  echo $tableWidget->getColumnHeaderHTML( $params['columnid'],
						  $params['header'] );
	}
      else
	{
	  // Create a td tag and evaluate the contents
	  echo sprintf( "<td> %s </td>\n", $content );
	}
    }

  // {form_table_column} - Beginning of the block
  return ;
}

/**
 * Smarty Form Table Footer
 *
 * Handles the form_table_footer tag.
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form_table_footer( $params, $content, &$smarty, &$repeat )
{
  global $tableWidget;

  if( isset( $content ) )
    {
      $tableWidget->setFooterContent( $content );
    }
}

/**
 * Smarty Form Table Checkbox
 *
 * Displays the form table's checkbox field
 *
 * @param array $params Tag parameters
 * @param string $content Content of tags
 * @param object &$smarty Reference to the Smarty template
 * @param boolean &$repeat Repeat flag
 * @returns string Table HTML
 */
function smarty_form_table_checkbox( $params, &$smarty )
{
  global $tableWidget;
  echo $tableWidget->getCheckboxHTML( $params['option'] );
}
?>