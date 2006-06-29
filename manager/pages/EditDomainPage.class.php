<?
/**
 * EditDomainPage.class.php
 *
 * This file contains the definition for the EditDomainPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// Include DomainServicePurchaseDBO class
require_once $base_path . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * EditDomainPage
 *
 * Edit a domain registration purchase
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditDomainPage extends Page
{
  /**
   * Initialize the Edit Domain Page
   *
   * If the domain purchase ID is provided in the query string, load the
   * DomainServicePurchaseDBO from the database and store it in the session.
   * Otherwise, use the DBO that is already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the DomainServicePurchaseDBO from the database
	$dbo = load_DomainServicePurchaseDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['domain_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Domain
	fatal_error( "EditDomainPage::init()",
		     "could not find domainservicepurchasedbo!" );
      }
    else
      {
	// Store DBO in session
	$this->session['domain_dbo'] = $dbo;
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_domain (form)
   *   renew_domain (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "edit_domain":

	if( isset( $this->session['edit_domain']['continue'] ) )
	  {
	    $this->edit_domain();
	  }
	elseif( isset( $this->session['edit_domain']['cancel'] ) )
	  {
	    $this->cancel();
	  }

	break;

      case "renew_domain":

	if( isset( $this->session['renew_domain']['continue'] ) )
	  {
	    $this->renew_domain();
	  }

	break;

      default:

	// No matching action - refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Cancel Form
   */
  function cancel()
  {
    // Cancel
    $this->goback( 2 );
  }

  /**
   * Edit Domain
   *
   * Take the changes from the form and store them in the DBO.  Then update the
   * DBO in the database.
   */
  function edit_domain()
  {
    $domain_dbo =& $this->session['domain_dbo'];
    $domain_data = $this->session['edit_domain'];

    // Update DBO
    $domain_dbo->setDomainName( $domain_data['domainname'] );
    $domain_dbo->setTLD( $domain_data['tld'] );
    $domain_dbo->setTerm( $domain_data['term'] );
    $domain_dbo->setDate( $this->DB->format_datetime( $domain_data['date'] ) );
    if( !update_DomainServicePurchaseDBO( $domain_dbo ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_PURCHASE_UPDATE_FAILED" ) );
	$this->goback( 1 );
      }

    // Success!
    $this->setMessage( array( "type" => "DOMAIN_SERVICE_PURCHASE_UPDATED" ) );
    $this->goback( 2 );
  }

  /**
   * Renew Domain
   *
   * Set the DomainServucePurchase date to the date provided in the form, then update
   * the DomainServicePurchaseDBO in the database
   */
  function renew_domain()
  {
    $domain_dbo =& $this->session['domain_dbo'];
    $domain_data = $this->session['renew_domain'];

    // Update DBO
    $domain_dbo->setDate( $this->DB->format_datetime( $domain_data['date'] ) );
    $domain_dbo->setTerm( $domain_data['term'] );
    if( !update_DomainServicePurchaseDBO( $domain_dbo ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_PURCHASE_UPDATE_FAILED" ) );
	$this->goback( 1 );
      }

    // Success!
    $this->setMessage( array( "type" => "DOMAIN_RENEWED" ) );
    $this->goback( 2 );
  }
}

?>