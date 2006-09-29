<?php
/**
 * ServicesWebHostingPage.class.php
 *
 * This file contains the definition for the ServicesWebHostingPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * ServicesWebHosting
 *
 * Display all web hosting services offered by the provider.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServicesWebHosting extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   none
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
}
?>