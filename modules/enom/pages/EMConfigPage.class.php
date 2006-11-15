<?php
/**
 * EMConfigPage.class.php
 *
 * This file contains the definition of the EMConfigPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * EMConfigPage
 *
 * This is the Manager's configuration page for the Enom module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EMConfigPage extends SolidStateAdminPage
{
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
      case "em_config":
	if( isset( $this->post['save'] ) )
	  {
	    $this->save();
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
    // Populate the form
    $module = ModuleRegistry::getModuleRegistry()->getModule( "enom" );
    $this->smarty->assign( "enomusername", $module->getUsername() );
    $this->smarty->assign( "enompassword", $module->getPassword() );
    $this->smarty->assign( "apirul", $module->getAPIURL() );
  }

  /**
   * Save Settings
   */
  protected function save()
  {
    // Update settings in DB
    $module = ModuleRegistry::getModuleRegistry()->getModule( "enom" );
    $module->setUsername( $this->post['username'] );
    $module->setPassword( $this->post['password'] );
    $module->setAPIURL( $this->post['url'] );
    $module->saveSettings();

    $this->setMessage( array( "type" => "[ENOM_CONFIG_SAVED]" ) );
    $this->reload();
  }
}
?>