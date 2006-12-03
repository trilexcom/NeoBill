<?php
/**
 * ServicesNewHostingPage
 *
 * This file contains the definition for the ServicesNewHostingPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * ServicesNewHosting
 *
 * Create a new hosting service
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServicesNewHosting extends SolidStateAdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   new_hosting (form)
   *   new_hosting_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "new_hosting":
	if( isset( $this->session['new_hosting']['cancel'] ) )
	  {
	    // Canceled
	    $this->goback();
	  }

	// Process new hosting service form
	$this->add_hosting();
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Add Hosting
   *
   * Add the HostingServiceDBO to the database
   */
  function add_hosting()
  {
    // Prepare HostingServiceDBO for database
    $service_dbo = new HostingServiceDBO();
    $service_dbo->setTitle( $this->post['title'] );
    $service_dbo->setDescription( $this->post['description'] );
    $service_dbo->setUniqueIP( $this->post['uniqueip'] );
    $service_dbo->setDomainRequirement( $this->post['domainrequirement'] );

    // Insert HostingServiceDBO into database
    if( !add_HostingServiceDBO( $service_dbo ) )
      {
	// Unable to add service
	$this->setError( array( "type" => "DB_HOSTING_ADD_FAILED",
				"args" => array( $service_dbo->getTitle() ) ) );

	// Return to form
	$this->setTemplate( "default" );
	$this->reload();
      }

    // Done
    $this->goto( "services_edit_hosting",
		 null,
		 "hservice=" . $service_dbo->getID() );
  }
}
?>