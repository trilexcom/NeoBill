<?php
/**
 * EditHostingPurchasePage.class.php
 *
 * This file contains the definition for the EditHostingPurchasePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * EditHostingPurchasePage
 *
 * Edit the details of a hosting service purchase
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditHostingPurchasePage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   assign_hosting (form)
   *
   * @param string $action_name Action
   */
  public function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_hosting_purchase_action":
	if( isset( $this->post['createaccount'] ) )
	  {
	    $this->createAccount();
	  }
	elseif( isset( $this->post['suspendaccount'] ) )
	  {
	    $this->suspendAccount();
	  }
	elseif( isset( $this->post['unsuspendaccount'] ) )
	  {
	    $this->unsuspendAccount();
	  }
	elseif( isset( $this->post['killaccount'] ) )
	  {
	    $this->killAccount();
	  }
	break;
	
      case "edit_hosting_purchase":
	if( isset( $this->post['save'] ) )
	  {
	    $this->save();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->goback();
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Create Account on Server
   */
  public function createAccount()
  {
    $serverDBO = $this->get['hspurchase']->getServerDBO();
    $username = $this->get['hspurchase']->getAccountDBO()->getUsername();
    $tempPassword = 
      $serverDBO->createAccount( $this->get['hspurchase']->getPurchasable(),
				 $this->get['hspurchase']->getDomainName(),
				 $username );
    
    // Success
    $this->setMessage( array( "type" => "[CONTROL_PANEL_ACCOUNT_SUCCESSFULLY_CREATED]" ) );
    $this->setMessage( array( "type" => "[USERNAME]: " . $username ) );
    $this->setMessage( array( "type" => "[TEMPORARY_PASSWORD]: " . $tempPassword ) );
  }

  /**
   * Initialize the Page
   */
  public function init()
  {
    parent::init();

    // Setup the pricing/term menu
    $widget = $this->forms['edit_hosting_purchase']->getField( "term" )->getWidget();
    $widget->setPurchasable( $this->get['hspurchase']->getPurchasable() );

    // Provide the purchase and server objects to the template
    $this->smarty->assign_by_ref( "purchaseDBO", $this->get['hspurchase'] );
    $this->smarty->assign_by_ref( "serverDBO", $this->get['hspurchase']->getServerDBO() );

    // Set URL Fields
    $this->setURLField( "hspurchase", $this->get['hspurchase']->getID() );
  }

  /**
   * Kill Control Panel Account
   */
  public function killAccount()
  {
    $accountDBO = $this->get['hspurchase']->getAccountDBO();
    $serverDBO = $this->get['hspurchase']->getServerDBO();
    $serverDBO->killAccount( $accountDBO->getUserDBO()->getUsername() );

    // Success
    $this->setMessage( array( "type" => "[CONTROL_PANEL_ACCOUNT_TERMINATED]" ) );
  }

  

  /**
   * Save Hosting Service Purchase
   */
  public function save()
  {
    $nextBillingDate = DBConnection::format_date( $this->post['nextbillingdate'] );
    $this->get['hspurchase']->setTerm( $this->post['term']->getTermLength() );
    $this->get['hspurchase']->setNextBillingDate( $nextBillingDate );
    $this->get['hspurchase']->setDomainName( $this->post['domain'] );
    $this->get['hspurchase']->setServerID( $this->post['server']->getID() );

    update_HostingServicePurchaseDBO( $this->get['hspurchase'] );

    // Success
    $this->setMessage( array( "type" => "[CHANGES_SAVED]" ) );
    $this->reload();
  }

  /**
   * Suspend Control Panel Account
   */
  public function suspendAccount()
  {
    $accountDBO = $this->get['hspurchase']->getAccountDBO();
    $serverDBO = $this->get['hspurchase']->getServerDBO();
    $serverDBO->suspendAccount( $accountDBO->getUserDBO()->getUsername() );

    // Success
    $this->setMessage( array( "type" => "[CONTROL_PANEL_ACCOUNT_SUSPENDED]" ) );
  }

  /**
   * Un-suspend Control Panel Account
   */
  public function unsuspendAccount()
  {
    $accountDBO = $this->get['hspurchase']->getAccountDBO();
    $serverDBO = $this->get['hspurchase']->getServerDBO();
    $serverDBO->unsuspendAccount( $accountDBO->getUserDBO()->getUsername() );

    // Success
    $this->setMessage( array( "type" => "[CONTROL_PANEL_ACCOUNT_UNSUSPENDED]" ) );
  }
}
?>