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
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

// Include the DomainServiceDBO class
require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

/**
 * NewDomainServicePage
 *
 * Create a new domain service
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NewDomainServicePage extends SolidStateAdminPage
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
	if( isset( $this->post['continue'] ) )
	  {
	    // Process new hosting service form
	    $this->process_new_domain_service();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Canceled
	    $this->goback();
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
    // Prepare DomainServiceDBO for database
    $service_dbo = new DomainServiceDBO();
    $service_dbo->setTLD( $this->post['tld'] );
    $service_dbo->setModuleName( $this->post['modulename']->getName() );
    $service_dbo->setDescription( $this->post['description'] );
    $service_dbo->setPrice1yr( $this->post['price1yr'] );
    $service_dbo->setPrice2yr( $this->post['price2yr'] );
    $service_dbo->setPrice3yr( $this->post['price3yr'] );
    $service_dbo->setPrice4yr( $this->post['price4yr'] );
    $service_dbo->setPrice5yr( $this->post['price5yr'] );
    $service_dbo->setPrice6yr( $this->post['price6yr'] );
    $service_dbo->setPrice7yr( $this->post['price7yr'] );
    $service_dbo->setPrice8yr( $this->post['price8yr'] );
    $service_dbo->setPrice9yr( $this->post['price9yr'] );
    $service_dbo->setPrice10yr( $this->post['price10yr'] );
    $service_dbo->setTaxable( $this->post['taxable'] );

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
	// Jump to View Domain Service page
	$this->goto( "services_view_domain_service", 
		     array( array( "type" => "DOMAIN_SERVICE_ADDED" ) ), 
		     "dservice=" . $service_dbo->getTLD() );
      }
  }
}
?>