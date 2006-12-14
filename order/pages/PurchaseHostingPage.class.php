<?php
/**
 * PurchaseHostingPage.class.php
 *
 * This file contains the definition for the PurchaseHostingPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * PurchaseHostingPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PurchaseHostingPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *
   * @param string $action_name Action
   */
  public function action( $action_name )
  {
    switch( $action_name )
      {
      case "purchasehosting":
	if( isset( $this->post['continue'] ) )
	  {
	    $this->process();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->goback();
	  }
	break;

      default:
	parent::action( $action_name );
	break;
      }
  }

  /**
   * Initialize the Page
   */
  public function init()
  {
    parent::init();

    if( null == ($services = load_array_HostingServiceDBO()) )
      {
	throw new SWException( "No hosting services have been setup" );
      }

    // Start a new order (if necessary)
    if( !isset( $_SESSION['order'] ) )
      {
	$_SESSION['order'] = new OrderDBO();
      }

    // Give the template access to the order object
    $this->smarty->assign_by_ref( "orderDBO", $_SESSION['order'] );

    // Show prices for the selected hosting package
    $termWidget = $this->forms['purchasehosting']->getField( "hostingterm" )->getWidget();
    $serviceField = $this->forms['purchasehosting']->getField( "hostingservice" );
    $hservice = isset( $_POST['hostingservice'] ) ?
      $serviceField->set( $_POST['hostingservice'] ) :
      array_shift( load_array_HostingServiceDBO() );
    $termWidget->setPurchasable( $hservice );

    // Give the template access to the hosting service DBO
    $this->smarty->assign_by_ref( "serviceDBO", $hservice );

    // Show prices for the selected domain package
    $termWidget = $this->forms['purchasehosting']->getField( "registerdomainterm" )->getWidget();
    $tldField = $this->forms['purchasehosting']->getField( "registerdomaintld" );
    $dservice = isset( $_POST['registerdomaintld'] ) ?
      $tldField->set( $_POST['registerdomaintld'] ) :
      array_shift( load_array_DomainServiceDBO() );
    $termWidget->setPurchasable( $dservice );

    $termWidget = $this->forms['purchasehosting']->getField( "transferdomainterm" )->getWidget();
    $tldField = $this->forms['purchasehosting']->getField( "transferdomaintld" );
    $dservice = isset( $_POST['transferdomaintld'] ) ?
      $tldField->set( $_POST['transferdomaintld'] ) :
      array_shift( load_array_DomainServiceDBO() );
    $termWidget->setPurchasable( $dservice );

    // Setup the in-cart domains drop-down
    $widget = $this->forms['purchasehosting']->getField( "incartdomain" )->getWidget();
    $widget->setOrder( $_SESSION['order'] );
  }

  /**
   * Process a new service purchase
   */
  protected function process()
  {
    // Build an order item for the hosting service
    $hostingItem = new OrderHostingDBO();
    $hostingItem->setPurchasable( $this->post['hostingservice'] );
    $hostingItem->setTerm( $this->post['hostingterm']->getTermLength() );

    switch( $this->post['domainoption'] )
      {
      case "New":
	// Register a new domain for use with this hosting service

	// Verify that the user entered a domain name and TLD
	if( !isset( $this->post['registerdomainname'] ) )
	  {
	    throw new FieldMissingException( "registerdomainname" );
	  }
	if( !isset( $this->post['registerdomaintld'] ) )
	  {
	    throw new FieldMissingException( "registerdomaintld" );
	  }

	$fqdn = sprintf( "%s.%s", 
			 $this->post['registerdomainname'], 
			 $this->post['registerdomaintld']->getTLD() );

	// Check the domain availability
	$moduleName = $this->post['registerdomaintld']->getModuleName();
	$registrar = ModuleRegistry::getModuleRegistry()->getModule( $moduleName );
	if( !$registrar->checkAvailability( $fqdn ) )
	  {
	    throw new SWUserException( "[ERROR_DOMAIN_NOT_AVAILABLE]" );
	  }

	// Place the domain name in the hosting item
	$hostingItem->setDomainName( $fqdn );

	// Create another order item for the domain purchase
	$domainItem = new OrderDomainDBO();
	$domainItem->setType( "New" );
	$domainItem->setDomainName( $this->post['registerdomainname'] );
	$domainItem->setPurchasable( $this->post['registerdomaintld'] );
	$domainItem->setTerm( $this->post['registerdomainterm']->getTermLength() );
	break;

      case "Transfer":
	// Transfer a domain for use with this hosting service

	// Verify that the user entered a domain name and TLD
	if( !isset( $this->post['transferdomainname'] ) )
	  {
	    throw new FieldMissingException( "transferdomainname" );
	  }
	if( !isset( $this->post['transferdomaintld'] ) )
	  {
	    throw new FieldMissingException( "transferdomaintld" );
	  }

	$fqdn = sprintf( "%s.%s", 
			 $this->post['transferdomainname'], 
			 $this->post['transferdomaintld']->getTLD() );

	// Check the domain transfer-ability
	$moduleName = $this->post['registerdomaintld']->getModuleName();
	$registrar = ModuleRegistry::getModuleRegistry()->getModule( $moduleName );
	if( !$registrar->isTransferable( $fqdn ) )
	  {
	    throw new SWUserException( "[ERROR_DOMAIN_TRANSFER_NO_DOMAIN]" );
	  }

	// Place the domain name in the hosting item
	$hostingItem->setDomainName( $fqdn );

	// Create another order item for the domain purchase
	$domainItem = new OrderDomainDBO();
	$domainItem->setType( "Transfer" );
	$domainItem->setDomainName( $this->post['transferdomainname'] );
	$domainItem->setPurchasable( $this->post['transferdomaintld'] );
	$domainItem->setTerm( $this->post['transferdomainterm']->getTermLength() );
	break;

      case "InCart":
	// Use a domain that is in the customer's cart

	// Verify that the user selected a domain
	if( !isset( $this->post['incartdomain'] ) )
	  {
	    throw new FieldMissingException( "incartdomain" );
	  }

	$hostingItem->setDomainName( $this->post['incartdomain'] );
	break;

      case "Existing":
	// Use an existing domain for this hosting service

	// Verify that the user entered a domain name
	if( !isset( $this->post['existingdomainname'] ) )
	  {
	    throw new FieldMissingException( "existingdomainname" );
	  }

	$hostingItem->setDomainName( $this->post['existingdomainname'] );
	break;

      default:
	if( $this->post['hostingservice']->isDomainRequired() )
	  {
	    throw new FieldMissingException( "domainoption" );
	  }
	break;
      }

    // Add the item(s) to the order
    $_SESSION['order']->addItem( $hostingItem );
    if( isset( $domainItem ) )
      {
	$_SESSION['order']->addItem( $domainItem );
      }

    // Proceed to the cart page
    $this->goto( "cart" );
  }
}
?>