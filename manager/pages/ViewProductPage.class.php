<?php
/**
 * ViewProductPage.class.php
 *
 * This file contains the definition for the ViewProductPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

/**
 * ViewProductPage
 *
 * Display a product offering
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewProductPage extends Page
{
  /**
   * Initialize View Product Page
   *
   * If the Product ID is provided in the query string, use it to load the ProductDBO
   * from the database, then store the DBO in the session.  Otherwise, use the DBO
   * already there.
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
	// Could not find Domain Service
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
   *   view_product_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      case "view_product_action":

	if( isset( $this->session['view_product_action']['edit'] ) )
	  {
	    // Edit this Domain Service
	    $this->goto( "services_edit_product",
			 null,
			 "id=" . $this->session['product_dbo']->getID() );
	  }
	elseif( isset( $this->session['view_product_action']['delete'] ) )
	  {
	    // Delete this Product
	    $this->goto( "services_delete_product",
			 null,
			 "id=" . $this->session['product_dbo']->getID() );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>
