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
require_once BASE_PATH . "solidworks/AdminPage.class.php";

require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";
require_once BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * DeleteDomainServicePage
 *
 * Delete a DomainService from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteDomainServicePage extends AdminPage
{
  /**
   * Initialize Delete Domain Service Page
   *
   * If the Domain Service ID (the TLD) is provided in the query string then load
   * the DomainServiceDBO from the database and place it in the session.  Otherwise,
   * use the DBO already there.
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
   *   delete_domain_service (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "delete_domain_service":

	if( isset( $this->session['delete_domain_service']['delete'] ) )
	  {
	    $this->delete_domain_service();
	  }
	elseif( isset( $this->session['delete_domain_service']['cancel'] ) )
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
    $this->goto( "services_view_domain_service",
		 null,
		 "tld=" . $this->session['domain_service_dbo']->getTLD() );
  }

  /**
   * Delete Domain Service
   *
   * Delete DomainServiceDBO from database
   */
  function delete_domain_service()
  {
    global $DB;

    $tld = $DB->quote_smart( $this->session['domain_service_dbo']->getTLD() );
    if( load_array_DomainServicePurchaseDBO( "tld=" . $tld ) != null )
      {
	// Can not delete domain service if any purchases exist
	$this->setError( array( "type" => "PURCHASES_EXIST" ) );
	$this->cancel();
      }

    // Delete Domain Service DBO
    if( !delete_DomainServiceDBO( $this->session['domain_service_dbo'] ) )
      {
	// Delete failed
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_DELETE_FAILED",
				"args" => array( $this->session['domain_service_dbo']->getTLD() ) ) );
	$this->cancel();
      }

    // Success - go back to web domain services page
    $this->setMessage( array( "type" => "DOMAIN_SERVICE_DELETED",
			      "args" => array( $this->session['domain_service_dbo']->getTLD() ) ) );
    $this->goto( "services_domain_services" );
  }
}

?>