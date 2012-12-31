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

require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * ModulesPage
 *
 * View SolidState Modules page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModulesPage extends SolidStateAdminPage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		
		switch ( $action_name ) {
			case "modules":
				if ( isset( $this->post['update'] ) ) {
					$this->updateModules();
				}
				break;
			case "modules_action":
				if ( isset( $this->post['add'] ) ) {
				    $this->gotoPage( "config_new_module" );
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
	function updateModules() {
		
		if ( !isset( $this->post['modules'] ) ) {
			$this->post['modules'] = array();
		}

		// Enable all the Modules with checks, disable the ones without
		$modules = ModuleRegistry::getModuleRegistry()->getAllModules();
		foreach ( $modules as $module ) {
			if ( !$module->isEnabled() && in_array( $module, $this->post['modules'] ) ) {
				// Enable this module
				$moduleDBO = load_ModuleDBO( $module->getName() );
				$moduleDBO->setEnabled( "Yes" );
				update_ModuleDBO( $moduleDBO );
			}
			elseif ( $module->isEnabled() && !in_array( $module, $this->post['modules'] ) ) {
				// Disable this module
				$moduleDBO = load_ModuleDBO( $module->getName() );
				$moduleDBO->setEnabled( "No" );
				update_ModuleDBO( $moduleDBO );
			}
		}

		$this->setMessage( array( "type" => "[MODULES_UPDATED]" ) );
		$this->reload();
	}
}
?>