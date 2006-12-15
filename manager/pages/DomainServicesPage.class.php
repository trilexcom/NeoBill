<?php
/**
 * DomainServicesPage.class.php
 *
 * This file contains the definition for the DomainServicesPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * DomainServicesPage
 *
 * Display a list of Domain Services offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServicesPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   domain_services_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "domain_services_action":
	if( isset( $this->session['domain_services_action']['add'] ) )
	  {
	    // Goto new user page
	    $this->goto( "services_new_domain_service" );
	  }
	break;

      case "search_domain_services":
	$this->searchTable( "domain_services", "services", $this->post );
	break;

      case "domain_services":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->removeDomainService();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Domain Service
   *
   * Delete DomainServiceDBO from database
   */
  function removeDomainService()
  {
    foreach( $this->post['services'] as $dbo )
      {
	$where = sprintf( "tld='%s'", $dbo->getTLD() );
	if( load_array_DomainServicePurchaseDBO( $where ) != null )
	  {
	    // Can not delete domain service if any purchases exist
	    throw new SWUserException( "PURCHASES_EXIST" );
	  }

	// Delete Domain Service DBO
	if( !delete_DomainServiceDBO( $dbo ) )
	  {
	    // Delete failed
	    $this->setError( array( "type" => "DB_DOMAIN_SERVICE_DELETE_FAILED",
				    "args" => array( $this->session['domain_service_dbo']->getTLD() ) ) );
	    $this->cancel();
	  }
	
	// Success - go back to web domain services page
	$this->setMessage( array( "type" => "DOMAIN_SERVICES_DELETED" ) );
	$this->goto( "services_domain_services" );
      }
  }
}

?>