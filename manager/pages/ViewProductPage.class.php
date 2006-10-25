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
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "DBO/ProductDBO.class.php";

/**
 * ViewProductPage
 *
 * Display a product offering
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewProductPage extends SolidStatePage
{
  /**
   * Initialize View Product Page
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
   *   view_product_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "view_product_action":
	if( isset( $this->post['edit'] ) )
	  {
	    // Edit this Domain Service
	    $this->goto( "services_edit_product",
			 null,
			 "product=" . $this->get['product']->getID() );
	  }
	elseif( isset( $this->post['delete'] ) )
	  {
	    // Delete this Product
	    $this->goto( "services_delete_product",
			 null,
			 "product=" . $this->get['product']->getID() );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}

?>