<?php
/**
 * EditDomainServicePage.class.php
 *
 * This file contains the definition for the EditDomainServicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * EditDomainServicePage
 *
 * Edit a domain registration service offered by the provider.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditDomainServicePage extends AdminPage
{
  /**
   * Initialize the Edit Domain Serivce Page
   *
   * If the Domain Service ID is provided in the query string, load the
   * DomainServiceDBO from the database and store it in the session.  Otherwise,
   * use the DBO that is already there.
   */
  function init()
  {
    $tld = $_GET['tld'];

    if( isset( $tld ) )
      {
	// Retrieve the Domain Service from the database
	$dbo = load_DomainServiceDBO( form_field_filter( null, $tld ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['domain_service_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Domain Service
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_NOT_FOUND",
				"args" => array( $tld ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['domain_service_dbo'] = $dbo;
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_domain_service (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "edit_domain_service":

	if( isset( $this->session['edit_domain_service']['save'] ) )
	  {
	    // Save changes
	    $this->update_domain_service();
	  }
	elseif( isset( $this->session['edit_domain_service']['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goback( 2 );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Update Domain Service
   *
   * Place the changes made in the form into the DBO and update the database.
   */
  function update_domain_service()
  {
    // Access DBO
    $service_dbo = $this->session['domain_service_dbo'];

    // Pull form data from session
    $service_data = $this->session['edit_domain_service'];

    if( !isset( $service_data ) )
      {
	// Missing form data
	fatal_error( "EditDomainServicePage::update_domain_service()",
		     "no form data received!" );
      }

    // Update DBO
    $service_dbo->setDescription( $service_data['description'] );
    $service_dbo->setModuleName( $service_data['modulename'] );
    $service_dbo->setPrice1yr( $service_data['price1yr'] );
    $service_dbo->setPrice2yr( $service_data['price2yr'] );
    $service_dbo->setPrice3yr( $service_data['price3yr'] );
    $service_dbo->setPrice4yr( $service_data['price4yr'] );
    $service_dbo->setPrice5yr( $service_data['price5yr'] );
    $service_dbo->setPrice6yr( $service_data['price6yr'] );
    $service_dbo->setPrice7yr( $service_data['price7yr'] );
    $service_dbo->setPrice8yr( $service_data['price8yr'] );
    $service_dbo->setPrice9yr( $service_data['price9yr'] );
    $service_dbo->setPrice10yr( $service_data['price10yr'] );
    $service_dbo->setTaxable( $service_data['taxable'] );
    if( !update_DomainServiceDBO( $service_dbo ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_UPDATE_FAILED" ) );
	$this->goback( 1 );
      }

    // Sucess!
    $this->setMessage( array( "type" => "DOMAIN_SERVICE_UPDATED" ) );
    $this->goto( "services_view_domain_service",
		 null,
		 "tld=" . $service_dbo->getTLD() );
  }

  /**
   * Populate the Module Drop-down Menu
   *
   * @return array Array of module names
   */
  function populateModuleNames()
  {
    foreach( $this->conf['modules'] as $moduleName => $moduleData )
      {
	if( $moduleData['type'] == "domain_registrar" )
	  {
	    // Add this module to the list
	    $moduleNames[$moduleName] = $moduleData['shortDescription'];
	  }
      }

    if( !isset( $moduleNames ) )
      {
	// No registrar modules found
	$moduleNames[] = translate_string( $this->conf['locale']['language'],
					   "[NO_REGISTRAR_MODULES]" );
      }

    return $moduleNames;
  }
}

?>