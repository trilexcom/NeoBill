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

require_once $base_path . "DBO/ModuleDBO.class.php";

require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * ModulesPage
 *
 * View SolidState Modules page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModulesPage extends AdminPage
{
  /**
   * Initialize Modules Page
   */
  function init()
  {
    // Store all the module names in the session for validation
    $this->session['modulenames'] = array();
    if( null != ($moduleDBOArray = load_array_ModuleDBO() ) )
	{
	  foreach( $moduleDBOArray as $moduleDBO )
	  {
	    $this->session['modulenames'][] = $moduleDBO->getName();
	  }
	}
  }

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
	if( isset( $this->session['modules']['update'] ) )
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
    if( !isset( $this->session['modules']['enabled'] ) )
      {
	// Guard against a pesky foreach warning
	$this->session['modules']['enabled'] = array();
      }

    // Enable all the Modules with checks, disable the ones without
    $moduleDBOArray = load_array_ModuleDBO();
    foreach( $moduleDBOArray as $moduleDBO )
      {
	if( !$moduleDBO->isEnabled() &&
	    in_array( $moduleDBO->getName(),
		      $this->session['modules']['enabled'] ) )
	  {
	    // Enable this module
	    $moduleDBO->setEnabled( "Yes" );
	    if( !update_ModuleDBO( $moduleDBO ) )
	      {
		fatal_error( "ModulesPage::updateModule()",
			     "Failed to enable module: " . $moduleDBO->getName() );
	      }
	  }
	elseif( $moduleDBO->isEnabled() &&
	        !in_array( $moduleDBO->getName(),
			   $this->session['modules']['enabled'] ) )
	  {
	    // Disable this module
	    $moduleDBO->setEnabled( "No" );
	    if( !update_ModuleDBO( $moduleDBO ) )
	      {
		fatal_error( "ModulesPage::updateModule()",
			     "Failed to enable module: " . $moduleDBO->getName() );
	      }
	  }
      }

    $this->setMessage( array( "type" => "MODULES_UPDATED" ) );
  }
}
?>