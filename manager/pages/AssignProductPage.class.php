<?php
/**
 * AssignProductPage.class.php
 *
 * This file contains the definition for the AssignProductPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

require_once $base_path . "DBO/AccountDBO.class.php";

/**
 * AssignProductPage
 *
 * Assign a product purchase to an account
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AssignProductPage extends Page
{

  /**
   * Initialize Assign Product Page
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
   *   assign_product (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "assign_product":

	if( isset( $this->session['assign_product']['continue'] ) )
	  {
	    // Add product to account
	    $this->assign_product();
	  }
	elseif( isset( $this->session['assign_product']['cancel'] ) )
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
   * Assign Product
   *
   * Create a Product Purchase DBO and add it to the database
   */
  function assign_product()
  {
    $product_id = $this->session['assign_product']['productid'];
    $note       = $this->session['assign_product']['note'];
    $date       = $this->session['assign_product']['date'];

    // Load ProductDBO
    if( ( $product_dbo = load_ProductDBO( $product_id ) ) == null )
      {
	// Invalid product id
	fatal_error( "AssignProductPage::assign_product()",
		     "Invalid Product ID: " . $product_id );
      }

    // Create new HostingServicePurchase DBO
    $purchase_dbo = new ProductPurchaseDBO();
    $purchase_dbo->setAccountID( $this->session['account_dbo']->getID() );
    $purchase_dbo->setProductID( $product_id );
    $purchase_dbo->setDate( $this->DB->format_datetime( $date ) );
    $purchase_dbo->setNote( $note );

    // Save purchase
    if( !add_ProductPurchaseDBO( $purchase_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ASSIGN_PRODUCT_FAILED",
				"args" => array( $service_dbo->getName() ) ) );
	$this->goback( 1 );
      }
    
    // Success
    $this->setMessage( array( "type" => "PRODUCT_ASSIGNED" ) );
    $this->goto( "accounts_view_account",
		 null,
		 "action=products&id=" . $this->session['account_dbo']->getID() );
  }
}