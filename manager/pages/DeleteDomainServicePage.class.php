<?php
/**
 * DeleteDomainServicePage.class.php
 *
 * This file contains the definition for the DeleteDomainServicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * DeleteDomainServicePage
 *
 * Delete a DomainService from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteDomainServicePage extends SolidStateAdminPage
{
  /**
   * Initialize Delete Domain Service Page
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
   *   delete_domain_service (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "delete_domain_service":
	if( isset( $this->post['delete'] ) )
	  {
	    $this->delete_domain_service();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goback();
  }

  /**
   * Delete Domain Service
   *
   * Delete DomainServiceDBO from database
   */
  function delete_domain_service()
  {
    $DB = DBConnection::getDBConnection();

    $tld = $DB->quote_smart( $this->get['dservice']->getTLD() );

    // Delete Domain Service DBO
    delete_DomainServiceDBO( $this->get['dservice'] );

    // Success - go back to web domain services page
    $this->setMessage( array( "type" => "[DOMAIN_SERVICE_DELETED]",
			      "args" => array( $this->session['domain_service_dbo']->getTLD() ) ) );
    $this->goto( "services_domain_services" );
  }
}
?>