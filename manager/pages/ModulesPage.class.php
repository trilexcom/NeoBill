<?php
/**
 * ModulesPage.class.php
 *
 * This file contains the definition for the ModulesPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "DBO/ModuleDBO.class.php";
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * ModulesPage
 *
 * View SolidState Modules page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModulesPage extends SolidStateAdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "modules":
	if( isset( $this->post['update'] ) )
	  {
	    $this->updateModules();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Update the Modules Enabled/Disabled flag
   */
  function updateModules()
  {
    global $conf;

    if( !isset( $this->post['modules'] ) )
      {
	$this->post['modules'] = array();
      }

    // Enable all the Modules with checks, disable the ones without
    foreach( $conf['modules'] as $module )
      {
	if( !$module->isEnabled() && in_array( $module, $this->post['modules'] ) )
	  {
	    // Enable this module
	    $moduleDBO = load_ModuleDBO( $module->getName() );
	    $moduleDBO->setEnabled( "Yes" );
	    if( !update_ModuleDBO( $moduleDBO ) )
	      {
		throw new SWException( "Failed to enable module: " . $moduleDBO->getName() );
	      }
	  }
	elseif( $module->isEnabled() && !in_array( $module, $this->post['modules'] ) )
	  {
	    // Disable this module
	    $moduleDBO = load_ModuleDBO( $module->getName() );
	    $moduleDBO->setEnabled( "No" );
	    if( !update_ModuleDBO( $moduleDBO ) )
	      {
		throw new SWException( "Failed to enable module: " . $moduleDBO->getName() );
	      }
	  }
      }

    $this->setMessage( array( "type" => "MODULES_UPDATED" ) );
    $this->reload();
  }
}
?>