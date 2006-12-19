<?php
/**
 * EditProductPage.class.php
 *
 * This file contains the definition for the Edit Product Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * EditProductPage
 *
 * Edit a product offered by the provider.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditProductPage extends SolidStateAdminPage
{
  /**
   * Initialize Edit Product Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "product", $this->get['product']->getID() );

    // Store service DBO in session
    $this->session['product_dbo'] =& $this->get['product'];

    // Setup the pricing table
    $ptw = $this->forms['edit_product_pricing']->getField( "prices" )->getWidget();
    $ptw->setPrices( $this->get['product']->getPricing() );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_product (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_product":
	if( isset( $this->post['save'] ) )
	  {
	    // Save changes
	    $this->update_product();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel
	    $this->goback();
	  }
	break;

      case "edit_product_pricing":
	if( isset( $this->post['delete'] ) )
	  {
	    $this->deletePrice();
	  }

      case "edit_product_add_price":
	if( isset( $this->post['add'] ) )
	  {
	    $this->addPrice();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Add Price
   */
  protected function addPrice()
  {
    if( $this->post['type'] == "Onetime" && $this->post['termlength'] != 0 )
      {
	throw new SWUserException( "[TERMLENGTH_FOR_ONETIME_MUST_BE_ZERO]" );
      }
    if( $this->post['type'] == "Recurring" && $this->post['termlength'] == 0 )
      {
	throw new SWUserException( "[TERMLENGTH_FOR_RECURRING_MUST_NOT_BE_ZERO]" );
      }
    $priceDBO = new ProductPriceDBO();
    $priceDBO->setProductID( $this->get['product']->getID() );
    $priceDBO->setType( $this->post['type'] );
    $priceDBO->setTermLength( $this->post['termlength'] );
    $priceDBO->setPrice( $this->post['price'] );
    $priceDBO->setTaxable( $this->post['taxable'] );

    try
      {
	$this->get['product']->addPrice( $priceDBO );
	add_ProductPriceDBO( $priceDBO );
	$this->setMessage( array( "type" => "[PRICE_ADDED]" ) );
      }
    catch( DuplicatePriceException $e )
      {
	update_ProductPriceDBO( $priceDBO );
	$this->setMessage( array( "type" => "[PRICE_UPDATED]" ) );
      }

    $this->reload();
  }

  /**
   * Delete Price
   */
  protected function deletePrice()
  {
    foreach( $this->post['prices'] as $price )
      {
	delete_ProductPriceDBO( $price );
      }

    $this->setMessage( array( "type" => "[PRICES_DELETED]" ) );
    $this->reload();
  }

  /**
   * Update Product
   *
   * Place the changes from the form into the ProductDBO and update the database
   */
  function update_product()
  {
    // Access DBO
    $product_dbo =& $this->session['product_dbo'];

    // Update DBO
    $product_dbo->setName( $this->post['name'] );
    $product_dbo->setDescription( $this->post['description'] );
    update_ProductDBO( $product_dbo );

    // Sucess!
    $this->setMessage( array( "type" => "[PRODUCT_UPDATED]" ) );
    $this->goback();
  }
}

?>