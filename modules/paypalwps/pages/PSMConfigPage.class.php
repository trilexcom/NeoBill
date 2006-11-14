<?php
/**
 * PSMConfigPage.class.php
 *
 * This file contains the definition of the PPMConfigPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * PPMConfigPage
 *
 * This is the Manager's configuration page for the Paypal module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PSMConfigPage extends SolidStateAdminPage
{
  /**
   * @var Paypal Paypal Module object
   */
  var $ppModule;

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
      case "psm_config":
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
   * Initialize the Page
   */
  function init()
  {
    // Load the form values with Module settings
    $registry = ModuleRegistry::getModuleRegistry();
    $this->ppModule = $registry->getModule( 'paypalwps' );
    $this->smarty->assign( "account", $this->ppModule->getAccount() );
    $this->smarty->assign( "cartURL", $this->ppModule->getCartURL() );
    $this->smarty->assign( "idToken", $this->ppModule->getIdToken() );
    $this->smarty->assign( "currency", $this->ppModule->getCurrencyCode() );
  }

  /**
   * Save Settings
   */
  function save()
  {
    // Update settings in DB
    $this->ppModule->setAccount( $this->post['account'] );
    $this->ppModule->setCartURL( $this->post['carturl'] );
    $this->ppModule->setIdToken( $this->post['idtoken'] );
    $this->ppModule->setCurrencyCode( $this->post['currency'] );
    $this->ppModule->saveSettings();

    $this->setMessage( array( "type" => "PS_CONFIGURATION_SAVED" ) );
  }
}
?>