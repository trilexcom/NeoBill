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
require_once $base_path . "solidworks/Page.class.php";

// ProductDBO class
require_once $base_path . "DBO/ProductDBO.class.php";

/**
 * ProductsPage
 *
 * Display a list of Products being offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductsPage extends Page
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

	if( isset( $this->session['products_action']['add'] ) )
	  {
	    // Goto new user page
	    $this->goto( "services_new_product" );
	  }

	break;

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>
