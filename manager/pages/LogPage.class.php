<?php
/**
 * LogPage.class.php
 *
 * This file contains the definition for the LogPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once $base_path . "solidworks/AdminPage.class.php";

require_once $base_path . "DBO/LogDBO.class.php";

/**
 * LogPage
 *
 * View SolidState Log page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LogPage extends AdminPage
{
  /**
   * Initialize Log Page
   */
  function init()
  {

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
      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}
?>