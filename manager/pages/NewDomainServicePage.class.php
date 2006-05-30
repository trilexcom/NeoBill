<?php
/**
 * NewDomainServicePage.class.php
 *
 * This file contains the definition for the NewDomainServicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/AdminPage.class.php";

// Include the DomainServiceDBO class
require_once $base_path . "DBO/DomainServiceDBO.class.php";

/**
 * NewDomainServicePage
 *
 * Create a new domain service
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NewDomainServicePage extends AdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   new_domain_service (form)
   *   new_domain_service_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "new_domain_service":

	if( isset( $this->session['new_domain_service']['continue'] ) )
	  {
	    // Process new hosting service form
	    $this->process_new_domain_service();
	  }
	elseif( isset( $this->session['new_domain_service']['cancel'] ) )
	  {
	    // Canceled
	    $this->goto( "services_domain_services" );
	  }

	break;

      case "new_domain_service_confirm":

	if( isset( $this->session['new_domain_service_confirm']['continue'] ) )
	  {
	    // Go ahead
	    $this->add_domain_service();
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
   * Process New Domain Service
   *
   * Create a new DomainServiceDBO using data from the form, then prompt the client
   * to confirm the new Domain Service.
   */
  function process_new_domain_service()
  {
    // Pull data from session
    $service_data = $this->session['new_domain_service'];

    if( !isset( $service_data ) )
      {
	// Missing form data
	fatal_error( "NewDomainServicePage::process_new_domain_service()",
		     "no form data received!" );
      }

    // Prepare DomainServiceDBO for database
    $service_dbo = new DomainServiceDBO();
    $service_dbo->setTLD( $service_data['tld'] );
    $service_dbo->setModuleName( $service_data['modulename'] );
    $service_dbo->setDescription( $service_data['description'] );
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

    // Place DBO in the session for the confirm & receipt pages
    $this->session['new_domain_service_dbo'] = $service_dbo;

    // Ask client to confirm
    $this->setTemplate( "confirm" );
  }

  /**
   * Add Domain Service
   *
   * Add the DomainServiceDBO to the database
   */
  function add_domain_service()
  {
    // Extract domain service DBO from the session
    $service_dbo =& $this->session['new_domain_service_dbo'];

    // Insert DomainServiceDBO into database
    if( !add_DomainServiceDBO( $service_dbo ) )
      {
	// Unable to add service
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_ADD_FAILED",
				"args" => array( $service_dbo->getTLD() ) ) );

	// Return to form
	$this->setTemplate( "default" );
      }
    else
      {
	// Hosting Service added
	// Clear new_hosting_service data from the session
	unset( $this->session['new_domain_service'] );

	// Jump to View Domain Service page
	$this->goto( "services_view_domain_service", 
		     array( array( "type" => "DOMAIN_SERVICE_ADDED" ) ), 
		     "tld=" . $service_dbo->getTLD() );
      }
  }

  /**
   * Populate the Module Drop-down Menu
   *
   * @return array Array of module names
   */
  function populateModuleNames()
  {
    if( ($registrarModules = 
	 load_array_ModuleDBO( "type='domain_registrar' AND enabled='Yes'" ) ) != null )
      {
	foreach( $registrarModules as $moduleDBO )
	  {
	    // Add this module to the list
	    $moduleNames[$moduleDBO->getName()] = $moduleDBO->getShortDescription();
	  }
      }
    else
      {
	// No registrar modules found
	$moduleNames[] = translate_string( $this->conf['locale']['language'],
					   "[NO_REGISTRAR_MODULES]" );
      }

    return $moduleNames;
  }
}
