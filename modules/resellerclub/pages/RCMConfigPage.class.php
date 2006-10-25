<?php
/**
 * RCMConfigPage.class.php
 *
 * This file contains the definition of the RCMConfigPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * RCMConfigPage
 *
 * This is the Manager's configuration page for the ResellerClub module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RCMConfigPage extends SolidStateAdminPage
{
  /**
   * @var ResellerClubModule Reseller Club Module object
   */
  var $rcModule;

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
      case "rcm_config":
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
    $this->rcModule = $this->conf['modules']['resellerclub'];
    $this->smarty->assign( "rcusername", $this->rcModule->getUsername() );
    $this->smarty->assign( "password",  $this->rcModule->getPassword() );
    $this->smarty->assign( "resellerid", $this->rcModule->getResellerID() );
    $this->smarty->assign( "parentid", $this->rcModule->getParentID() );
    $this->smarty->assign( "role", $this->rcModule->getRole() );
    $this->smarty->assign( "langpref", $this->rcModule->getLangPref() );
    $this->smarty->assign( "serviceurl", $this->rcModule->getServiceURL() );
    $this->smarty->assign( "debug", $this->rcModule->getDebug() );
    $this->smarty->assign( "defaultcustomerpassword", 
			   $this->rcModule->getDefaultCustomerPassword() );
  }

  /**
   * Save Settings
   */
  function save()
  {
    // Update settings in DB
    $this->rcModule->setUsername( $this->post['username'] );
    $this->rcModule->setPassword( $this->post['password'] );
    $this->rcModule->setResellerID( $this->post['resellerid'] );
    $this->rcModule->setParentID( $this->post['parentid'] );
    $this->rcModule->setRole( $this->post['role'] );
    $this->rcModule->setLangPref( $this->post['langpref'] );
    $this->rcModule->setServiceURL( $this->post['serviceurl'] );
    $this->rcModule->setDebug( $this->post['debug'] );
    $this->rcModule->setDefaultCustomerPassword( $this->post['defaultcustomerpassword'] );
    $this->rcModule->saveSettings();

    $this->setMessage( array( "type" => "RC_CONFIGURATION_SAVED" ) );
    $this->reload();
  }
}
?>