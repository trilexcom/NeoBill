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
require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * EditProductPage
 *
 * Edit a product offered by the provider.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditProductPage extends AdminPage
{
  /**
   * Initialize Edit Product Page
   *
   * If the Product ID is provided in the query string, load the ProductDBO from the
   * database and store it in the session.  Otherwise, use the DBO that is already
   * there.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Product from the database
	$dbo = load_ProductDBO( intval( $id ) );
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
   *   edit_product (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "edit_product":

	if( isset( $this->session['edit_product']['save'] ) )
	  {
	    // Save changes
	    $this->update_product();
	    $this->goto( "services_view_product",
			 array( array( "type" => "PRODUCT_UPDATED" ) ),
			 "id=" . $this->session['product_dbo']->getID() );
	  }
	elseif( isset( $this->session['edit_product']['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goto( "services_view_product",
			 null,
			 "id=" . $this->session['product_dbo']->getID() );
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

    // Pull form data from session
    $product_data = $this->session['edit_product'];
   
    if( !isset( $product_data ) )
      {
	// Missing form data
	fatal_error( "EditProductPage::update_product()", "no form data received!" );
      }

    // Update DBO
    $product_dbo->setName( $product_data['name'] );
    $product_dbo->setDescription( $product_data['description'] );
    $product_dbo->setPrice( $product_data['price'] );
    $product_dbo->setTaxable( $product_data['taxable'] );
    if( !update_ProductDBO( $product_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_PRODUCT_UPDATE_FAILED" ) );
	$this->goback( 1 );
      }

    // Sucess!
    $this->setMessage( array( "type" => "PRODUCT_UPDATED" ) );
    $this->goback( 2 );
  }
}

?>