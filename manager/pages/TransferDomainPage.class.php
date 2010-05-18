<?php
/**
 * TransferDomainPage.class.php
 *
 * This file contains the definition of the TransferDomainPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * TransferDomainPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TransferDomainPage extends SolidStatePage {
	/**
	 * @var AccountDBO Account this domain will be registered for
	 */
	var $accountDBO = null;

	/**
	 * @var DomainServicePurchaseDBO The domain service purchase being built for this registration
	 */
	var $purchaseDBO = null;

	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch ( $action_name ) {
			case "transfer_domain":
				if ( isset( $this->post['continue'] ) ) {
					$this->verifyTransferEligible();
				}
				break;

			case "transfer_domain_service":
				if ( isset( $this->post['continue'] ) ) {
					$this->confirm();
				}
				elseif ( isset( $this->post['cancel'] ) ) {
					$this->cancel();
				}
				break;

			case "transfer_domain_confirm":
				if ( isset( $this->post['continue'] ) ) {
					$this->executeTransfer();
				}
				elseif ( isset( $this->post['cancel'] ) ) {
					$this->cancel();
				}

			default:
				// No matching action - refer to base class
				parent::action( $action_name );
		}
	}

	/**
	 * Cancel the Domain Registration process
	 *
	 * Called whenever a user clicks a "cancel" button.  Returns the user to the
	 * first template.
	 */
	function cancel() {
		$this->gotoPage( "transfer_domain",
				null,
				null );
	}

	/**
	 * Confirm Domain Transfer
	 */
	function confirm() {
		$this->accountDBO = $this->post['account'];

		// Fill in the purchase DBO with the account id and purchase terms
		$this->purchaseDBO->setAccountID( $this->accountDBO->getID() );
		$this->purchaseDBO->setTerm( $this->post['term']->getTermLength() );

		// Provide the template with the name servers
		$this->smarty->assign( "nameservers", $this->conf['dns']['nameservers'] );

		// Display the confirmation template
		$this->setTemplate( "confirm" );
	}

	/**
	 * Execute Domain Transfer
	 */
	function executeTransfer() {
		// Load the registrar module and verify that it is enabled
		$serviceDBO = load_DomainServiceDBO( $this->purchaseDBO->getTLD() );

		$registry = ModuleRegistry::getModuleRegistry();
		$module = $registry->getModule( $serviceDBO->getModuleName() );

		// Set the time of purchase
		$this->purchaseDBO->setDate( DBConnection::format_datetime( time() ) );

		// Prepare contact info
		$contacts['admin'] = new ContactDBO( $this->accountDBO->getContactName(),
				$this->accountDBO->getBusinessName(),
				$this->accountDBO->getContactEmail(),
				$this->accountDBO->getAddress1(),
				$this->accountDBO->getAddress2(),
				null,
				$this->accountDBO->getCity(),
				$this->accountDBO->getState(),
				$this->accountDBO->getPostalCode(),
				$this->accountDBO->getCountry(),
				$this->accountDBO->getPhone(),
				null,
				$this->accountDBO->getFax() );
		$contacts['tech'] = $contacts['admin'];
		$contacts['billing'] = $contacts['admin'];

		// Execute the registration at the Registrar
		$module->transferDomain( $this->purchaseDBO->getDomainName(),
				$this->purchaseDBO->getTLD(),
				intval( $this->purchaseDBO->getTerm() / 12 ),
				$this->purchaseDBO->getSecret(),
				$contacts,
				$this->accountDBO );

		// Store the purchase in database
		add_DomainServicePurchaseDBO( $this->purchaseDBO );

		// Registration complete
		$this->setMessage( array( "type" => "[DOMAIN_TRANSFERED]",
				"args" => array( $this->purchaseDBO->getFullDomainName() ) ) );
		$this->gotoPage( "domains_browse", null, null );
	}

	/**
	 * Initialize the Page
	 *
	 * If an account ID is provided via GET parameters, load the AccountDBO and place
	 * it in the session.
	 */
	function init() {
		parent::init();

		$this->purchaseDBO =& $this->session['dspdbo'];
		$this->accountDBO =& $this->session['accountdbo'];

		if ( isset( $this->purchaseDBO ) ) {
			$widget = $this->forms['transfer_domain_service']->getField( "term" )->getWidget();
			$widget->setPurchasable( $this->purchaseDBO->getPurchasable() );
		}
	}

	/**
	 * Verify the Domain is Eligible to be Transfered
	 */
	function verifyTransferEligible() {
		$registry = ModuleRegistry::getModuleRegistry();
		$module = $registry->getModule( $this->post['servicetld']->getModuleName() );

		$fqdn = sprintf( "%s.%s",
				$this->post['domainname'],
				$this->post['servicetld']->getTLD() );
		if ( !$module->isTransferable( $fqdn ) ) {
			// Domain is not eligible for transfer
			throw new SWUserException( "[DOMAIN_NOT_TRANSFERABLE]" );
		}

		// Domain can be transfered
		$this->purchaseDBO = new DomainServicePurchaseDBO();
		$this->purchaseDBO->setPurchasable( $this->post['servicetld'] );
		$this->purchaseDBO->setDomainName( $this->post['domainname'] );
		$this->purchaseDBO->setSecret( $this->post['secret'] );
		$this->setMessage( array( "type" => "[DOMAIN_IS_ELIGIBLE]",
				"args" => array( $fqdn ) ) );
		$this->setTemplate( "transfer" );
	}
}
?>