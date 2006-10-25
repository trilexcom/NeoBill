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
require_once BASE_PATH . "solidworks/Page.class.php";

require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

/**
 * DomainServicesPage
 *
 * Display a list of Domain Services offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServicesPage extends Page
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

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>