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

require_once $base_path . "solidworks/AdminPage.class.php";

require_once $base_path . "DBO/LogDBO.class.php";

/**
 * ViewLogMessagePage
 *
 * View SolidState ViewLogMessage page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewLogMessagePage extends AdminPage
{
  /**
   * Initialize ViewLogMessage Page
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Log Message from the database
	$dbo = load_LogDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['logdbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Account
	$this->setError( array( "type" => "DB_LOG_MESSAGE_NOT_FOUND",
				"args" => array( intval( $id ) ) ) );
      }
    else
      {
	// Store Account DBO in session
	$this->session['logdbo'] = $dbo;

	// Set this page's Nav Vars
	$this->setNavVar( "id",   $dbo->getID() );
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
      case "view_log_message":
	if( isset( $this->session['view_log_message']['back'] ) )
	  {
	    $this->goto( "log",
			 null,
			 "table=logdbo_table&sortby=date&sortdir=DESC" );
	  }

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}
?>