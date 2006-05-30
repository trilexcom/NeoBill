<?php
/**
 * Page.class.php
 *
 * This file contains the definition of the Page class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Validation functions
require_once "validate.php";

// Country Code list is this field's enum
require_once "cc.php";

/**
 * Page
 *
 * Provides a base for all Pages in the application.  Loads the template, provides
 * navigational functions, handles state, and validates forms.  All Page's in the
 * application are a descendant of this class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class Page
{
  /**
   * @var string Name of the implementation class
   */
  var $class_name = "page";

  /**
   * @var string Page name
   */
  var $name = "blank_page";

  /**
   * @var string Page title
   */
  var $title = "blank page";

  /**
   * @var string Template name
   */
  var $template = null;

  /**
   * @var string Template directory
   */
  var $templatedir = null;

  /**
   * @var string Template file
   */
  var $template_file = "PageNotFound.tpl";

  /**
   * @var string Parameters appended to the URL for this page
   */
  var $url = "page=error";

  /**
   * @var hash Pages that appear above this Page in the navigation bar
   */
  var $location_stack = array();

  /**
   * @var hash Forms handled by this page
   */
  var $forms = array();

  /**
   * @var hash Reference to this Page's session data
   */
  var $session;

  /**
   * @var boolean Page disabled (if true)
   */
  var $disabled;

  /**
   * @var object Smarty object
   */
  var $smarty;

  /**
   * @var object Database object
   */
  var $DB;

  /**
   * @var array Configuration
   */
  var $conf;

  /**
   * Constructor
   */
  function Page( )
  {
  }

  /**
   * Load
   *
   * Loads the page title, page name, url, location stack, and form configuration
   * from the config file.
   *
   * @param array $conf Application configuration data
   * @param Smarty $smarty Smarty object
   * @param DBConnection $DB Database object
   */
  function load( $conf, $smarty, $DB )
  {
    $this->conf = $conf;
    $this->smarty = $smarty;
    $this->DB = $DB;

    if( get_class( $this ) != "Page" )
      {
	// This is a subclass - load the page data from the configuration data
	$page_data = $conf['pages'][$this->getClassName()];
	$this->setTitle( $page_data['title'] );
	$this->setName( $page_data['name'] );
	$this->setUrl( $page_data['url'] );
	$this->setLocationStack( $page_data['location_stack'] );
	$this->setTemplate( "default" );
	$this->setTemplateDir( $page_data['templatedir'] );

	// This page is disabled according to the configuration file
	if( $page_data['disabled'] )
	  {
	    $this->disable();
	  }

	// Load any forms configured for this Page
	foreach( $conf['forms'] as $form_name => $form_data )
	  {
	    if( $form_data['page'] == $this->getName() )
	      {
		// Add this form
		$this->addForm( $form_name );
	      }
	  }

	if( !isset( $_SESSION[$this->getName()] ) )
	  {
	    // Create a place holder in the session for this Page's data
	    $_SESSION[$this->getName()] = array();
	  }

	// Point to the session data for this Page
	$this->session =& $_SESSION[$this->getName()];
      }
  }

  /**
   * Disable
   *
   * Disables the page
   */
  function disable() { $this->disabled = true; }

  /**
   * Is Disabled
   *
   * Returns true if this page is disabled
   */
  function isDisabled() { return ($this->disabled == true); }

  /**
   * Validate Form
   *
   * Validate each field on the form according to the validation parameters
   * set in the config file.  If a field is invalid, set an error and return false.
   * Only forms explicity configured for this page are allowed to be submitted.
   *
   * @param string $form_name Form name
   * @return boolean True if form validated OK
   */
  function validate_form( $form_name )
  {
    global $cc;
    $conf =& $this->conf;

    // Initialize errors
    $errors = array();

    // Clear form data from session
    unset( $this->session[$form_name] );

    // Access form fields configuration
    $fields = $conf['forms'][$form_name]['fields'];

    // Stop if a 'cancel' field is in the posted data
    foreach( $fields as $field_name => $field_data )
      {
	if( $field_data['type'] == "cancel" && isset( $_POST[$field_name] ) )
	  {
	    // Form canceled
	    $this->session[$form_name][$field_name] = $_POST[$field_name];
	    return true;
	  }
      }

    // Validate each field in this form
    foreach( $fields as $field_name => $field_data )
      {
	$field_data['name'] = $field_name;
	if( is_array( $_POST[$field_name] ) )
	  {
	    foreach( $_POST[$field_name] as $key => $value )
	      {
		$_POST[$field_name][$key] = form_field_filter( $field_data, 
							       $value );
	      }
	    $posted_data = $_POST[$field_name];
	  }
	else
	  {
	    $posted_data = form_field_filter( $field_data, $_POST[$field_name] );
	  }

	if( strlen( $posted_data ) == 0 && !$field_data['required'] )
	  {
	    if( $field_data['type'] == "checkbox" )
	      {
		$this->session[$form_name][$field_name] = false;
	      }

	    // Validation not required
	    continue;
	  }

	if( $field_data['required'] && strlen( $posted_data ) == 0 )
	  {
	    // Required field is missing
	    $this->setError( array( "type"       => "FIELD_MISSING",
				    "field_name" => $field_name,
				    "args"       => array( $field_data['description'] ) ) );
	    continue;
	  }

	if( $field_data['validate'] )
	  {
	    // Validate this field
	    switch( $field_data['type'] )
	      {
	      case "checkarray":
		if( isset( $field_data['hash'] ) )
		  {
		    $field_data['enum'] = $this->session[$field_data['hash']];
		  }
		if( ($error = validate_checkarray( $field_data, $posted_data ) ) )
		  {
		    $this->setError( $error );
		    continue;
		  }
		break;

	      case "table":
		$field_data['enum'] = $this->session[$field_name]['values'];
		if( ($error = validate_table( $field_data, $posted_data ) ) )
		  {
		    $this->setError( $error );
		    continue;
		  }
		break;

	      case "ipaddress":
		// Parts go left to right
		$ip_parts[0] = intval( $posted_data );
		$ip_parts[1] = intval( $_POST[$field_name . "_2"] );
		$ip_parts[2] = intval( $_POST[$field_name . "_3"] );
		$ip_parts[3] = intval( $_POST[$field_name . "_4"] );
		$posted_data = 0;
		if( ($error = validate_ipaddress( $field_data, $ip_parts )) != null )
		  {
		    $this->setError( $error );
		    continue;
		  }
		$posted_data = 
		  ($ip_parts[0] << 24) |
		  ($ip_parts[1] << 16) |
		  ($ip_parts[2] << 8) |
		  ($ip_parts[3]);
		break;

	      case "telephone":
		$phone['cc'] = $_POST[$field_name . "_cc"];
		$phone['area'] = $_POST[$field_name . "_area"];
		$phone['number'] = str_replace( "-", "", $posted_data );
		if( ($error = validate_phone( $field_data, $phone )) != null )
		  {
		    // Invalid phone number
		    $this->setError( $error );
		    $posted_data = "1-555-5555";
		    continue;
		  }
		$posted_data = format_phone_number( $phone );
		break;

	      case "date":
		$date['month'] = intval($posted_data) + 1;
		$date['day'] = intval( $_POST[$field_name . "_day"] );
		$date['year'] = intval( $_POST[$field_name . "_year"] );
		if( ($error = validate_date( $field_data, $date )) != null )
		{
		  // Invalid date
		  $this->setError( $error );

		  // Reset field to now
		  $posted_data = time();
		  continue;
		}

		// Store date as a timestamp
		$posted_data = mktime( 0, 0, 1, 
				       $date['month'], 
				       $date['day'], 
				       $date['year'] );
		break;

	      case "db_select":
		if( ($error = validate_db_select( $field_data, $posted_data )) != null )
		  {
		    // Value received was not found in the database
		    $this->setError( $error );
		    continue;
		  }
		break;

	      case "country":
		$field_data['enum'] = $cc;

	      case "radio":
	      case "select":
		// Determine the correct location of accepted values
		if( isset( $field_data['hash'] ) )
		  {
		    $field_data['enum'] = $this->session[$field_data['hash']];
		  }
		if( isset( $field_data['method_name'] ) )
		  {
		    $field_data['enum'] = 
		      call_user_func( array( $this, 
					     $field_data['method_name'] ) );
 		  }

		if( ($error = validate_select( $field_data, $posted_data )) != null )
		  {
		    // Value received is not a valid select option
		    $this->setError( $error );
		    continue;
		  }
		break;

	      case "checkbox":
		$posted_data = true;
		break;

	      case "int":
		// Force an integer value
		$posted_data = intval( $posted_data );

	      case "float":
	      case "dollar":
		if( ($error = validate_number( $field_data, $posted_data )) != null )
		  {
		    // Bad number
		    $this->setError( $error );
		    continue;
		  }
		break;

	      case "email":
		if( ($error = validate_length( $field_data, $posted_data )) != null )
		  {
		    // Bad length
		    $this->setError( $error );
		    continue;
		  }
		if( ($error = validate_email( $field_data, $posted_data )) != null )
		  {
		    // Not an email address
		    $this->setError( $error );
		    continue;
		  }
		break;

	      case "password":
	      case "textarea":
	      case "text":
		if( ($error = validate_length( $field_data, $posted_data )) != null )
		  {
		    // Bad length
		    $this->setError( $error );
		    continue;
		  }
		break;

	      default:

		// Field type not recognized
		fatal_error( $this->getClassName(),
			     "Invalid field type: " . $field_data['type'] );
	      }
	  }

	// Store field contents in session
	// If it's a password field, md5 it
	$this->session[$form_name][$field_name] = 
	  $field_data['md5'] ? md5( $posted_data ) : $posted_data;
      }

    // Return true if no errors in page
    return !$this->hasErrors();
  }

  /**
   * Jump Back
   *
   * Jump $steps number of pages backwards on the navigation stack.  The default
   * is to step back 2 pages.  When you submit a form, you have already moved
   * forward 1 page on the navigation stack, therefor stepping back 2 pages will
   * place you on the page you were at before the form was submitted.  If you wish
   * to go back to the form, pass 1.
   *
   * @param integer $steps Number of pages to jump back
   */
  function goback( $steps = 2 )
  {
    for( $i = 0; $i < $steps; $i++ )
      {
	// Pop off this page's entry on the navstack
	$url = array_pop( $_SESSION['navstack'] );
      }

    if( isset( $url ) )
      {
	// Jump back
	header( "Location: " . $url );
      }

    // Nav stack is empty
    fatal_error( $this->getClassName(), "No page to jump back too!" );
  }

  /**
   * Push URL
   *
   * Push this page's URL onto the stack
   */
  function pushURL()
  {
    $_SESSION['url_stack'][] = $_SERVER['REQUEST_URI'];
  }

  /**
   * Pop URL
   *
   * Pop a URL off the stack
   *
   * @return string URL from the top of the stack
   */
  function popURL()
  {
    $url = array_pop( $_SESSION['url_stack'] );
    header( "Location: " . $url );
  }

  /**
   * Page Jump
   *
   * Redirects the user to the Page specified in $page_name.  You may specify a
   * message to pass along to the new Page, and/or append URL variables.
   *
   * @param string $page_name Page name
   * @param hash $messages Messages to attach to new page (deprecated)
   * @param string $url_tail Query string to attach to URL
   */
  function goto( $page_name, $messages = null, $url_tail = null )
  {
    $conf =& $this->conf;

    // Find page
    foreach( $conf['pages'] as $page_key => $page_data )
      {
	if( $page_data['name'] == $page_name )
	  {
	    // Page found
	    if( isset( $messages ) )
	      {
		// Hand messages over to new page
		$_SESSION[$page_data['name']]['messages'] = $messages;
	      }

	    // Redirect client
	    $url = $page_data['url'];
	    if( isset( $url_tail ) )
	      {
		// Append URL
		$url .= "&" . $url_tail;
	      }
	    header( "Location: " . $url );

	    // Do not continue
	    exit();
	  }
      }

    if( !isset( $url ) )
      {
	// Page not found
	fatal_error( $this->getClassName(), 
		     "Attempted jump to an invalid page: " . $page_name );
      }
  }

  /**
   * Hook Goto
   *
   * Jump to the appropiate page for the specified hook and module
   *
   * @param string $moduleName The name of the module
   * @param string $hook The name of the hook
   */
  function hookGoto( $moduleName, $hook, $queryString = null )
  {
    if( !isset( $this->conf['hooks'][$moduleName][$hook] ) )
      {
	fatal_error( "Page::hookGoto()",
		     "Invalid modules or hook: " . $hook . "(" . $moduleName . ")" );
      }

    $this->goto( $this->conf['hooks'][$moduleName][$hook], null, $queryString );
  }


  /**
   * Get Last Page
   *
   * @return string The name of the last page served
   */
  function getLastPage() { return $_SESSION['lastpage']; }

  /**
   * Get Page Session
   *
   * Return a reference to this page's session data
   *
   * @return array Reference to page's session data
   */
  function &getPageSession()
  {
    return $this->session;
  }

  /**
   * Set Message
   *
   * Set a message in the Page session
   *
   * @param array $message Message data
   */
  function setMessage( $message )
  {
    $_SESSION['messages'][] = $message;

    // Insert arguments into message
    $text = translate( $this->conf['locale']['language'], $message['type'] );
    if( isset( $message['args'] ) )
      {
	foreach( $message['args'] as $i => $arg )
	  {
	    $text = str_replace( "{" . $i . "}", 
				 translate_string( $this->conf['locale']['language'], $arg ),
				 $text );
	  }
      }
    log_notice( $this->getClassName(), $text );
  }

  /**
   * Set Error
   *
   * Set an error in the Page session
   *
   * @param array $error Error data
   */
  function setError( $error )
  {
    $_SESSION['errors'][] = $error;

    // Insert arguments into message
    $text = translate( $this->conf['locale']['language'], $error['type'] );
    if( isset( $error['args'] ) )
      {
	foreach( $error['args'] as $i => $arg )
	  {
	    $s = translate_string( $this->conf['locale']['language'], $arg );
	    $text = str_replace( "{" . $i . "}", 
				 $s,
				 $text );
	  }
      }
    log_error( $this->getClassName(), $text );
  }

  /**
   * Set Navigation Variable.
   *
   * Navigation variables are used to place values into the navigation stack
   * display at the top of the content page.  For example - a customer name can
   * be used as a value for a nav variable in place of something less descriptive.
   *
   * @param string $name Name of navvar
   * @param string $value Value
   */
  function setNavVar( $name, $value )
  {
    $_SESSION['nav_vars'][$name] = $value;
  }
  
  /**
   * Page Has Error(s)
   *
   * Reveal if any errors are set for this page
   *
   * @return boolean True if page has any errors
   */
  function hasErrors()
  {
    return count( $_SESSION['errors'] ) > 0;
  }

  /**
   * Action
   *
   * A page's "action" parameter tells it what to do.  Often the action is the
   * name of a form that is being submitted to the page.  Every page should
   * declare it's own action() method.  As a default, it should refer to it's
   * parent's action() method to ensure that upper-level actions are preformed.
   * At the top level (here), the "logout" action is preformed - which simply
   * logs the user out of the application.
   *
   * @param string $action_name Action name
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "logout":
	// Log the client out by redirecting to the default URL
	header( "Location: manager_content.php" );
	break;

      default:
	print( "error: invalid action: " . $action_name );
      }
  }

  /**
   * Control Access
   *
   * Any page that restricts access to certain users or user type will need to
   * override this function to preform the appropriate security checks.  A
   * return value of true indicates that the user is allowed to access this page.
   *
   * @return boolean True if access is granted;
   */
  function control_access()
  {
    // Default to allowing access
    return true;
  }

  /**
   * Get Forms
   *
   * Return the forms associated with this page
   *
   * @return array Forms associated with this page
   */
  function getForms()
  {
    return $this->forms;
  }

  /**
   * Registers a form to be handled by this Page
   *
   * @param string $form_name
   */
  function addForm( $form_name )
  {
    array_push( $this->forms, $form_name );
  }

  /**
   * Get Location Stack
   *
   * Return a copy of the location stack
   *
   * @return array Location stack
   */
  function getLocationStack()
  {
    return $this->location_stack;
  }

  /**
   * Set Location Stack
   *
   * @param array $location_stack Location stack
   */
  function setLocationStack( $location_stack )
  {
    $this->location_stack = $location_stack;
  }

  /**
   * Get Page Name
   *
   * @return string Page name
   */
  function getName()
  {
    return $this->name;
  }

  /**
   * Assign Page name
   *
   * @param string $name Page name
   */
  function setName( $name )
  {
    $this->name = $name;
  }

  /**
   * Get Page Title
   *
   * @return string Page title
   */
  function getTitle()
  {
    return $this->title;
  }

  /**
   * Assign Page Title
   *
   * @param string $title Page title
   */
  function setTitle( $title )
  {
    $this->title = translate_string( $this->conf['locale']['language'], $title );
  }

  /**
   * Return the Page's URL
   *
   * @return string Page URL
   */
  function getUrl()
  {
    return $this->url;
  }

  /**
   * Set the Page's URL
   *
   * @param string $url Page URL
   */
  function setUrl( $url )
  {
    $this->url = $url;
  }

  /**
   * Return the current template directory
   *
   * @return string Template directory
   */
  function getTemplateDir()
  {
    return $this->templateDir;
  }

  /**
   * Set Current Template directory
   *
   * @param string $file_name Template directory
   */
  function setTemplateDir( $dir )
  {
    $this->templateDir = $dir;
  }

  /**
   * Return the current template's filename
   *
   * @return string Template filename
   */
  function getTemplateFile()
  {
    return $this->getTemplateDir() . $this->template_file;
  }

  /**
   * Set Current Template's Filename
   *
   * @param string $file_name Template filename
   */
  function setTemplateFile( $file_name )
  {
    $this->template_file = $file_name;
  }

  /**
   * Set Current Template
   *
   * @param string $template_name Template name
   */
  function setTemplate( $template_name )
  {
    $conf =& $this->conf;

    // Read configuration for template_name
    $page_data = $conf['pages'][$this->getClassName()];

    if( !isset( $page_data['templates'][$template_name] ) )
      {
	// Template name is invalid
	fatal_error( $this->getClassName(),
		     "invalid template name: " . $template_name );
      }

    // Set the template file name
    $this->setTemplateFile( $page_data['templates'][$template_name] );
    $this->template = $template_name;
  }

  /**
   * Get Name of the Current Template
   *
   * @return string Current template name
   */
  function getTemplate()
  {
    return $this->template;
  }

  /**
   * Get Class Name
   *
   * Returns the class name.  This fixes the problem caused by the get_class()
   * function not working the same under PHP 5 as it did under PHP 4.
   *
   * @return string Class name
   */
  function getClassName()
  {
    return strtolower( $this->class_name );
  }
}

?>
