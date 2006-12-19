<?php
/**
 * ProductsPage.class.php
 *
 * This file contains the definition for the Products Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ProductsPage
 *
 * Display a list of Products being offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductsPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   products_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "products_action":
	if( isset( $this->post['add'] ) )
	  {
	    // Goto new user page
	    $this->goto( "services_new_product" );
	  }
	break;

      case "search_products":
	$this->searchTable( "products", "products", $this->post );
	break;

      case "products":
	if( isset( $this->post['remove'] ) )
	  {
	    $this->removeProduct();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Delete Product
   *
   * Delete ProductDBO from database
   */
  function removeProduct()
  {
    foreach( $this->post['products'] as $dbo )
      {
	// Delete Product DBO
	delete_ProductDBO( $dbo );
      }

    // Success - go back to products page
    $this->setMessage( array( "type" => "[PRODUCTS_DELETED]" ) );
    $this->goto( "services_products" );
  }
}
?>