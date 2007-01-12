<?php
/**
 * ViewAccountPage.class.php
 *
 * This file contains the definition for the ViewAccountPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ViewAccountPage
 *
 * Display a customer account.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewAccountPage extends SolidStatePage
{
  /**
   * Initialize View Account Page
   */
  function init()
  {
    parent::init();

    // Store Account DBO in session
    $this->session['account_dbo'] =& $this->get['account'];

    $accountID = $this->get['account']->getID();

    // Set URL Fields
    $this->setURLField( "account", $accountID );

    // Set this page's Nav Vars
    $this->setNavVar( "account_id",   $accountID );
    $this->setNavVar( "account_name", $this->get['account']->getAccountName() );

    // Provide the service and product counts to the template
    $this->smarty->assign( "hosting_count", 
			   count( $this->get['account']->getHostingServices() ) );
    $this->smarty->assign( "domain_count",
			   count( $this->get['account']->getDomainServices() ) );
    $this->smarty->assign( "product_count",
			   count( $this->get['account']->getProducts() ) );

    // Setup the note table
    $nField = $this->forms['view_account_note']->getField( "notes" );
    $nField->getWidget()->setAccountID( $accountID );
    $nField->getValidator()->setAccountID( $accountID );

    // Setup the hosting service table
    $hsField = $this->forms['hosting_purchases']->getField( "services" );
    $hsField->getWidget()->setAccountID( $accountID );
    $hsField->getValidator()->setAccountID( $accountID );

    // Setup the domain service table
    $dsField = $this->forms['domain_purchases']->getField( "domains" );
    $dsField->getWidget()->setAccountID( $accountID );
    $dsField->getValidator()->setAccountID( $accountID );

    // Setup the product purchase table
    $ppField = $this->forms['product_purchases']->getField( "products" );
    $ppField->getWidget()->setAccountID( $accountID );
    $ppField->getValidator()->setAccountID( $accountID );

    // Setup the invoice table
    $inField = $this->forms['view_account_invoices']->getField( "invoices" );
    $inField->getWidget()->setAccountID( $accountID );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   account_info
   *   services
   *   domains
   *   products
   *   billing
   *   delete_product
   *   delete_domain
   *   delete_hosting
   *   view_account_action (form)
   *   view_account_hosting (form)
   *   view_account_domains (form)
   *   view_account_note (form)
   *   delete_note()
   *   view_account_products (form)
   *   view_account_billing_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "account_info":
	$this->smarty->assign( "tab", "info" );
	break;

      case "services":
	$this->smarty->assign( "tab", "hosting" );
	break;

      case "domains":
	$this->smarty->assign( "tab", "domains" );
	break;

      case "products":
	$this->smarty->assign( "tab", "products" );
	break;

      case "billing":
	$this->smarty->assign( "tab", "billing" );
	break;

      case "product_purchases":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->deleteProduct();
	  }
	break;

      case "domain_purchases":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->deleteDomain();
	  }
	break;

      case "hosting_purchases":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->deleteHosting();
	  }
	break;

      case "view_account_action":
	if( isset( $this->post['edit'] ) )
	  {
	    // Edit this Account
	    $this->goto( "accounts_edit_account",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	elseif( isset( $this->post['delete'] ) )
	  {
	    // Delete this Account
	    $this->goto( "accounts_delete_account",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	break;

      case "view_account_add_note":
	if( isset( $this->post['add'] ) )
	  {
	    $this->add_note();
	  }
	break;
	
      case "view_account_note":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->delete_note();
	  }
	break;

      case "view_account_hosting":
	if( isset( $this->post['add'] ) )
	  {
	    // Add a hosting service to this account
	    $this->goto( "accounts_assign_hosting",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	break;

      case "view_account_domains":
	if( isset( $this->post['add'] ) )
	  {
	    // Add a domain to this account
	    $this->goto( "accounts_assign_domain",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	break;

      case "view_account_products":
	if( isset( $this->post['add'] ) )
	  {
	    // Add a product to this account
	    $this->goto( "accounts_assign_product",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	break;

      case "view_account_billing_action":
	if( isset( $this->post['add_invoice'] ) )
	  {
	    // Create a new invoice for this account
	    $this->goto( "accounts_add_invoice",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	elseif( isset( $this->post['add_payment'] ) )
	  {
	    // Enter a new payment for this account
	    $this->goto( "accounts_add_payment",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Product Purchase
   *
   * Remove a produt purchase from this account.
   */
  function deleteProduct()
  {
    // Delete the product purchases
    foreach( $this->post['products'] as $dbo )
      {
	delete_ProductPurchaseDBO( $dbo );
      }

    // Success
    $this->setMessage( array( "type" => "[PRODUCT_PURCHASE_DELETED]" ) );
    $this->setURLField( "action", "products" );
    $this->reload();
  }

  /**
   * Delete Domain Purchase
   *
   * Remove a domain registration service from this account.
   */
  function deleteDomain()
  {
    // Delete the domain purchases
    foreach( $this->post['domains'] as $dbo )
      {
	delete_DomainServicePurchaseDBO( $dbo );
      }

    // Success
    $this->setMessage( array( "type" => "[DOMAIN_PURCHASE_DELETED]" ) );
    $this->setURLField( "action", "domains" );
    $this->reload();
  }

  /**
   * Delete Hosting Service
   *
   * Remove a hosting service purchase from this account
   */
  function deleteHosting()
  {
    // Delete the service purchases
    foreach( $this->post['services'] as $dbo )
      {
	delete_HostingServicePurchaseDBO( $dbo );
      }

    // Success
    $this->setMessage( array( "type" => "[HOSTING_PURCHASES_DELETED]" ) );
    $this->setURLField( "action", "services" );
    $this->reload();
  }

  /**
   * Delete Note
   *
   * Remove a note from this account.
   */
  function delete_note()
  {
    // Extract UserDBO of client
    $user_dbo = $_SESSION['client']['userdbo'];

    // Delete the notes
    foreach( $this->post['notes'] as $noteDBO )
      {
	if( $user_dbo->getType() != "Administrator" &&
	    $user_dbo->getUsername() != $noteDBO->getUsername() )
	  {
	    // User does not have the authority to delete this note
	    throw new SWUserException( "[ACCESS_DENIED]" );
	  }

	// Delete the note
	delete_NoteDBO( $noteDBO );
      }

    // Note deleted
    $this->setMessage( array( "type" => "[NOTE_DELETED]" ) );
    $this->reload();
  }
  
  /**
   * Add Note
   *
   * Attach a note to this account
   */
  function add_note()
  {
    // Extract UserDBO of client
    $user_dbo = $_SESSION['client']['userdbo'];

    // Create a new NoteDBO
    $note_dbo = new NoteDBO();
    $note_dbo->setAccountID( $this->get['account']->getID() );
    $note_dbo->setUsername( $user_dbo->getUsername() );
    $note_dbo->setText( $this->post['text'] );

    // Add NoteDBO to database
    add_NoteDBO( $note_dbo );

    // Account added - clear form data from session
    unset( $this->session['view_account_note'] );
    $this->setMessage( array( "type" => "[NOTE_ADDED]" ) );
    $this->reload();
  }
}
?>