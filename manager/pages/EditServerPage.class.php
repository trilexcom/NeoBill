<?php
/**
 * EditServerPage.class.php
 *
 * This file contains the definition for the EditServerPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

require_once BASE_PATH . "DBO/ServerDBO.class.php";

/**
 * EditServerPage
 *
 * Edit Server info.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditServerPage extends SolidStateAdminPage
{
  /**
   * Initialize Edit Server Page
   */
  function init()
  {
    parent::init();

    // Set URL Field
    $this->setURLField( "server", $this->get['server']->getID() );

    // Store Server DBO in session
    $this->session['server_dbo'] =& $this->get['server'];
    
    // Set this page's Nav Vars
    $this->setNavVar( "id",   $this->get['server']->getID() );
    $this->setNavVar( "hostname", $this->get['server']->getHostName() );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_server (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_server":
	if( isset( $this->post['save'] ) )
	  {
	    $this->save();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->goback();
	  }

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Save
   *
   * Store the changes in the database
   */
  function save()
  {
    // Update the ServerDBO
    $server_dbo = $this->session['server_dbo'];
    $server_dbo->setLocation( $this->post['location'] );
    $server_dbo->setHostName( $this->post['hostname'] );

    // Save changes in the database
    if( !update_ServerDBO( $server_dbo ) )
      {
	$this->setError( array( "type" => "DB_SERVER_UPDATE_FAILED" ) );
	$this->goback();
      }

    // Success
    $this->setMessage( array( "type" => "SERVER_UPDATED" ) );
    $this->goback();
  }
}

?>