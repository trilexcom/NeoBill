<?php
/**
 * DeleteProductPage.class.php
 *
 * This file contains the definition for the Delete Product Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * DeleteProductPage
 *
 * Delete a Product from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteProductPage extends SolidStateAdminPage
{
  /**
   * Initialize Delete Product Page
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
   *   delete_product (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "delete_product":
	if( isset( $this->post['delete'] ) )
	  {
	    $this->delete_product();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->goback();
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
   * Delete ProductDBO from the database
   */
  function delete_product()
  {
    // Delete Product DBO
    delete_ProductDBO( $this->get['product'] );

    // Success - go back to products page
    $this->setMessage( array( "type" => "[PRODUCT_DELETED]",
			      "args" => array( $this->session['product_dbo']->getName() ) ) );
    $this->gotoPage( "services_products" );
  }
}

?>