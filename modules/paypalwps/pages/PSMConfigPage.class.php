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
require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * PPMConfigPage
 *
 * This is the Manager's configuration page for the Paypal module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PSMConfigPage extends AdminPage
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
	if( isset( $this->session['psm_config']['save'] ) )
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
    $this->ppModule = $this->conf['modules']['paypalwps'];
    $this->smarty->assign( "account", $this->ppModule->getAccount() );
    $this->smarty->assign( "cartURL", $this->ppModule->getCartURL() );
    $this->smarty->assign( "idToken", $this->ppModule->getIdToken() );
  }

  /**
   * Save Settings
   */
  function save()
  {
    // Update settings in DB
    $this->ppModule->setAccount( $this->session['psm_config']['account'] );
    $this->ppModule->setCartURL( $this->session['psm_config']['carturl'] );
    $this->ppModule->setIdToken( $this->session['psm_config']['idtoken'] );
    $this->ppModule->saveSettings();

    $this->setMessage( array( "type" => "PS_CONFIGURATION_SAVED" ) );
  }
}
?>