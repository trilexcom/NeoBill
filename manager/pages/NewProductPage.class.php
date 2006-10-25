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
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

// Include the ProductDBO class
require_once BASE_PATH . "DBO/ProductDBO.class.php";

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
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "new_product":
	if( isset( $this->post['continue'] ) )
	  {
	    // Process new product form
	    $this->process_new_product();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Canceled
	    $this->goback();
	  }
	break;

      case "new_product_confirm":
	if( isset( $this->post['continue'] ) )
	  {
	    // Go ahead
	    $this->add_product();
	  }
	else
	  {
	    // Go back
	    $this->setTemplate( "default" );
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Process New Product
   *
   * Place the new product data from the form into a new ProductDBO, then ask
   * the client to confirm the new Product.
   */
  function process_new_product()
  {
    // Prepare ProductDBO for database
    $product_dbo = new ProductDBO();
    $product_dbo->load( $this->post );

    // Place DBO in the session for confirm
    $this->session['new_product_dbo'] = $product_dbo;

    // Ask client to confirm
    $this->setTemplate( "confirm" );
  }

  /**
   * Add Product
   *
   * Add the ProductDBO to the database.
   */
  function add_product()
  {
    // Extract product DBO from the session
    $product_dbo =& $this->session['new_product_dbo'];

    // Insert ProductDBO into database
    if( !add_ProductDBO( $product_dbo ) )
      {
	// Unable to add product to database
	$this->setError( array( "type" => "DB_PRODUCT_ADD_FAILED",
				"args" => array( $product_dbo->getName() ) ) );

	// Redisplay form
	$this->setTemplate( "default" );
      }
    else
      {
	// Jump to View Product page
	$this->setMessage( array( "type" => "PRODUCT_ADDED" ) );
	$this->goto( "services_view_product", null, "product=" . $product_dbo->getID() );
      }
  }
}

?>