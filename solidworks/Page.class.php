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
require "Form.class.php";

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
   * @var array Configuration
   */
  var $conf;

  /**
   * @var array URL Field/Value pairs
   */
  protected $urlFields = array();

  /**
   * @var array Processed GET fields
   */
  protected $get = array();

  /**
   * @var array Processed POST fields
   */
  protected $post = array();

  /**
   * @var Form A form representing fields passed through the URL
   */
  protected $urlForm = null;

  /**
   * @var array An array of Forms configured for this page
   */
  protected $forms = null;

  /**
   * @var array Widget vars
   */
  protected $widgetVars = array();

  /**
   * Select Template File
   *
   * Based on the theme, return the template file to be used
   *
   * @param string $fileName The name of the template file
   * @return string The full path to the correction template file to use
   */
  public static function selectTemplateFile( $fileName, $defaultDir = "" )
  {
    global $conf;

    $templateFileName = $defaultDir . $fileName;
    if( $conf['themes']['current'] == "default" )
      {
	// Default theme just returns the template file from the templates/ dir
	return $templateFileName;
      }
    else
      {
	// Build the theme's template file name
	// Smarty loads the template file relative to the parent directory - thus
	// the "../" bellow but not here.
	$themeTemplateFileName = sprintf( "themes/%s/%s", 
					  $conf['themes']['current'],
					  $fileName );

	// If the template file exists in the theme dir, then return that one,
	// otherwise return the default template file
	return @fopen( $themeTemplateFileName, "r" ) ? 
	  "../" . $themeTemplateFileName : $templateFileName;
      }
  }

  /**
   * Constructor
   */
  public function __construct()
  {
  }

  /**
   * Init
   *
   * Initialize the page.  Validate the GET fields.
   */
  function init()
  {
    // Remove control fields from the query
    $getData = $_GET;
    unset( $getData['page'] );
    unset( $getData['submit'] );
    unset( $getData['action'] );
    unset( $getData['no_headers'] );

    // Add some control fields to the parameter list

    // Table name
    $this->urlForm->addFormField( new FormField( "url",
						 "swtablename",
						 null,
						 "text",
						 null ) );

    // Table form name
    $this->urlForm->addFormField( new FormField( "url",
						 "swtableform",
						 null,
						 "text",
						 null ) );

    // Table sort direction
    $SWTableSortDir = new FormField( "url",
				     "swtablesortdir",
				     null,
				     "choice",
				     array( "enum" => array( "ASC" => "Ascending",
							     "DESC" => "Descending" ) ) );
    $this->urlForm->addFormField( $SWTableSortDir );
    
    // Table sort column
    $this->urlForm->addFormField( new FormField( "url",
						 "swtablesortcol",
						 null,
						 "text",
						 null ) );

    // Table start position
    $this->urlForm->addFormField( new FormField( "url",
						 "swtablestart",
						 null,
						 "int",
						 array( "min_value" => 0 ) ) );
    
    // Process the query string
    $this->get = $this->urlForm->process( $getData );
  }

  /** 
   * Process Form 
   * 
   * Validate each field on the form according to the validation parameters 
   * set in the config file.  If a field is invalid, set an error and return false. 
   * Only forms explicity configured for this page are allowed to be submitted. 
   * 
   * @param string $form_name Form name 
   * @return boolean True if form validated OK 
   */ 
  function processForm( $form_name ) 
  { 
    // Initialize errors 
    $errors = array(); 
    
    // Clear form data from session 
    unset( $this->session[$form_name] ); 
    
    // Proccess POST data 
    try 
      { 
	if( !isset( $this->forms[$form_name] ) ) 
	  { 
	    throw new SWException( "Invalid form name: " . $form_name ); 
	  } 
	
	$this->post =& $this->session[$form_name]; 
	$this->session[$form_name] = $this->forms[$form_name]->process( $_POST ); 
      } 
    catch( InvalidFormException $e ) 
      { 
	// Create a page error for each invalid field 
	foreach( $e->getFieldExceptions() as $fieldException ) 
	  { 
	    $this->exception( $fieldException ); 
	  } 
	
	// Store form data in the session 
	$this->session[$form_name] = $e->getFormData(); 
	
	return false; 
      } 
    
    // Return true if no errors in page 
    return true; 
  }

  /**
   * Search Table
   *
   * Set the search criteria (provided in $this->post) on a TableWidget
   *
   * @param string $formName The form containing the table to search
   * @param string $tableField The name of the table field
   * @param array $criteria An array of search criteria: columnid => search value
   */
  protected function searchTable( $formName, $tableField, $criteria )
  {
    // Access the table widget
    $widget = $this->forms[$formName]->getField( $tableField )->getWidget();

    // Setup the search criteria
    foreach( $criteria as $columnid => $searchval )
      {
	$widget->setSearchCriteria( $columnid, $searchval );
      }
  }
  
  /**
   * Set Widget Var
   *
   * Widgets vars are used for communication between the Page object and
   * form widgets.
   *
   * @param string $var Name of the variable to set
   * @param mixed $value Variable value
   */
  function setWidgetVar( $var, $value ) { $this->widgetVars[$var] = $value; }

  /**
   * Get Widget Var
   *
   * Widgets vars are used for communication between the Page object and
   * form widgets.
   *
   * @param string $var Name of the variable to read
   */
  function getWidgetVar( $var ) { return $this->widgetVars[$var]; }

  /**
   * Get URL Fields and Values
   *
   * Returns the URL field names and values
   *
   * @return array URL Fields and data as fieldName => value
   */
  public function getURLFieldData() { return $this->urlFields; }

  /**
   * Set a URL Field
   *
   * Set a field and a value to be included in the URL query for this page
   *
   * @param string $fieldName The name of the URL field
   * @param string $value Value
   */
  function setURLField( $fieldName, $value )
  {
    $this->urlFields[$fieldName] = $value;
  }

  /**
   * Clear a URL Field
   *
   * @param string $fieldName Field to be cleared
   */
  function clearURLField( $fieldName ) { unset( $this->urlFields[$fieldName] ); }

  /**
   * Load
   *
   * Loads the page title, page name, url, location stack, and form configuration
   * from the config file.
   *
   * @param array $conf Application configuration data
   * @param Smarty $smarty Smarty object
   */
  function load( $conf, $smarty )
  {
    $this->conf = $conf;
    $this->smarty = $smarty;

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

	// Configure the URL form
	$this->urlForm = new Form( "url", $page_data );

	// Load any forms configured for this Page
	foreach( $conf['forms'] as $form_name => $form_data )
	  {
	    if( $form_data['page'] == $this->getName() )
	      {
		// Add this form
		$this->addForm( new Form( $form_name, $form_data ) );
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
   * Display Exception
   *
   * @param SWException $e Exception to be passed to the presentation layer
   */
  function exception( $e )
  {
    $_SESSION['exceptions'][] = $e->__toString();
  }

  /**
   * Is Disabled
   *
   * Returns true if this page is disabled
   */
  function isDisabled() { return ($this->disabled == true); }

  /**
   * Get Form
   *
   * @param string $formName The name of the form
   * @return Form A reference to the named form object
   */
  public function &getForm( $formName )
  {
    if( !isset( $this->forms[$formName] ) )
      {
	throw new SWException( "Form not found: " . $formName );
      }

    return $this->forms[$formName];
  }

  /**
   * Jump Back
   */
  public function goback()
  {
    // Pop off this page's entries on the navstack
    $lastPage = array_pop( $_SESSION['navstack'] );
    while( $lastPage['page'] == $this->getName() )
      {
	$lastPage = array_pop( $_SESSION['navstack'] );
      }

    if( isset( $lastPage ) )
      {
	// Jump back
	header( "Location: " . $lastPage['url'] );
	exit();
      }

    // Nav stack is empty
    fatal_error( $this->getClassName(), "No page to jump back too!" );
  }

  /**
   * Reload the Current Page
   *
   * Reloads the current page
   */
  public function reload()
  {
    header( "Location: " . $this->getURL() );
    exit();
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

	    // Push the current location onto the navstack
	    $_SESSION['navstack'][] = array( "page" => $this->getName(), 
					     "url" => $this->getURL() );

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
    $text = $message['type'];
    if( isset( $message['args'] ) )
      {
	foreach( $message['args'] as $i => $arg )
	  {
	    $text = str_replace( "{" . $i . "}", $arg, $text );
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
    $text = $error['type'];
    if( isset( $error['args'] ) )
      {
	foreach( $error['args'] as $i => $arg )
	  {
	    $text = str_replace( "{" . $i . "}", $arg, $text );
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
      case "swtablesort":
	$this->session['tables']['sortform'] = $this->get['swtableform'];
	$this->session['tables']['sorttable'] = $this->get['swtablename'];
	$widget = $this->forms[$this->get['swtableform']]->getField( $this->get['swtablename'] )->getWidget();
	$widget->setSortCol( $this->get['swtablesortcol'] );
	$widget->setSortDir( $this->get['swtablesortdir'] );
	$widget->setStartIndex( 0 );
	break;

      case "swtablescroll":
	$widget = $this->forms[$this->get['swtableform']]->getField( $this->get['swtablename'] )->getWidget();
	$widget->setStartIndex( $this->get['swtablestart'] );
	break;

      case "logout":
	// Log the client out by redirecting to the default URL
	header( "Location: manager_content.php" );
	break;

      default:
	throw new SWUserException( "Invalid action: " . $action_name );
	break;
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
   * @param Form A Form object
   */
  function addForm( $form ) { $this->forms[$form->getName()] = $form; }

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
    $this->title = $title;
  }

  /**
   * Return the Page's URL
   *
   * @return string Page URL
   */
  function getUrl()
  {
    // Build the basic URL
    $url = sprintf( "%s?page=%s", $this->conf['controller'], $this->getName() );

    // Add any URL fields
    foreach( $this->getURLFieldData() as $key => $value )
      {
	$url .= sprintf( "&%s=%s", $key, $value );
      }
    
    // Replace Nav Vars with their values
    if( $_SESSION['nav_vars'] != null )
      {
	foreach( $_SESSION['nav_vars'] as $name => $value )
	  {
	    $url = str_replace( "{" . $name . "}", $value, $url);
	  }
      }
    
    return $url;
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
    return Page::selectTemplateFile( $this->template_file, $this->getTemplateDir() );
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
    // Read configuration for template_name
    $page_data = $this->conf['pages'][$this->getClassName()];

    if( !isset( $page_data['templates'][$template_name] ) )
      {
	// Template name is invalid
	throw new SWException( "Invalid template name: " . $template_name );
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
