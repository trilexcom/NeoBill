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
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/NoteDBO.class.php";
require_once BASE_PATH . "DBO/HostingServicePurchaseDBO.class.php";
require_once BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";
require_once BASE_PATH . "DBO/ProductPurchaseDBO.class.php";

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

    // Set URL Fields
    $this->setURLField( "account", $this->get['account']->getID() );

    // Set this page's Nav Vars
    $this->setNavVar( "account_id",   $this->get['account']->getID() );
    $this->setNavVar( "account_name", $this->get['account']->getAccountName() );
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
	$this->setTemplate( "default" );
	break;

      case "services":
	$this->setTemplate( "services" );
	break;

      case "domains":
	$this->setTemplate( "domains" );
	break;

      case "products":
	$this->setTemplate( "products" );
	break;

      case "billing":
	$this->setTemplate( "billing" );
	break;

      case "delete_product":
	$this->deleteProduct();
	break;

      case "delete_domain":
	$this->deleteDomain();
	break;

      case "delete_hosting":
	$this->deleteHosting();
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

      case "view_account_note":
	if( isset( $this->post['add'] ) )
	  {
	    $this->add_note();
	  }
	break;

      case "delete_note":
	$this->delete_note();
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
    if( $this->get['ppurchase']->getAccountID() != $this->get['account']->getID() )
      {
	throw new SWException( "The product you are trying to delete does not belong to this account" );
      }

    if( !delete_ProductPurchaseDBO( $this->get['ppurchase'] ) )
      {
	// Error
	$this->setError( array( "type" => "DB_DELETE_PRODUCT_PURCHASE_FAILED",
				"args" => array( $this->get['ppurchase']->getProductName() ) ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "PRODUCT_PURCHASE_DELETED",
			      "args" => array( $this->get['ppurchase']->getProductName() ) ) );
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
    if( $this->get['dpurchase']->getAccountID() != $this->get['account']->getID() )
      {
	throw new SWException( "The domain purchase to be deleted does not match the account" );
      }

    if( !delete_DomainServicePurchaseDBO( $this->get['dpurchase'] ) )
      {
	// Error
	$this->setError( array( "type" => "DB_DELETE_DOMAIN_PURCHASE_FAILED",
				"args" => array( $this->get['dpurchase']->getFullDomainName() ) ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "DOMAIN_PURCHASE_DELETED",
			      "args" => array( $this->get['dpurchase']->getFullDomainName() ) ) );
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
    if( $this->get['hpurchase']->getAccountID() != $this->get['account']->getID() )
      {
	throw new SWException( "Attempted to delete a hosting purchase that does not match this account." );
      }

    if( !delete_HostingServicePurchaseDBO( $this->get['hpurchase'] ) )
      {
	// Error
	$this->setError( array( "type" => "DB_DELETE_HOSTING_PURCHASE_FAILED",
				"args" => array( $this->get['hpurchase']->getTitle() ) ) );
	$this->reload();
      }

    // Success
    $this->setMessage( array( "type" => "HOSTING_PURCHASE_DELETED",
			      "args" => array( $this->get['hpurchase']->getTitle() ) ) );
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

    if( !isset( $this->get['note'] ) )
      {
	// Note not found
	throw new SWException( "There is no note to delete!" );
      }

    if( $user_dbo->getType() != "Administrator" &&
	$user_dbo->getUsername() != $this->get['note']->getUsername() )
      {
	// User does not have the authority to delete this note
	$this->setError( array( "type" => "ACCESS_DENIED" ) );
	$this->reload();
      }

    // Delete the note
    if( !delete_NoteDBO( $this->get['note'] ) )
      {
	// Error deleting note
	$this->setError( array( "type" => "DB_NOTE_DELETE_FAILED" ) );
	$this->reload();
      }

    // Note deleted
    $this->setMessage( array( "type" => "NOTE_DELETED" ) );
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
    if( !add_NoteDBO( $note_dbo ) )
      {
	// Unable to add note to database
	$this->setError( array( "type" => "DB_NOTE_ADD_FAILED" ) );
	$this->reload();
      }

    // Account added - clear form data from session
    unset( $this->session['view_account_note'] );
    $this->setMessage( array( "type" => "NOTE_ADDED" ) );
    $this->reload();
  }
}
?>