<?php
/**
 * NRConfigPage.class.php
 *
 * This file contains the definition of the NRConfigPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * NRConfigPage
 *
 * This is the Manager's configuration page for the NullRegistrar module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NRConfigPage extends AdminPage
{
  /**
   * @var NullRegistrarModule NullRegistrar Module object
   */
  var $nrModule;

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
    $this->rcModule = $this->conf['modules']['nullregistrar'];
  }

  /**
   * Save Settings
   */
  function save()
  {
  }
}
?>