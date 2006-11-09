<?php
/**
 * ServicesHostingServicesPage.class.php
 *
 * This file contains the definition for the ServicesHostingServicesPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * ServicesHostingServicesPage
 *
 * Display all of the hosting services offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServicesHostingServicesPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   web_hosting_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "web_hosting_action":
	if( isset( $this->post['add'] ) )
	  {
	    // Goto new user page
	    $this->goto( "services_new_hosting" );
	  }
	break;

      case "search_hosting_services":
	$this->searchTable( "hosting_services", "hosting_services", $this->post );
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}

?>