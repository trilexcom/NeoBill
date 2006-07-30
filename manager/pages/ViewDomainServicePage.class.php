<?php
/**
 * ViewDomainServicePage.class.php
 *
 * This file contains the definition for the ViewDomainService Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/DomainServiceDBO.class.php";

/**
 * ViewDomainServicePage
 *
 * View a domain service.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewDomainServicePage extends Page
{
  /**
   * Initialize the View Domain Service Page
   *
   * If a domain service ID (the TLD) is provided in the query string, use that to
   * load the DomainServiceDBO from the database, then place the DBO in the session.
   * Otherwise, use the DBO that is already there
   */
  function init()
  {
    $tld = $_GET['tld'];

    if( isset( $tld ) )
      {
	// Retrieve the Domain Service from the database
	$dbo = load_DomainServiceDBO( strip_tags( $tld ) );
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
   *   view_domain_service_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "view_domain_service_action":

	if( isset( $this->session['view_domain_service_action']['edit'] ) )
	  {
	    // Edit this Domain Service
	    $this->goto( "services_edit_domain_service",
			 null,
			 "tld=" . $this->session['domain_service_dbo']->getTLD() );
	  }
	elseif( isset( $this->session['view_domain_service_action']['delete'] ) )
	  {
	    // Delete this Domain Service
	    $this->goto( "services_delete_domain_service",
			 null,
			 "tld=" . $this->session['domain_service_dbo']->getTLD() );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>