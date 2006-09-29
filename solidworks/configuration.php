<?php
/**
 * configuration.php
 *
 * This file loads the application configuration (application.conf), then prepares 
 * the execution environment for the rest of the application.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once "log.php";
require_once "ConfigParser.class.php";
require_once "TranslationParser.class.php";
require_once "DBConnection.class.php";
require_once "language.php";

// Load Smarty
require_once "smarty/Smarty.class.php";

// Create a Smarty object
$smarty = new Smarty();

// Set Smarty directories
$smarty->template_dir = "/templates";
$smarty->compile_dir  = "../solidworks/smarty/templates_c";
$smarty->cache_dir    = "../solidworks/smarty/cache";
$smarty->config_dir   = "../solidworks/smarty/configs";

// Setup custom error handler
// set_error_handler( "SWErrorHandler" );

// Turn off notices
error_reporting( E_ALL ^ E_NOTICE );
  
// Load application configuration
$conf = load_config_file( "application.conf" );

// Load the translations/language file
$translations = load_translations_file( "translations" );

// Setup database communication
$conf['db'] = $db;
$DB = new DBConnection;

// Load the installed modules
loadModules();

// Load page classes
if( isset( $conf['pages'] ) )
{
  if( !isset( $_GET['page'] ) )
    {
      $_GET['page'] = $conf['home_page'];
    }

  foreach( $conf['pages'] as $class_name => $page_data )
    {
      if( isset( $page_data['class_file'] ) &&
	  $_GET['page'] == $page_data['name'] )
	{
	  require_once BASE_PATH . $page_data['class_file'];
	}
    }
}

/**
 * Load Application Configuration
 *
 * Instantiates the ConfigParser to load the application.conf XML file.
 *
 * @param string $file Path to application.conf
 * @return array Configuration data
 */
function load_config_file( $file )
{
  $xml_parser = xml_parser_create();
  $config_parser = new ConfigParser();
  xml_set_object( $xml_parser, $config_parser );
  xml_set_element_handler( $xml_parser, "startElement", "endElement" );
  xml_set_character_data_handler( $xml_parser, "characterData" );

  if( !($fp = @fopen( $file, "r" )) )
    {
      return $config_parser->getConfig();
    }

  while( $data = fread( $fp, 4096 ) )
    {
      xml_parse( $xml_parser, $data, feof( $fp ) )
	or die( sprintf( "<pre>There is an error in your application.conf:\n %s at line %d</pre>",
			 xml_error_string( xml_get_error_code( $xml_parser ) ),
			 xml_get_current_line_number( $xml_parser ) ) );
    }
  fclose( $fp );

  xml_parser_free( $xml_parser );

  return $config_parser->getConfig();
}

/**
 * Load Translations
 *
 * Instantiates the TranslationParser to load the translations/language XML file.
 *
 * @param string $file Path to the translations file
 * @return array Configuration data
 */
function load_translations_file( $file )
{
  $xml_parser = xml_parser_create();
  $translation_parser = new TranslationParser();
  xml_set_object( $xml_parser, $translation_parser );
  xml_set_element_handler( $xml_parser, "startElement", "endElement" );
  xml_set_character_data_handler( $xml_parser, "characterData" );

  if( !($fp = @fopen( $file, "r" )) )
    {
      return null;
    }

  while( $data = fread( $fp, 4096 ) )
    {
      xml_parse( $xml_parser, $data, feof( $fp ) )
	or die( sprintf( "<pre>There is an error in your translations file:\n %s at line %d</pre>",
			 xml_error_string( xml_get_error_code( $xml_parser ) ),
			 xml_get_current_line_number( $xml_parser ) ) );
    }
  fclose( $fp );

  xml_parser_free( $xml_parser );

  return $translation_parser->getTranslations();
}

/**
 * Generate Location Stack
 *
 * Generate a location stack for each page.
 *
 * @param array &$conf Configuration
 */
function generate_location_stack( &$conf )
{
  if( isset( $conf['pages'] ) )
    {
      foreach( $conf['pages'] as $class_name => $page_data )
	{
	  $conf['pages'][$class_name]['location_stack'] = 
	    build_location_stack( $page_data['name'] );
	}
    }
}

