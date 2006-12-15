<?php
/**
 * ViewLogMessagePage.class.php
 *
 * This file contains the definition for the ViewLogMessagePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * ViewLogMessagePage
 *
 * View SolidState ViewLogMessage page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewLogMessagePage extends SolidStateAdminPage
{
  /**
   * Initialize ViewLogMessage Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "log", $this->get['log']->getID() );

    // Store Account DBO in session
    $this->session['logdbo'] =& $this->get['log'];
    
    // Set this page's Nav Vars
    $this->setNavVar( "id",   $this->get['log']->getID() );
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
      case "view_log_message":
	if( isset( $this->session['view_log_message']['back'] ) )
	  {
	    $this->goback();
	  }

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}
?>