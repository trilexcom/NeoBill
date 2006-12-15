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
require BASE_PATH . "include/SolidStatePage.class.php";

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
	elseif( isset( $this->post['tld'] ) )
	  {
	    $this->updatePrices( $this->post['tld'] );
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
  public function assign_service()
  {
    // The domain name is required but not configured as such.  This is to allow the 
    // page to update the price dynamically
    if( !isset( $this->post['domainname'] ) )
      {
	$e = new FieldMissingException();
	$e->setField( "domainname" );
	throw $e;
      }

    // Create new DomainServicePurchase DBO
    $purchase_dbo = new DomainServicePurchaseDBO();
    $purchase_dbo->setAccountID( $this->get['account']->getID() );
    $purchase_dbo->setTLD( $this->post['tld']->getTLD() );
    $purchase_dbo->setTerm( $this->post['term'] ?
			    $this->post['term']->getTermLength() : null );
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

  /**
   * Initialize Assign Domain Page
   *
   * If an Account ID is provided in the query string, load that AccountDBO
   * and store it in the session.  Otherwise, continue using the DBO that is
   * already there.
   */
  public function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "account", $this->get['account']->getID() );

    // Store account DBO in session
    $this->session['account_dbo'] =& $this->get['account'];

    if( null == ($services = load_array_DomainServiceDBO()) )
      {
	$this->setError( array( "type" => "[THERE_ARE_NO_DOMAIN_SERVICES]" ) );
	$this->goback();
      }

    if( !isset( $this->post['tld'] ) )
      {
	$this->updatePrices( array_shift( $services ) );
      }
  }

  /**
   * Update Prices Box
   *
   * @param DomainServiceDBO The domain service to show prices for
   */
  protected function updatePrices( DomainServiceDBO $serviceDBO )
  {
    // Update the service terms box
    $widget = $this->forms['assign_domain']->getField( "term" )->getWidget();
    $widget->setPurchasable( $serviceDBO );
  }
}