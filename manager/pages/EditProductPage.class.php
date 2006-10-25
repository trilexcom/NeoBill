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
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

require_once BASE_PATH . "DBO/ProductDBO.class.php";

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

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
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
    $product_dbo->setPrice( $this->post['price'] );
    $product_dbo->setTaxable( $this->post['taxable'] );
    if( !update_ProductDBO( $product_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_PRODUCT_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Sucess!
    $this->setMessage( array( "type" => "PRODUCT_UPDATED" ) );
    $this->goback();
  }
}

?>