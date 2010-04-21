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
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * AssignProductPage
 *
 * Assign a product purchase to an account
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AssignProductPage extends SolidStatePage
{
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
	if( isset( $this->post['continue'] ) )
	  {
	    // Add product to account
	    $this->assign_product();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel
	    $this->goback();
	  }
	elseif( isset( $this->post['product'] ) )
	  {
	    $this->updatePrices( $this->post['product'] );
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize Assign Product Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "account", $this->get['account']->getID() );

    // Store service DBO in session
    $this->session['account_dbo'] = $dbo;

    try{ $products = load_array_ProductDBO(); }
    catch( DBNoRowsFoundException $e )
      {
	throw new SWUserException( "[THERE_ARE_NO_PRODUCTS]" );
      }

    if( !isset( $this->post['product'] ) )
      {
	$this->updatePrices( array_shift( $products ) );
      }
  }

  /**
   * Assign Product
   *
   * Create a Product Purchase DBO and add it to the database
   */
  function assign_product()
  {
    // Create new ProductPurchase DBO
    $purchase_dbo = new ProductPurchaseDBO();
    $purchase_dbo->setAccountID( $this->get['account']->getID() );
    $purchase_dbo->setProductID( $this->post['product']->getID() );
    $purchase_dbo->setTerm( isset( $this->post['term'] ) ? 
				   $this->post['term']->getTermLength() :
				   null );
    $purchase_dbo->setDate( DBConnection::format_datetime( $this->post['date'] ) );
    $purchase_dbo->setNote( $this->post['note'] );

    // Save purchase
    add_ProductPurchaseDBO( $purchase_dbo );
    
    // Success
    $this->setMessage( array( "type" => "[PRODUCT_ASSIGNED]" ) );
    $this->gotoPage( "accounts_view_account",
		 null,
		 "action=products&account=" . $this->get['account']->getID() );
  }

  /**
   * Update Prices Box
   *
   * @param ProductDBO The product to show prices for
   */
  protected function updatePrices( ProductDBO $productDBO )
  {
    // Update the service terms box
    $widget = $this->forms['assign_product']->getField( "term" )->getWidget();
    $widget->setPurchasable( $productDBO );
  }
}