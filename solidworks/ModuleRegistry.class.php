<?php
/**
 * ModuleRegistry.class.php
 *
 * This file contains the definition of the ModuleRegistry class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// The Module class
require BASE_PATH . "solidworks/Module.class.php";
require BASE_PATH . "DBO/ModuleDBO.class.php";

// Exceptions
class ModuleNameConflictException extends SWModuleException {
	public function __construct( $name = "NULL" ) {
		$this->message = "Conflicting module name: " . $name;
	}
}
class ModuleDoesNotExistException extends SWModuleException {
	public function __construct( $name = "NULL" ) {
		$this->message = "Module does not exist: " . $name;
	}
}
class ModuleRegistryDoesNotExistException extends SWModuleException {
	public function __construct() {
		$this->message = "Module Registry Does Not Exist (you must call ModuleRegistry::createModuleRegistry first)";
	}
}

/**
 * ModuleRegistry
 *
 * Provides a registry for modules
 *
 * @pacakge modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModuleRegistry {
	/**
	 * @var ModuleRegistry The singleton instance of ModuleRegistry
	 */
	private static $registry = null;

	/**
	 * Create Module Registry
	 *
	 * @param string $modulePath Path to the directory where modules are installed
	 */
	public static function createModuleRegistry( $modulePath ) {
		if ( !isset( self::$registry ) ) {
			self::$registry = new ModuleRegistry( $modulePath );
		}

		return self::$registry;
	}

	/**
	 * Get Module Registry
	 *
	 * @return ModuleRegistry The module registry
	 */
	public static function getModuleRegistry() {
		if ( !isset( self::$registry ) ) {
			throw new ModuleRegistryDoesNotExistException();
		}

		return self::$registry;
	}

	/**
	 * @var array An array of SolidStateModules
	 */
	private $modules = array();

	/**
	 * @var string Path to the directory where modules are installed
	 */
	private $modulesPath = null;

	/**
	 * Constructor
	 *
	 * This class is a singleton - it must be instantiated by calling
	 * ModuleRegistry::getModuleRegistry().
	 *
	 * @param string $modulesPath Path to the modules directory
	 */
	private function __construct( $modulesPath ) {
		$this->modulesPath = $modulesPath;
		$this->loadModules();
	}

	/**
	 * Get All Modules
	 *
	 * @return array An array of all registered modules
	 */
	public function getAllModules() {
		return $this->modules;
	}

	/**
	 * Get Module
	 *
	 * @param string $moduleName The name of the module to get
	 */
	public function getModule( $moduleName ) {
		if ( !isset( $this->modules[$moduleName] ) ) {
			throw new ModuleDoesNotExistException();
		}

		return $this->modules[$moduleName];
	}

	/**
	 * Get Modules By Type
	 *
	 * @param string $type The type of modules to get
	 * @return array An array of modules with the specific type
	 */
	public function getModulesByType( $type, $enabledOnly = false ) {
		$modules = array();
		foreach ( $this->modules as $moduleName => $module ) {
			if ( $enabledOnly && !$module->isEnabled() ) {
				continue;
			}
			if ( $module->getType() == $type ) {
				$modules[$moduleName] = $module;
			}
		}

		return $modules;
	}

	/**
	 * Load Modules
	 */
	public function loadModules() {
		global $conf;

		if ( !($dh = opendir( $this->modulesPath ) ) ) {
			throw new SWException( "Could not access the modules directory: ". $this->modulesPath );
		}

		// Read the contents of the modules directory
		while ( $file = readdir( $dh ) ) {
			$moduleName = $file;
			$moduleDir = sprintf( "%s%s", $this->modulesPath, $moduleName );
			$moduleConfFile = sprintf( "%s/module.conf", $moduleDir );
			$moduleClassFile = sprintf( "%s/%s.class.php", $moduleDir, $moduleName );
			$moduleDefTransFile = sprintf( "%s/language/english", $moduleDir );
			$moduleActTransFile = sprintf( "%s/language/%s",
					$moduleDir,
					Translator::getTranslator()->getActiveLanguage() );
			
			if ( is_dir( $moduleDir ) &&
				(isset( $file ) && $file != "." && $file != ".." ) 
				 &&
				file_exists( $moduleClassFile ) ) {
				
				// Load the module's config file
				if (file_exists( $moduleConfFile )){
					$modConf = load_config_file( $moduleConfFile );
					$conf['pages'] = array_merge( $conf['pages'], $modConf['pages'] );
					$conf['forms'] = array_merge( $conf['forms'], $modConf['forms'] );
					$conf['hooks'] = array_merge( $conf['hooks'], $modConf['hooks'] );
	
					// Load the module's default translation file
					if ( file_exists( $moduleDefTransFile ) ) {
						TranslationParser::load( $moduleDefTransFile );
					}
					
					// Load the module's active translation file
					if ( $moduleDefTransFile != $moduleActTransFile &&
							file_exists( $moduleActTransFile ) ) {
						TranslationParser::load( $moduleActTransFile );
					}
				}
			
				// Load the module's class file
				require $moduleClassFile;
				
				// Initialize module
				$module = new $moduleName;

				$module->init();
				
				$this->registerModule( $module );
				
			}
		}		

		closedir( $dh );
						
	}

	/**
	 * Register Module
	 *
	 * @param Module The module to register
	 */
	public function registerModule( Module $module ) {
		
		$name = $module->getName();

		if ( isset( $this->modules[$name] ) ) {
			throw new ModuleNameConflictException( $name );
		}

		// Add module to the registry
		$this->modules[$name] = $module;
			
				
	}
}
?>