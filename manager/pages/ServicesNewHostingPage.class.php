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
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

// Include ServiceHostingDBO
require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

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
	$this->process_new_hosting();
	break;

      case "new_hosting_confirm":
	if( isset( $this->session['new_hosting_confirm']['continue'] ) )
	  {
	    // Go ahead
	    $this->add_hosting();
	  }
	else
	  {
	    // Go back
	    $this->setTemplate( "default" );
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Process New Hosting
   *
   * Place the form data in a new HostingServiceDBO, then prompt the client to
   * confirm the new hosting service
   */
  function process_new_hosting()
  {
    // Prepare HostingServiceDBO for database
    $service_dbo = new HostingServiceDBO();
    $service_dbo->setTitle( $this->post['title'] );
    $service_dbo->setDescription( $this->post['description'] );
    $service_dbo->setUniqueIP( $this->post['uniqueip'] );
    $service_dbo->setSetupPrice1mo( $this->post['setupprice1mo'] );
    $service_dbo->setPrice1mo( $this->post['price1mo'] );
    $service_dbo->setSetupPrice3mo( $this->post['setupprice3mo'] );
    $service_dbo->setPrice3mo( $this->post['price3mo'] );
    $service_dbo->setSetupPrice6mo( $this->post['setupprice6mo'] );
    $service_dbo->setPrice6mo( $this->post['price6mo'] );
    $service_dbo->setSetupPrice12mo( $this->post['setupprice12mo'] );
    $service_dbo->setPrice12mo( $this->post['price12mo'] );
    $service_dbo->setTaxable( $this->post['taxable'] );

    // Place DBO in the session for the confirm & receipt pages
    $this->session['new_hosting_dbo'] = $service_dbo;

    // Ask client to confirm
    $this->setTemplate( "confirm" );
  }

  /**
   * Add Hosting
   *
   * Add the HostingServiceDBO to the database
   */
  function add_hosting()
  {
    // Extract service DBO from the session
    $service_dbo =& $this->session['new_hosting_dbo'];

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
    $this->goback();
  }
}
?>