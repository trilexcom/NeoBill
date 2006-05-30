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
require_once $base_path . "solidworks/AdminPage.class.php";

// Include ServiceHostingDBO
require_once $base_path . "DBO/HostingServiceDBO.class.php";

/**
 * ServicesNewHosting
 *
 * Create a new hosting service
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServicesNewHosting extends AdminPage
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
	    $this->goto( "services_web_hosting" );
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
    // Pull form data from session
    $service_data = $this->session['new_hosting'];
   
    if( !isset( $service_data ) )
      {
	// Missing form data
	fatal_error( "ServicesNewHostingPage::process_new_hosting()",
		     "no form data received!" );
      }

    // Prepare HostingServiceDBO for database
    $service_dbo = new HostingServiceDBO();
    $service_dbo->setTitle( $service_data['title'] );
    $service_dbo->setDescription( $service_data['description'] );
    $service_dbo->setUniqueIP( $service_data['uniqueip'] );
    $service_dbo->setSetupPrice1mo( $service_data['setupprice1mo'] );
    $service_dbo->setPrice1mo( $service_data['price1mo'] );
    $service_dbo->setSetupPrice3mo( $service_data['setupprice3mo'] );
    $service_dbo->setPrice3mo( $service_data['price3mo'] );
    $service_dbo->setSetupPrice6mo( $service_data['setupprice6mo'] );
    $service_dbo->setPrice6mo( $service_data['price6mo'] );
    $service_dbo->setSetupPrice12mo( $service_data['setupprice12mo'] );
    $service_dbo->setPrice12mo( $service_data['price12mo'] );
    $service_dbo->setTaxable( $service_data['taxable'] );

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
      }
    else
      {
	// Hosting Service added
	// Clear new_hosting_service data from the session
	unset( $this->session['new_hosting'] );

	// Jump to View Hosting Service page
	$this->goto( "services_view_hosting_service",
		     array( array( "type" => "HOSTING_SERVICE_ADDED" ) ),
		     "id=" . $service_dbo->getID() );
      }
  }
}
