<?
/**
 * EditProductPurchasePage.class.php
 *
 * This file contains the definition for the EditProductPurchasePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * EditProductPurchasePage
 *
 * Edit a product purchase
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditProductPurchasePage extends SolidStatePage
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
      case "edit_product_purchase":
	if( isset( $this->post['save'] ) )
	  {
	    $this->save();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->goback();
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Initialize the Page
   */
  public function init()
  {
    parent::init();

    // Setup the pricing/term menu
    $widget = $this->forms['edit_product_purchase']->getField( "term" )->getWidget();
    $widget->setPurchasable( $this->get['ppurchase']->getPurchasable() );

    // Give the template access to the purchase DBO
    $this->smarty->assign_by_ref( "purchaseDBO", $this->get['ppurchase'] );

    // Set URL Fields
    $this->setURLField( "ppurchase", $this->get['ppurchase']->getID() );
  }

  /**
   * Save Product Purchase
   */
  public function save()
  {
    $nextBillingDate = DBConnection::format_date( $this->post['nextbillingdate'] );
    $this->get['ppurchase']->setTerm( $this->post['term']->getTermLength() );
    $this->get['ppurchase']->setNextBillingDate( $nextBillingDate );
    $this->get['ppurchase']->setNote( $this->post['note'] );

    update_ProductPurchaseDBO( $this->get['ppurchase'] );

    // Success
    $this->setMessage( array( "type" => "[CHANGES_SAVED]" ) );
    $this->reload();
  }
}
?>