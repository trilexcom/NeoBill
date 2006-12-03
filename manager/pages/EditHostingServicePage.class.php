<?php
/**
 * EditHostingServicePage.class.php
 *
 * This file contains the definition for the Edit Hosting Service Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * EditHostingServicePage
 *
 * Edit a hosting service offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditHostingServicePage extends SolidStateAdminPage
{
  /**
   * Initialize the Edit Hosting Service Page
   */
  public function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "hservice", $this->get['hservice']->getID() );

    // Store service DBO in session
    $this->session['hosting_dbo'] =& $this->get['hservice'];

    // Setup the pricing table
    $ptw = $this->forms['edit_hosting_pricing']->getField( "prices" )->getWidget();
    $ptw->setPrices( $this->get['hservice']->getPricing() );
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_hosting (form)
   *
   * @param string $action_name Action
   */
  public function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_hosting":
	if( isset( $this->post['save'] ) )
	  {
	    // Save changes
	    $this->update_hosting_service();
	    $this->goback();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goback();
	  }
	break;

      case "edit_hosting_pricing":
	if( isset( $this->post['delete'] ) )
	  {
	    $this->deletePrice();
	  }

      case "edit_hosting_add_price":
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
    $priceDBO = new HostingServicePriceDBO();
    $priceDBO->setServiceID( $this->get['hservice']->getID() );
    $priceDBO->setType( $this->post['type'] );
    $priceDBO->setTermLength( $this->post['termlength'] );
    $priceDBO->setPrice( $this->post['price'] );
    $priceDBO->setTaxable( $this->post['taxable'] );

    try
      {
	$this->get['hservice']->addPrice( $priceDBO );
	if( !add_HostingServicePriceDBO( $priceDBO ) )
	  {
	    throw new SWException( "Failed to add price to database: " . 
				   mysql_error() );
	  }
	$this->setMessage( array( "type" => "[PRICE_ADDED]" ) );
      }
    catch( DuplicatePriceException $e )
      {
	update_HostingServicePriceDBO( $priceDBO );
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
	delete_HostingServicePriceDBO( $price );
      }

    $this->setMessage( array( "type" => "[PRICES_DELETED]" ) );
    $this->reload();
  }

  /**
   * Update Hosting Service
   *
   * Place the changes from the form into the HostingServiceDBO and update the database.
   */
  protected function update_hosting_service()
  {
    // Update DBO
    $this->get['hservice']->setTitle( $this->post['title'] );
    $this->get['hservice']->setDescription( $this->post['description'] );
    $this->get['hservice']->setUniqueIP( $this->post['uniqueip'] );
    $this->get['hservice']->setDomainRequirement( $this->post['domainrequirement'] );
    if( !update_HostingServiceDBO( $this->get['hservice'] ) )
      {
	// Error
	throw new SWException( "Could not update hosting service!" );
      }
  }
}

?>