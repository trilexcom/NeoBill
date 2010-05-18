<?php
/**
 * CPServerConfigPage.class.php
 *
 * This file contains the definition of the CPServerConfigPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * CPServerConfigPage
 *
 * This page configures a single server to work with the cPanel module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CPServerConfigPage extends SolidStateAdminPage
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
      case "cp_server_config":
	if( isset( $this->post['cancel'] ) )
	  {
	    $this->goback();
	  }
	elseif( isset( $this->post['save'] ) )
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
    parent::init();

    // Populate the form
    $this->smarty->assign( "hostname", $this->get['server']->getHostName() );

    // Set URL fields
    $this->setURLField( "server", $this->get['server']->getID() );

    try
      {
	$CSDBO = load_CPanelServerDBO( $this->get['server']->getID() );
	$this->smarty->assign( "WHMUsername", $CSDBO->getUsername() );
	$this->smarty->assign( "accessHash", $CSDBO->getAccessHash() );
      }
    catch( DBNoRowsFoundException $e ) {}
  }

  /**
   * Save Changes
   */
  public function save()
  {
    $CSDBO = new CPanelServerDBO();
    $CSDBO->setServerID( $this->get['server']->getID() );
    $CSDBO->setAccessHash( strtr( $this->post['accesshash'], array( "\n" => "",
								    "\r" => "" ) ) );
    $CSDBO->setUsername( $this->post['username'] );

    addOrUpdate_CPanelServerDBO( $CSDBO );

    // Success
    $this->setMessage( array( "type" => "[CPANEL_SERVER_CONFIG_SAVED]" ) );
    $this->goback();
  }
}
?>