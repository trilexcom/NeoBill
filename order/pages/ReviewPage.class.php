<?php
/**
 * ReviewPage.class.php
 *
 * This file contains the definition for the ReviewPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// Order DBO
require_once $base_path . "DBO/OrderDBO.class.php";

/**
 * ReviewPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ReviewPage extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "review":
	if( isset( $this->session['review']['back'] ) )
	  {
	    $this->goto( "customer" );
	  }
	elseif( isset( $this->session['review']['checkout'] ) )
	  {
	    $this->checkout();
	  }
	elseif( isset( $this->session['review']['startover'] ) )
	  {
	    $this->newOrder();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Check Out
   */
  function checkout()
  {
    dump_session();
    exit();
  }

  /**
   * Initialize Review Page
   */
  function init()
  {
    // Have the remote server calculate taxes on the order
    if( !is_a( $new_order = calculateTaxOnOrderClient( "orders",
						       $this->conf['remote_password'],
						       $_SESSION['order'] ),
	       "OrderDBO" ) )
      {
	fatal_error( "ReviewPage::Init()", 
		     "Remote server did not return an OrderDBO" );
      }
    $_SESSION['order'] = $new_order;

    // Give access to the template
    $this->session['order'] =& $_SESSION['order'];
  }

  /**
   * Start New Order
   */
  function newOrder()
  {
    // Start a new order
    unset( $_SESSION['order'] );
    $this->goto( "cart" );
  }

  /**
   * Populate the Order Table
   */
  function populateOrderTable()
  {
    return $this->session['order']->getItems();
  }
}