/**
 * Build Location Stack
 *
 * Build a location stack for a given page (recursive)
 *
 * @return array A reference to the location stack.
 */
function &build_location_stack( $page_name )
{
  global $conf;

  $page_data =& $conf['pages'][get_page_class( $page_name )];

  if( $page_data['parent'] != null )
    {
      // Use recursion to build a stack of page names
      $stack = build_location_stack( $page_data['parent'] );

      // Replace Nav Vars with their values
      if( $_SESSION['nav_vars'] != null )
	{
	  foreach( $_SESSION['nav_vars'] as $name => $value )
	    {
	      $name = "{" . $name . "}";
	      $page_data['title'] = 
		str_replace( $name, $value, 
			     translate_string( $conf['locale']['language'], 
					       $page_data['title'] ) );
	      $page_data['url']   = str_replace( $name, $value, $page_data['url'] );
	    }
	}

      // Push page onto nav stack
      array_push( $stack, 
		  array( "name" => translate_string( $conf['locale']['language'],
						     $page_data['title'] ),
			 "url"  => $page_data['url'] )
		  );

      return $stack;
    }
  else
    {
      // No more - allocate the stack and push this page on the bottom (top for now)
      $stack = array( 
		     array( "name" => translate_string( $conf['locale']['language'],
							$page_data['title'] ), 
			    "url"  => $page_data['url'] )
		     );
      return $stack;
    }
}

/**
 * Get Page Class
 *
 * Return the name of the class which implements a given page name.
 *
 * @return string Class name if found, null if not.
 */
function get_page_class( $name )
{
  global $conf;

  foreach( $conf['pages'] as $class_name => $page_data )
    {
      if( $page_data['name'] == $name )
	{
	  return $class_name;
	}
    }

  // Class not found
  return null;
}

/**
 * Scan for and Load Modules
 *
 * Scans the modules directory for installed modules
 *
 * @return array An array of installed modules
 */
function loadModules()
{
  global $conf, $translations;

  // Read the contents of the modules directory
  $modules = array();
  $modulesDir = BASE_PATH . "modules/";
  if( !($dh = opendir( $modulesDir ) ) )
    {
      fatal_error( "loadModules()", "Could not access the modules directory." );
    }
  
  while( $file = readdir( $dh ) )
    {
      $moduleName = $file;
      $moduleDir = sprintf( "%s%s", $modulesDir, $moduleName );
      $moduleConfFile = sprintf( "%s/module.conf", $moduleDir );
      $moduleClassFile = sprintf( "%s/%s.class.php", $moduleDir, $moduleName );
      $moduleTransFile = sprintf( "%s/translations", $moduleDir );

      if( is_dir( $moduleDir ) && 
	  (isset( $file ) && $file != "." && $file != ".." && $file != "CVS" ) &&
	  file_exists( $moduleConfFile ) &&
	  file_exists( $moduleClassFile ) )
	{
	  // Load the module's config file
	  $modConf = load_config_file( $moduleConfFile );
	  $conf['pages'] = array_merge( $conf['pages'], $modConf['pages'] );
	  $conf['forms'] = array_merge( $conf['forms'], $modConf['forms'] );
	  $conf['hooks'] = array_merge( $conf['hooks'], $modConf['hooks'] );

	  // Load the module's translation file
	  if( file_exists( $moduleTransFile ) )
	    {
	      $modTranslations = load_translations_file( $moduleTransFile );
	      foreach( $modTranslations as $language => $phrases )
		{
		  if( is_array( $phrases ) )
		    {
		      $translations[$language] = 
			array_merge( isset( $translations[$language] ) ? $translations[$language] : array(), 
				     $phrases );
		    }
		}
	    }

	  // Load the module's class file
	  require_once $moduleClassFile;

	  // Initialize module
	  $conf['modules'][$moduleName] = new $moduleName;
	  if( !$conf['modules'][$moduleName]->init() )
	    {
	      fatal_error( "loadModules()",
			   "Failed to initialize module: " . $moduleName );
	    }
	}
    }
  
  closedir( $dh );
}
?>