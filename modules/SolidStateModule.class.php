<?php
/**
 * SolidStateModule.class.php
 *
 * This file contains the definition of the SolidStateModule class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Module DBO
require BASE_PATH . "DBO/ModuleDBO.class.php";

// Exceptions
class ModuleInstallFailedException extends SWModuleException
{
  public function __construct( $name = "unkown module" ) { $this->message = "Unabled to install module: " . $name; }
}

/**
 * SolidStateModule
 *
 * Provides an abstract base-class for SolidState modules.
 *
 * @pacakge modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class SolidStateModule extends Module
{
  /**
   * @var string Config Page
   */
  protected $configPage = null;

  /**
   * @var ModuleDBO This module's DBO
   */
  protected $moduleDBO = null;

  /**
   * @var string Module type (i.e: registrar, payment_gateway, etc.)
   */
  protected $type = null;

  /**
   * Check Enabled
   *
   * Cause a fatal error if the module is not enabled
   */
  public function checkEnabled()
  {
    if( !$this->isEnabled() )
      {
	fatal_error( "ResellerClub::checkAvailability()",
		     "The ResellerClub module is disabled." );
      }
  }

  /**
   * Disable Module
   */
  public function disable() 
  { 
    $this->moduleDBO->setEnabled( "No" ); 
    $this->updateModuleDBO();
  }

  /**
   * Enable Module
   */
  public function enable() 
  { 
    $this->moduleDBO->setEnabled( "Yes" ); 
    $this->updateModuleDBO();
  }

  /**
   * Get Config Page
   *
   * @return string Name of the config page for this module
   */
  public function getConfigPage() { return $this->configPage; }

  /**
   * Get Module Type
   *
   * @return string Module type
   */
  public function getType() { return $this->type; }

  /**
   * Is Enabled
   *
   * @return boolean True if this module is enabled
   */
  public function isEnabled() { return $this->moduleDBO->isEnabled(); }

  /**
   * Initialize Module
   *
   * This method is called by the configuration script when the module is
   * loaded.
   *
   * @return boolean True for success
   */
  public function init()
  {
    // Check if this module is installed
    if( null == ($this->moduleDBO = load_ModuleDBO( $this->getName() ) ) )
      {
	// Install this module
	$this->install();
      }

    return true;
  }

  /**
   * Install Module
   *
   * This method is called by the init() method whenever a new module 
   * is being installed.
   */
  public function install()
  {
    // Create a new ModuleDBO and add it to the database
    $this->moduleDBO = new ModuleDBO();
    $this->moduleDBO->setName( $this->getName() );
    $this->moduleDBO->setEnabled( $this->isEnabled() ? "Yes" : "No" );
    $this->moduleDBO->setType( $this->getType() );
    $this->moduleDBO->setShortDescription( $this->getShortDescription() );
    $this->moduleDBO->setDescription( $this->getDescription() );
    if( !add_ModuleDBO( $this->moduleDBO ) )
      {
	throw new ModuleInstallFailedException( $this->getName() );
      }
  }

  /**
   * Update Module DBO
   */
  public function updateModuleDBO()
  {
    if( !update_ModuleDBO( $this->moduleDBO ) )
      {
	fatal_error( "SolidStateModule::disable()",
		     "Failed to update Module DBO: " . $this->getName() );
      }
  }
}

/**
 * Remove Missing Module's from Database
 */
function removeMissingModules()
{
  global $conf;

  $modules = ModuleRegistry::getModuleRegistry()->getAllModules();
  if( null != ($moduleDBOArray = load_array_ModuleDBO()) )
    {
      foreach( load_array_ModuleDBO() as $moduleDBO )
	{
	  // Remove from the database any modules that are not installed anymore
	  if( !array_key_exists( $moduleDBO->getName(), $modules ) )
	    {
	      if( !delete_ModuleDBO( $moduleDBO ) )
		{
		  fatal_error( "removeMissingModules()",
			       "Failed to remove missing module from the database: " .$moduleDBO->getName() );
		}
	    }
	}
    }
}
?>