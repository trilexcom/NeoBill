<?php
/**
 * AssignDomainPage.class.php
 *
 * This file contains the definition for the AssignDomainPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

/**
 * AssignDomainPage
 *
 * Assigns a domain purchase (without actually registering it) to an account.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AssignDomainPage extends Page
{
  /**
   * Initialize Assign Domain Page
   *
   * If an Account ID is provided in the query string, load that AccountDBO
   * and store it in the session.  Otherwise, continue using the DBO that is
   * already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Account from the database
	$dbo = load_AccountDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['account_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Domain Service
	$this->setError( array( "type" => "DB_ACCOUNT_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['account_dbo'] = $dbo;
      }    
  }

  /**
   * Actions
   *
   * Actions handled by this page:
   *   assign_domain (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "assign_domain":

	if( isset( $this->session['assign_domain']['continue'] ) )
	  {
	    // Add service to account
	    $this->assign_service();
	  }
	elseif( isset( $this->session['assign_domain']['cancel'] ) )
	  {
	    // Cancel
	    $this->goto( "accounts_view_account",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
	  }
	
	break;

      default:

	// No matching action - refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Assign Domain Service
   *
   * Create a DomainServicePurchaseDBO and add it to the database
   */
  function assign_service()
  {
    $service_tld = $this->session['assign_domain']['servicetld'];
    $term        = $this->session['assign_domain']['term'];
    $domainname  = $this->session['assign_domain']['domainname'];
    $date        = $this->session['assign_domain']['date'];

    // Load DomainServiceDBO
    if( ( $service_dbo = load_DomainServiceDBO( $service_tld ) ) == null )
      {
	// Invaltld domain service tld
	fatal_error( "AssignDomainPage::assign_service()",
		     "Invalid DomainService TLD: " . $service_tld );
      }

    // Create new DomainServicePurchase DBO
    $purchase_dbo = new DomainServicePurchaseDBO();
    $purchase_dbo->setAccountID( $this->session['account_dbo']->getID() );
    $purchase_dbo->setTLD( $service_tld );
    $purchase_dbo->setTerm( $term );
    $purchase_dbo->setDate( $this->DB->format_datetime( $date ) );
    $purchase_dbo->setDomainName( $domainname );

    // Save purchase
    if( !add_DomainServicePurchaseDBO( $purchase_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ASSIGN_DOMAIN_FAILED",
				"args" => array( $service_dbo->getTitle() ) ) );
	$this->goback( 1 );
      }
    
    // Success
    $this->setMessage( array( "type" => "DOMAIN_ASSIGNED" ) );
    $this->goto( "accounts_view_account",
		 null,
		 "action=domains&id=" . $this->session['account_dbo']->getID() );
  }
}
