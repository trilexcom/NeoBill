<?php
/**
 * EditDomainServicePage.class.php
 *
 * This file contains the definition for the EditDomainServicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * EditDomainServicePage
 *
 * Edit a domain registration service offered by the provider.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditDomainServicePage extends SolidStateAdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_domain_service (form)
   *
   * @param string $action_name Action
   */
  public function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_domain_service":
	if( isset( $this->post['save'] ) )
	  {
	    // Save changes
	    $this->update_domain_service();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goback();
	  }
	break;

      case "edit_domain_pricing":
	if( isset( $this->post['delete'] ) )
	  {
	    $this->deletePrice();
	  }
	break;

      case "edit_domain_add_price":
	if( isset( $this->post['add'] ) )
	  {
	    $this->addPrice();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Add Price
   */
  protected function addPrice()
  {
    if( $this->post['type'] == "Onetime" && $this->post['termlength'] != 0 )
      {
	throw new SWUserException( "[TERMLENGTH_FOR_ONETIME_MUST_BE_ZERO]" );
      }
    if( $this->post['type'] == "Recurring" && $this->post['termlength'] == 0 )
      {
	throw new SWUserException( "[TERMLENGTH_FOR_RECURRING_MUST_NOT_BE_ZERO]" );
      }
    $priceDBO = new DomainServicePriceDBO();
    $priceDBO->setTLD( $this->get['dservice']->getTLD() );
    $priceDBO->setType( $this->post['type'] );
    $priceDBO->setTermLength( $this->post['termlength'] );
    $priceDBO->setPrice( $this->post['price'] );
    $priceDBO->setTaxable( $this->post['taxable'] );

    try
      {
	$this->get['dservice']->addPrice( $priceDBO );
	add_DomainServicePriceDBO( $priceDBO );
	$this->setMessage( array( "type" => "[PRICE_ADDED]" ) );
      }
    catch( DuplicatePriceException $e )
      {
	update_DomainServicePriceDBO( $priceDBO );
	$this->setMessage( array( "type" => "[PRICE_UPDATED]" ) );
      }

    $this->reload();
  }

  /**
   * Delete Price
   */
  protected function deletePrice()
  {
    foreach( $this->post['prices'] as $price )
      {
	delete_DomainServicePriceDBO( $price );
      }

    $this->setMessage( array( "type" => "[PRICES_DELETED]" ) );
    $this->reload();
  }

  /**
   * Initialize the Edit Domain Serivce Page
   */
  public function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "dservice", $this->get['dservice']->getTLD() );

    // Store service DBO in session
    $this->session['domain_service_dbo'] =& $this->get['dservice'];

    // Setup the pricing table
    $ptw = $this->forms['edit_domain_pricing']->getField( "prices" )->getWidget();
    $ptw->setPrices( $this->get['dservice']->getPricing() );
  }

  /**
   * Update Domain Service
   *
   * Place the changes made in the form into the DBO and update the database.
   */
  public function update_domain_service()
  {
    // Update DBO
    $this->get['dservice']->setDescription( $this->post['description'] );
    $this->get['dservice']->setModuleName( $this->post['modulename']->getName() );
    $this->get['dservice']->setPublic( isset( $this->post['public'] ) ? "Yes" : "No" );
    update_DomainServiceDBO( $this->get['dservice'] );

    // Sucess!
    $this->setMessage( array( "type" => "[DOMAIN_SERVICE_UPDATED]" ) );
    $this->reload();
  }
}
?>