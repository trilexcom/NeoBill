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
require_once BASE_PATH . "solidworks/AdminPage.class.php";

require_once BASE_PATH . "DBO/ProductDBO.class.php";
require_once BASE_PATH . "DBO/ProductPurchaseDBO.class.php";

/**
 * DeleteProductPage
 *
 * Delete a Product from the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DeleteProductPage extends AdminPage
{
  /**
   * Initialize Delete Product Page
   *
   * If the Product ID is provided in the query string, load the ProductDBO from the
   * database and place it in the session.  Otherwise, use the DBO already there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Product from the database
	$dbo = load_ProductDBO( $id );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['product_dbo'];
      }

    if( !isset( $dbo ) )
      {
	// Could not find Product
	$this->setError( array( "type" => "DB_PRODUCT_NOT_FOUND",
				"args" => array( $id ) ) );
      }
    else
      {
	// Store service DBO in session
	$this->session['product_dbo'] = $dbo;
      }
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

	if( isset( $this->session['delete_product']['delete'] ) )
	  {
	    $this->delete_product();
	  }
	elseif( isset( $this->session['delete_product']['cancel'] ) )
	  {
	    $this->cancel();
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goto( "services_view_product",
		 null,
		 "id=" . $this->session['product_dbo']->getID() );
  }

  /**
   * Delete Product
   *
   * Delete ProductDBO from the database
   */
  function delete_product()
  {
    $id = $this->session['product_dbo']->getID();
    if( load_array_ProductPurchaseDBO( "productid=" . $id ) != null )
      {
	// Can not delete product if any purchases exist
	$this->setError( array( "type" => "PURCHASES_EXIST" ) );
	$this->cancel();
      }

    // Delete Product DBO
    if( !delete_ProductDBO( $this->session['product_dbo'] ) )
      {
	// Delete failed
	$this->setError( array( "type" => "DB_PRODUCT_DELETE_FAILED",
				"args" => array( $this->session['product_dbo']->getName() ) ) );
	$this->cancel();
      }

    // Success - go back to products page
    $this->setMessage( array( "type" => "PRODUCT_DELETED",
			      "args" => array( $this->session['product_dbo']->getName() ) ) );
    $this->goto( "services_products" );
  }
}

?>