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
require BASE_PATH . "include/SolidStatePage.class.php";

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
  public function action( $action_name )
  {
    switch( $action_name )
      {
      case "web_hosting_action":
	if( isset( $this->post['add'] ) )
	  {
	    // Goto new user page
	    $this->gotoPage( "services_new_hosting" );
	  }
	break;

      case "search_hosting_services":
	$this->searchTable( "hosting_services", "hosting_services", $this->post );
	break;

      case "hosting_services":
	if( $this->post['remove'] )
	  {
	    $this->deleteService();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Hosting Service
   */
  protected function deleteService()
  {
    foreach( $this->post['hosting_services'] as $serviceDBO )
      {
	delete_HostingServiceDBO( $serviceDBO );
      }

    $this->setMessage( array( "type" => "[HOSTING_SERVICES_DELETED]" ) );
    $this->reload();
  }
}

?>