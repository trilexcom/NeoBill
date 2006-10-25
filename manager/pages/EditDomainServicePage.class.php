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
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

/**
 * EditDomainServicePage
 *
 * Edit a domain registration service offered by the provider.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditDomainServicePage extends SolidStateAdminPage
{
  /**
   * Initialize the Edit Domain Serivce Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "dservice", $this->get['dservice']->getTLD() );

    // Store service DBO in session
    $this->session['domain_service_dbo'] =& $this->get['dservice'];
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
	if( isset( $this->post['save'] ) )
	  {
	    // Save changes
	    $this->update_domain_service();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goback();
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
    // Update DBO
    $this->get['dservice']->setDescription( $this->post['description'] );
    $this->get['dservice']->setModuleName( $this->post['modulename']->getName() );
    $this->get['dservice']->setPrice1yr( $this->post['price1yr'] );
    $this->get['dservice']->setPrice2yr( $this->post['price2yr'] );
    $this->get['dservice']->setPrice3yr( $this->post['price3yr'] );
    $this->get['dservice']->setPrice4yr( $this->post['price4yr'] );
    $this->get['dservice']->setPrice5yr( $this->post['price5yr'] );
    $this->get['dservice']->setPrice6yr( $this->post['price6yr'] );
    $this->get['dservice']->setPrice7yr( $this->post['price7yr'] );
    $this->get['dservice']->setPrice8yr( $this->post['price8yr'] );
    $this->get['dservice']->setPrice9yr( $this->post['price9yr'] );
    $this->get['dservice']->setPrice10yr( $this->post['price10yr'] );
    $this->get['dservice']->setTaxable( $this->post['taxable'] );
    if( !update_DomainServiceDBO( $this->get['dservice'] ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Sucess!
    $this->setMessage( array( "type" => "DOMAIN_SERVICE_UPDATED" ) );
    $this->goto( "services_view_domain_service",
		 null,
		 "dservice=" . $this->get['dservice']->getTLD() );
  }
}
?>