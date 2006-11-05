<?php
/**
 * ConfigParser.class.php
 *
 * This file contains the definition for the ConfigParser class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ConfigParser
 *
 * Implements an XML parser for the application configuration file.  After
 * parsing, the configuration is stored into a PHP array.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ConfigParser
{
  /**
   * @var hash Configuration data
   */
  var $conf;

  /**
   * @var hash A stack of tags being processed
   */
  var $tag_stack;

  /**
   * @var string Name of the <module> tag currently being processed
   */
  var $module_name;

  /**
   * @var string Class name of the <page> tag currently being processed
   */
  var $page_class_name;

  /**
   * @var string Name of the <form> tag currently being processed
   */
  var $form_name;

  /**
   * @var string Name of the <field> tag currently being processed
   */
  var $form_field_name;

  /**
   * @var string Name of the <error> tag currently being processed
   */
  var $error_name;

  /**
   * @var string Name of the <message> tag currently being processed
   */
  var $message_name;

  /**
   * Constructor
   */
  function ConfigParser()
  {
    $this->conf = array( "modules" => array(), "pages" => array(), "forms" => array() );
  }

  /**
   * Start element
   *
   * Called by the XML parser for a begin-tag
   *
   * @param object $parser
   * @param string $tagName The name of the tag being processed
   * @param array $attrs An array of attributes provided for the tag
   */
  function startElement( $parser, $tagName, $attrs )
  {
    $this->tag_stack[] = $tagName;
    switch( $tagName )
      {
      case "APPLICATION":
	$this->conf = array( "modules" => array(),
			     "pages" => array(),
			     "forms" => array(),
			     "hooks" => array() );
	$this->conf['main_template'] = $attrs['MAIN_TEMPLATE'];
	$this->conf['controller'] = $attrs['CONTROLLER'];
	$this->conf['login_template'] = $attrs['LOGIN_TEMPLATE'];
	$this->conf['access_denied_template'] = $attrs['ACCESS_DENIED_TEMPLATE'];
	$this->conf['application_name'] = $attrs['APPLICATION_NAME'];
	$this->conf['authenticate_user'] = ($attrs['AUTHENTICATE_USER'] == "true");
	break;

      case "MODULE":
	$this->conf = array();
	$this->module_name = $attrs['NAME'];
	$this->conf['hooks'] = array();
	break;

      case "PAGES":
	$this->conf['pages'] = array();
	$this->conf['login_page'] = $attrs['LOGIN_PAGE'];
	$this->conf['home_page'] = $attrs['HOME_PAGE'];
	break;

      case "PAGE":
	$this->page_class_name = strtolower( $attrs['CLASS'] );
	$this->conf['pages'][$this->page_class_name]['name'] = $attrs['NAME'];
	$this->conf['pages'][$this->page_class_name]['title'] = $attrs['TITLE'];
	$this->conf['pages'][$this->page_class_name]['class_file'] = $attrs['CLASS_FILE'];
	$this->conf['pages'][$this->page_class_name]['parent'] = $attrs['PARENT'];
	$this->conf['pages'][$this->page_class_name]['url'] = $attrs['URL'];
	$this->conf['pages'][$this->page_class_name]['disabled'] = ($attrs['DISABLED'] == "true");

	$this->conf['pages'][$this->page_class_name]['templatedir'] = 
	  isset( $this->module_name ) ? 
	  "../../modules/" . $this->module_name . "/templates/" : 
	  "";

	if( isset( $this->module_name ) && isset( $attrs['HOOK'] ) )
	  {
	    $this->conf['hooks'][$this->module_name][$attrs['HOOK']] = $attrs['NAME'];
	  }
	break;

      case "TEMPLATES":
	$this->conf['pages'][$this->page_class_name]['templates'] = array();
	break;

      case "TEMPLATE":
	$template_name = $attrs['NAME'];
	$template_file = $attrs['FILE'];
	$this->conf['pages'][$this->page_class_name]['templates'][$template_name] =
	  $template_file;

      case "URLFIELDS":
	$this->conf['pages'][$this->page_class_name]['fields'] = array();
	break;

      case "URLFIELD":
	$name = $attrs['NAME'];
	$validator = $attrs['VALIDATOR'];
	$required = (strtolower( $attrs['REQUIRED'] ) == "true");
	$this->conf['pages'][$this->page_class_name]['fields'][$name]['validator'] = $validator;
	$this->conf['pages'][$this->page_class_name]['fields'][$name]['required'] = $required;
	break;

      case "FORMS":
	$this->conf['forms'] = array();
	break;

      case "FORM":
	$this->form_name = $attrs['NAME'];
	$this->conf['forms'][$this->form_name]['page'] = $attrs['PAGE'];
	$this->conf['forms'][$this->form_name]['method'] = $attrs['METHOD'];
	$this->conf['forms'][$this->form_name]['dbo_table_search'] = 
	  (strtolower( $attrs['DBO_TABLE_SEARCH'] ) == "true");
	break;

      case "FIELDS":
	$this->conf['forms'][$this->form_name]['fields'] = array();
	break;

      case "FIELD":
	$this->form_field_name = $attrs['NAME'];
	$field_data =& $this->conf['forms'][$this->form_name]['fields'][$this->form_field_name];
	$field_data['widget'] = $attrs['WIDGET'];
	$field_data['validator'] = $attrs['VALIDATOR'];
	$field_data['description'] = $attrs['DESCRIPTION'];
	$field_data['required'] = (strtolower( $attrs['REQUIRED'] ) == "true");
	$field_data['max_length'] = $attrs['MAX_LENGTH'];
	$field_data['min_length'] = $attrs['MIN_LENGTH'];
	$field_data['max_value'] = $attrs['MAX_VALUE'];
	$field_data['min_value'] = $attrs['MIN_VALUE'];
	$field_data['dbo'] = $attrs['DBO'];
	$field_data['remote'] = (strtolower( $attrs['remote_data'] ) == "true" );
	$field_data['valuefield'] = $attrs['VALUEFIELD'];
	$field_data['displayfield'] = $attrs['DISPLAYFIELD'];
	$field_data['default_value'] = $attrs['DEFAULT_VALUE'];
	$field_data['hash'] = $attrs['HASH'];
	$field_data['md5'] = (strtolower( $attrs['MD5'] ) == "true");
	$field_data['method_name'] = $attrs['METHOD_NAME'];
	$field_data['cancel'] = (strtolower( $attrs['CANCEL'] ) == "true");
	$field_data['array'] = (strtolower( $attrs['ARRAY'] ) == "true");
	break;

      case "COLUMNS":
	$this->conf['forms'][$this->form_name]['fields'][$this->form_field_name]['columns'] = array();
	break;

      case "ENUM":
	$this->conf['forms'][$this->form_name]['fields'][$this->form_field_name]['enum'] =
	  array();
	break;

      case "OPTION":
	$value = $attrs['VALUE'];
	$description = $attrs['DESCRIPTION'];
	$default = ($attrs['DEFAULT'] == "true");
	if( isset( $description ) )
	  {
	    $this->conf['forms'][$this->form_name]['fields'][$this->form_field_name]['enum'][$value] =
	      $description;
	  }
	else
	  {
	    $this->conf['forms'][$this->form_name]['fields'][$this->form_field_name]['enum'][$value] =
	      $value;
	  }

	if( $default )
	  {
	    $this->conf['forms'][$this->form_name]['fields'][$this->form_field_name]['default_value'] =
	      $value;
	  }
	break;

      case "COLUMN":
	$this->conf['forms'][$this->form_name]['fields'][$this->form_field_name]['columns'][$attrs['FIELD']]['header'] = $attrs['HEADER'];
	break;

      case "ERRORS":
	$this->conf['errors'] = array();
	break;

      case "ERROR":
	$this->error_name = $attrs['NAME'];
	$this->conf['errors'][$attrs['NAME']] = "";
	break;

      case "MESSAGES":
	$this->conf['messages'] = array();
	break;

      case "MESSAGE":
	$this->message_name = $attrs['NAME'];
	$this->conf['messages'][$attrs['NAME']] = "";
	break;

      default:
	echo "unrecognized tag: " . $tagName . "\n";
	break;
      }
  }

  /**
   * Start Setting Tag
   *
   * Process the start of a 'setting' tag
   *
   * @param string $name Name of setting
   * @param string $value Value to apply to setting
   */
  function startSetting( $name, $value )
  {
    $last_tag = $this->tag_stack[count( $this->tag_stack ) - 2];
    switch( $last_tag )
      {
      case "MODULE":
	$this->conf['modules'][$this->module_name][$name] = $value;
	break;

      default:
	echo "SETTING not valid in this context: " . $last_tag;
	break;
      }
  }

  /**
   * End Element
   *
   * Process the end of an element.
   *
   * @param object $parser
   * @param string $tagName The tag being closed
   */
  function endElement( $parser, $tagName )
  {
    array_pop( $this->tag_stack );
    switch( $tagName )
      {
      case "MODULE":
	unset( $this->module_name );
	break;

      case "PAGE":
	unset( $this->page_class_name );
	break;

      case "FORM":
	unset( $this->form_name );
	break;

      case "FIELD":
	unset( $this->form_field_name );
	break;

      case "ERROR":
	unset( $this->error_name );
	break;

      case "MESSAGE":
	unset( $this->message_name );
	break;
      }
  }

  /**
   * Process Character Data
   *
   * Process the character data that appears between tags.
   *
   * @param object $parser
   * @param string $data Character data
   */
  function characterData( $parser, $data )
  {
    $tag_name = $this->tag_stack[count( $this->tag_stack ) - 1];
    switch( $tag_name )
      {
      case "ERROR":
	$this->conf['errors'][$this->error_name] .= $data;
	break;

      case "MESSAGE":
	$this->conf['messages'][$this->message_name] .= $data;
	break;
      }
  }

  /**
   * Get Config Array
   *
   * Returns a copy of the configuration data
   *
   * @return array Configuration data
   */
  function getConfig()
  {
    return $this->conf;
  }
}
?>