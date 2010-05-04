<?php
/**
 * PurchaseDomainPage.class.php
 *
 * This file contains the definition for the PurchaseDomainPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * PurchaseDomainPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PurchaseDomainPage extends SolidStatePage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	public function action( $action_name ) {
		switch ( $action_name ) {
			case "purchasedomain":
				if ( isset( $this->post['continue'] ) ) {
					$this->process();
				}
				elseif ( isset( $this->post['cancel'] ) ) {
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
	public function init() {
		parent::init();

		// Start a new order (if necessary)
		if ( !isset( $_SESSION['order'] ) ) {
			$_SESSION['order'] = new OrderDBO();
		}

		// Give the template access to the order object
		$this->smarty->assign_by_ref( "orderDBO", $_SESSION['order'] );

		// Show prices for the selected domain package
		$termWidget = $this->forms['purchasedomain']->getField( "domainterm" )->getWidget();
		$tldField = $this->forms['purchasedomain']->getField( "domaintld" );
		$dservice = isset( $_POST['domaintld'] ) ?
				$tldField->set( $_POST['domaintld'] ) :
				array_shift( load_array_DomainServiceDBO() );
		$termWidget->setPurchasable( $dservice );

		if ( isset( $this->get['domain'] ) && isset( $this->get['tld'] ) ) {
			$this->smarty->assign( "domain", $this->get['domain'] );
			$this->smarty->assign( "tld", $this->get['tld']->getTLD() );
		}
	}

	/**
	 * Process a new service purchase
	 */
	protected function process() {
		// Verify that the user entered a domain name and TLD
		if ( !isset( $this->post['domainname'] ) ) {
			throw new FieldMissingException( "domainname" );
		}

		// Build an order item for the domain purchase
		$domainItem = new OrderDomainDBO();
		$domainItem->setPurchasable( $this->post['domaintld'] );
		$domainItem->setTerm( $this->post['domainterm']->getTermLength() );
		$domainItem->setDomainName( $this->post['domainname'] );

		$fqdn = sprintf( "%s.%s", $this->post['domainname'], $this->post['domaintld']->getTLD() );

		// Access the registrar module for the selected TLD
		$moduleName = $this->post['domaintld']->getModuleName();
		$registrar = ModuleRegistry::getModuleRegistry()->getModule( $moduleName );

		switch ( $this->post['domainoption'] ) {
			case "New":
				// Register a new domain

				// Check the domain availability
				if ( !$registrar->checkAvailability( $fqdn ) ) {
					throw new SWUserException( "[ERROR_DOMAIN_NOT_AVAILABLE]" );
				}

				$domainItem->setType( "New" );
				break;

			case "Transfer":
				// Transfer a domain

				// Check the domain transfer-ability
				if ( !$registrar->isTransferable( $fqdn ) ) {
					throw new SWUserException( "[ERROR_DOMAIN_TRANSFER_NO_DOMAIN]" );
				}

				$domainItem->setType( "Transfer" );
				break;
		}

		// Add the domain item to the order
		$_SESSION['order']->addItem( $domainItem );

		// Proceed to the cart page
		$this->gotoPage( "cart" );
	}
}
?>