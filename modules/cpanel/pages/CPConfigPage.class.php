<?php
/**
 * CPConfigPage.class.php
 *
 * This file contains the definition of the CPConfigPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * CPConfigPage
 *
 * This page configures the cPanel module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CPConfigPage extends SolidStateAdminPage
{
  /**
   * @var CPanel CPanel Module
   */
  protected $CPModule = null;

  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  public function action( $action_name )
  {
    switch( $action_name )
      {
      case "cp_config":
	if( isset( $this->post['save'] ) )
	  {
	    $this->saveSettings();
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize Page
   */
  public function init()
  {
    parent::init();

    // Supply the module to the template
    $this->CPModule = ModuleRegistry::getModuleRegistry()->getModule( "cpanel" );
    $this->smarty->assign_by_ref( "CPModule", $this->CPModule );
  }

  /**
   * Save Cpanel Module Settings
   */
  public function saveSettings()
  {
    $this->CPModule->setLibPath( $this->post['libpath'] );
    $this->CPModule->saveSettings();

    $this->setMessage( array( "type" => "[CPANEL_CONFIG_SAVED]" ) );
    $this->goback();
  }
}
?>