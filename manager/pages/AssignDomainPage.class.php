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
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/AccountDBO.class.php";

/**
 * AssignDomainPage
 *
 * Assigns a domain purchase (without actually registering it) to an account.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AssignDomainPage extends SolidStatePage
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
    parent::init();

    // Set URL Fields
    $this->setURLField( "account", $this->get['account']->getID() );

    // Store account DBO in session
    $this->session['account_dbo'] =& $this->get['account'];
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
	if( isset( $this->post['continue'] ) )
	  {
	    // Add service to account
	    $this->assign_service();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel
	    $this->goback();
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
    // Create new DomainServicePurchase DBO
    $purchase_dbo = new DomainServicePurchaseDBO();
    $purchase_dbo->setAccountID( $this->get['account']->getID() );
    $purchase_dbo->setTLD( $this->post['tld']->getTLD() );
    $purchase_dbo->setTerm( $this->post['term'] );
    $purchase_dbo->setDate( $this->DB->format_datetime( $this->post['date'] ) );
    $purchase_dbo->setDomainName( $this->post['domainname'] );

    // Save purchase
    if( !add_DomainServicePurchaseDBO( $purchase_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ASSIGN_DOMAIN_FAILED",
				"args" => array( $service_dbo->getTitle() ) ) );
	$this->reload();
      }
    
    // Success
    $this->setMessage( array( "type" => "DOMAIN_ASSIGNED" ) );
    $this->goto( "accounts_view_account",
		 null,
		 "action=domains&account=" . $this->get['account']->getID() );
  }
}