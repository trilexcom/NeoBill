<?php
/**
 * NewProductPage.class.php
 *
 * This file contains the definition for the NewProductPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * NewProductPage
 *
 * Create a new product
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NewProductPage extends SolidStateAdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   new_product (form)
   *   new_product_confirm (form)
   *
   * @param string $action_name Action
   */
  public function action( $action_name )
  {
    switch( $action_name )
      {
      case "new_product":
	if( isset( $this->post['continue'] ) )
	  {
	    // Process new product form
	    $this->add_product();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Canceled
	    $this->goback();
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Add Product
   *
   * Add the ProductDBO to the database.
   */
  protected function add_product()
  {
    // Prepare ProductDBO for database
    $product_dbo = new ProductDBO();
    $product_dbo->setName( $this->post['name'] );
    $product_dbo->setDescription( $this->post['description'] );

    // Insert ProductDBO into database
    add_ProductDBO( $product_dbo );

    // Jump to View Product page
    $this->setMessage( array( "type" => "[PRODUCT_ADDED]" ) );
    $this->goto( "services_edit_product", null, "product=" . $product_dbo->getID() );
  }
}
?>