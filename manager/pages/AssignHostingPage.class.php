<?php
/**
 * AssignHostingPage.class.php
 *
 * This file contains the definition for the AssignHostingPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

/**
 * AssignHostingPage
 *
 * Assign a hosting service purchase to an account.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AssignHostingPage extends Page
{
  /**
   * Initialize Assign Hosting Page
   *
   * If an account ID is provided in the query string, load that AccountDBO and
   * store it in the session.  Otherwise, continue using the DBO that is already
   * there.
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
   * Action
   *
   * Actions handled by this page:
   *   assign_hosting (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "assign_hosting":

	if( isset( $this->session['assign_hosting']['continue'] ) )
	  {
	    // Add service to account
	    $this->assign_service();
	  }
	elseif( isset( $this->session['assign_hosting']['cancel'] ) )
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
   * Assign Service
   *
   * Create a HostingServicePurchaseDBO and add it to the database
   */
  function assign_service()
  {
    $service_id = $this->session['assign_hosting']['serviceid'];
    $server_id  = $this->session['assign_hosting']['server'];
    $ipaddress  = $this->session['assign_hosting']['ipaddress'];
    $term       = $this->session['assign_hosting']['term'];
    $date       = $this->session['assign_hosting']['date'];
    $server_dbo = load_ServerDBO( $server_id );

    // Load HostingServiceDBO
    if( ( $service_dbo = load_HostingServiceDBO( $service_id ) ) == null )
      {
	// Invalid hosting service id
	fatal_error( "AssignHostingPage::assign_service()",
		     "Invalid HostingService ID: " . $service_id );
      }

    // If this HostingService requires a unique IP, make sure the user selected one
    if( $service_dbo->getUniqueIP() == "Required" && !isset( $ipaddress ) )
      {
	$this->setError( array( "type" => "SELECT_IP" ) );
	$this->goback( 1 );
      }

    // Create new HostingServicePurchase DBO
    $purchase_dbo = new HostingServicePurchaseDBO();
    $purchase_dbo->setAccountID( $this->session['account_dbo']->getID() );
    $purchase_dbo->setHostingServiceID( $service_id );
    $purchase_dbo->setTerm( $term );
    $purchase_dbo->setServerID( $server_id );
    $purchase_dbo->setDate( $this->DB->format_datetime( $date ) );

    // Save purchase
    if( !add_HostingServicePurchaseDBO( $purchase_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ASSIGN_HOSTING_FAILED",
				"args" => array( $service_dbo->getTitle() ) ) );
	$this->goback( 1 );
      }

    // If an IP address was selected, assign that IP address to this purchase
    if( isset( $ipaddress ) )
      {
	if( ($ipaddress_dbo = load_IPAddressDBO( intval( $ipaddress ) )) == null )
	  {
	    // Invalid IP
	    $this->setError( array( "type" => "DB_IP_NOT_FOUND",
				    "args" => array( long2ip( $ipaddress ) ) ) );
	    // Roll-back
	    delete_HostingServicePurchaseDBO( $purchase_dbo );
	    $this->goback( 1 );
	  }

	if( $ipaddress_dbo->getServerID() != $server_id )
	  {
	    // IP Address does not match Server
	    $this->setError( array( "type" => "IP_MISMATCH",
				    "args" => array( $ipaddress_dbo->getIPString(),
						     $server_dbo->getHostName() ) ) );
	    // Roll-back
	    delete_HostingServicePurchaseDBO( $purchase_dbo );
	    $this->goback( 1 );
	  }

	// Update IP Address record
	$ipaddress_dbo->setPurchaseID( $purchase_dbo->getID() );
	if( !update_IPAddressDBO( $ipaddress_dbo ) )
	  {
	    // Invalid IP
	    $this->setError( array( "type" => "DB_IP_UPDATE_FAILED" ) );

	    // Roll-back
	    delete_HostingServicePurchaseDBO( $purchase_dbo );
	    $this->goback( 1 );	    
	  }
      }
    
    // Success
    $this->setMessage( array( "type" => "HOSTING_ASSIGNED" ) );
    $this->goto( "accounts_view_account",
		 null,
		 "action=services&id=" . $this->session['account_dbo']->getID() );
  }
}