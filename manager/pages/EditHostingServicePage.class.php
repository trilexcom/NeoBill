<?php
/**
 * EditHostingServicePage.class.php
 *
 * This file contains the definition for the Edit Hosting Service Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * EditHostingServicePage
 *
 * Edit a hosting service offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditHostingServicePage extends AdminPage
{
  /**
   * Initialize the Edit Hosting Service Page
   *
   * If the Hosting Service ID is provided in the query string, load the
   * HostingServiceDBO from the database and store it in the session.  Otherwise,
   * use the DBO that is already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Hosting Service from the database
	$dbo = load_HostingServiceDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['hosting_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Hosting Service
	$this->setError( array( "type" => "DB_HOSTING_SERVICE_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['hosting_dbo'] = $dbo;
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_hosting (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "edit_hosting":

	if( isset( $this->session['edit_hosting']['save'] ) )
	  {
	    // Save changes
	    $this->update_hosting_service();
	    $this->goto( "services_view_hosting_service",
			 array( array( "type" => "HOSTING_SERVICE_UPDATED" ) ),
			 "id=" . $this->session['hosting_dbo']->getID() );
	  }
	elseif( isset( $this->session['edit_hosting']['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goto( "services_view_hosting_service",
			 null,
			 "id=" . $this->session['hosting_dbo']->getID() );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Update Hosting Service
   *
   * Place the changes from the form into the HostingServiceDBO and update the database.
   */
  function update_hosting_service()
  {
    // Access DBO
    $service_dbo = $this->session['hosting_dbo'];

    // Pull form data from session
    $service_data = $this->session['edit_hosting'];
   
    if( !isset( $service_data ) )
      {
	// Missing form data
	fatal_error( "EditHostingServicePage::update_hosting_service()",
		     "Error: no form data received!" );
      }

    // Update DBO
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
    if( !update_HostingServiceDBO( $service_dbo ) )
      {
	// Error
	fatal_error( "EditHostingServicePage::update_hosting_service()",
		     "update error!" );
      }
  }
}

?>
