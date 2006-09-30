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
require_once BASE_PATH . "solidworks/Page.class.php";

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
class ViewAccountPage extends Page
{
  /**
   * Initialize View Account Page
   *
   * If the account ID is provided in the query string, use it to load the AccountDBO
   * from the database, then store the DBO in the session.  Otherwise, use the DBO
   * already there.
   */
  function init()
  {
    if( isset( $this->session['template'] ) )
      {
	$this->setTemplate( $this->session['template'] );
      }

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
	// Could not find Account
	$this->setError( array( "type" => "DB_ACCOUNT_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store Account DBO in session
	$this->session['account_dbo'] = $dbo;

	// Set this page's Nav Vars
	$this->setNavVar( "account_id",   $dbo->getID() );
	$this->setNavVar( "account_name", $dbo->getAccountName() );
      }
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
	$this->session['template'] = "default";
	$this->setTemplate( "default" );
	break;

      case "services":
	$this->session['template'] = "services";
	$this->setTemplate( "services" );
	break;

      case "domains":
	$this->session['template'] = "domains";
	$this->setTemplate( "domains" );
	break;

      case "products":
	$this->session['template'] = "products";
	$this->setTemplate( "products" );
	break;

      case "billing":
	$this->session['template'] = "billing";
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

	if( isset( $this->session['view_account_action']['edit'] ) )
	  {
	    // Edit this Account
	    $this->goto( "accounts_edit_account",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_account_action']['delete'] ) )
	  {
	    // Delete this Account
	    $this->goto( "accounts_delete_account",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
	  }

	break;

      case "view_account_note":
	if( isset( $this->session['view_account_note']['add'] ) )
	  {
	    $this->add_note();
	  }
	break;

      case "delete_note":

	$this->delete_note();

	break;

      case "view_account_hosting":

	if( isset( $this->session['view_account_hosting']['add'] ) )
	  {
	    // Add a hosting service to this account
	    $this->goto( "accounts_assign_hosting",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
	  }

	break;

      case "view_account_domains":

	if( isset( $this->session['view_account_domains']['add'] ) )
	  {
	    // Add a domain to this account
	    $this->goto( "accounts_assign_domain",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
	  }

	break;

      case "view_account_products":

	if( isset( $this->session['view_account_products']['add'] ) )
	  {
	    // Add a product to this account
	    $this->goto( "accounts_assign_product",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
	  }

	break;

      case "view_account_billing_action":

	if( isset( $this->session['view_account_billing_action']['add_invoice'] ) )
	  {
	    // Create a new invoice for this account
	    $this->goto( "accounts_add_invoice",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_account_billing_action']['add_payment'] ) )
	  {
	    // Enter a new payment for this account
	    $this->goto( "accounts_add_payment",
			 null,
			 "id=" . $this->session['account_dbo']->getID() );
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
    $id = intval( $_GET['purchase_id'] );

    if( ($product_dbo = load_ProductPurchaseDBO( $id ) ) == null )
      {
	fatal_error( "ViewAccountPage::deleteProduct()",
		     "could not find product purchase DBO" );
      }

    if( $product_dbo->getAccountID() != $this->session['account_dbo']->getID() )
      {
	fatal_error( "ViewAccountPage::deleteProduct()",
		     "invalid purchase DBO" );
      }

    if( !delete_ProductPurchaseDBO( $product_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_DELETE_PRODUCT_PURCHASE_FAILED",
				"args" => array( $product_dbo->getProductName() ) ) );
      }

    // Success
    $this->setMessage( array( "type" => "PRODUCT_PURCHASE_DELETED",
			      "args" => array( $product_dbo->getProductName() ) ) );
    $this->setTemplate( "products" );
  }

  /**
   * Delete Domain Purchase
   *
   * Remove a domain registration service from this account.
   */
  function deleteDomain()
  {
    $id = intval( $_GET['purchase_id'] );

    if( ($domain_dbo = load_DomainServicePurchaseDBO( $id ) ) == null )
      {
	fatal_error( "ViewAccountPage::deleteDomain()",
		     "could not find domain service purchase DBO" );
      }

    if( $domain_dbo->getAccountID() != $this->session['account_dbo']->getID() )
      {
	fatal_error( "ViewAccountPage::deleteDomain()",
		     "invalid purchase DBO" );
      }

    if( !delete_DomainServicePurchaseDBO( $domain_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_DELETE_DOMAIN_PURCHASE_FAILED",
				"args" => array( $domain_dbo->getFullDomainName() ) ) );
      }

    // Success
    $this->setMessage( array( "type" => "DOMAIN_PURCHASE_DELETED",
			      "args" => array( $domain_dbo->getFullDomainName() ) ) );
    $this->setTemplate( "domains" );
  }

  /**
   * Delete Hosting Service
   *
   * Remove a hosting service purchase from this account
   */
  function deleteHosting()
  {
    $id = intval( $_GET['purchase_id'] );

    if( ($hosting_dbo = load_HostingServicePurchaseDBO( $id ) ) == null )
      {
	fatal_error( "ViewAccountPage::deleteHosting()",
		     "error: could not find hosting service purchase DBO" );
      }

    if( $hosting_dbo->getAccountID() != $this->session['account_dbo']->getID() )
      {
	fatal_error( "ViewAccountPage::deleteHosting()",
		     "invalid purchase DBO" );
      }

    if( !delete_HostingServicePurchaseDBO( $hosting_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_DELETE_HOSTING_PURCHASE_FAILED",
				"args" => array( $hosting_dbo->getTitle() ) ) );
      }

    // Success
    $this->setMessage( array( "type" => "HOSTING_PURCHASE_DELETED",
			      "args" => array( $hosting_dbo->getTitle() ) ) );
    $this->setTemplate( "services" );
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

    // Extract AccountDBO from the session
    $account_dbo =& $this->session['account_dbo'];

    // Get ID of note to be deleted
    $note_id = intval( $_GET['note_id'] );

    // Load note DBO
    $note_dbo = load_NoteDBO( $note_id );
    if( $note_dbo == null )
      {
	// Note not found
	fatal_error( "ViewAccountPage::delete_note()",
		     "Unable to load note, id = " . $note_id );
      }

    if( $note_dbo->getAccountID() != $account_dbo->getID() )
      {
	// Note being deleted does not belong to this account
	fatal_error( "ViewAccountPage::delete_note()",
		     "Accout mismatch when trying to delete note, id = " . $note_id );
      }

    if( $user_dbo->getType() != "Administrator" &&
	$user_dbo->getUsername() != $note_dbo->getUsername() )
      {
	// User does not have the authority to delete this note
	$this->setError( array( "type" => "ACCESS_DENIED" ) );
	return;
      }

    // Delete the note
    if( !delete_NoteDBO( $note_dbo ) )
      {
	// Error deleting note
	$this->setError( array( "type" => "DB_NOTE_DELETE_FAILED" ) );
	return;
      }

    // Note deleted
    $this->setMessage( array( "type" => "NOTE_DELETED" ) );
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

    // Extract AccountDBO from the session
    $account_dbo =& $this->session['account_dbo'];

    // Extract form data
    $note_data = $this->session['view_account_note'];

    if( !isset( $note_data ) )
      {
	// Missing form data 
	fatal_error( "ViewAccountPage::add_note()",
		     "Error: no form data received!" );
      }

    // Create a new NoteDBO
    $note_dbo = new NoteDBO();
    $note_dbo->setAccountID( $account_dbo->getID() );
    $note_dbo->setUsername( $user_dbo->getUsername() );
    $note_dbo->setText( $note_data['text'] );

    // Add NoteDBO to database
    if( !add_NoteDBO( $note_dbo ) )
      {
	// Unable to add note to database
	$this->setError( array( "type" => "DB_NOTE_ADD_FAILED" ) );
      }
    else
      {
	// Account added - clear form data from session
	unset( $this->session['view_account_note'] );
	$this->setMessage( array( "type" => "NOTE_ADDED" ) );
      }
  }

}

?>