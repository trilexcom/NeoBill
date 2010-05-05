<?php
/**
 * DomainContactPage.class.php
 *
 * This file contains the definition for the DomainContactPage class
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
 * DomainContactPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainContactPage extends SolidStatePage {
	/**
	 * @var array Array of Order Domain Item's that still need contact info
	 */
	protected $domainsNeedContact = array();

	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch ( $action_name ) {
			case "domain_contact":
				if ( isset( $this->session['domain_contact']['startover'] ) ) {
					$this->newOrder();
				}
				elseif ( isset( $this->session['domain_contact']['back'] ) ) {
					$this->gotoPage( "customer" );
				}
				elseif ( isset( $this->session['domain_contact']['continue'] ) ) {
					$this->processContact();
				}
				break;

			default:
				// No matching action, refer to base class
				parent::action( $action_name );
		}
	}

	/**
	 * Done Processing Domains
	 */
	function done() {
		$this->gotoPage( "review" );
	}

	/**
	 * Build an array of Domain Items that need contact info
	 *
	 * @return array Domain items
	 */
	function getDomainsNeedingContacts() {
		// Build a list of domains that need contact information
		$domains = array();
		foreach ( $this->session['order']->getDomainItems() as $domainItem ) {
			if ( !$domainItem->hasContactInformation() ) {
				// Add this domain to the list of those who need contact info
				$domains[] = $domainItem;
			}
		}

		return $domains;
	}

	/**
	 * Initialize Customer Page
	 */
	function init() {
		if ( !isset( $_SESSION['order'] ) || $_SESSION['order']->isEmpty() ) {
			// No order, or order is empty.  Go back the the cart and start a new one
			$this->gotoPage( "cart" );
		}

		// Give access to the template
		$this->session['order'] =& $_SESSION['order'];

		$domainItems = $this->session['order']->getDomainItems();
		if ( empty( $domainItems ) ) {
			// No domains, skip this step
			$this->done();
		}

		$this->domainsNeedContact = $this->getDomainsNeedingContacts();
		if ( count( $this->domainsNeedContact ) < 1 ) {
			// No domains need contact information
			$this->done();
		}

		// Setup the domain table
		$dtField = $this->forms['domain_contact']->getField( "domains" );
		$dtField->getWidget()->setOrder( $_SESSION['order'] );
		$dtField->getValidator()->setOrder( $_SESSION['order'] );
	}

	/**
	 * Start New Order
	 */
	function newOrder() {
		// Start a new order
		unset( $_SESSION['order'] );
		$this->gotoPage( "cart" );
	}

	/**
	 * Process Domain Contact
	 */
	function processContact() {
		$adminContactDBO =
				new ContactDBO( $this->session['domain_contact']['acontactname'],
				$this->session['domain_contact']['abusinessname'],
				$this->session['domain_contact']['acontactemail'],
				$this->session['domain_contact']['aaddress1'],
				$this->session['domain_contact']['aaddress2'],
				$this->session['domain_contact']['aaddress3'],
				$this->session['domain_contact']['acity'],
				$this->session['domain_contact']['astate'],
				$this->session['domain_contact']['apostalcode'],
				$this->session['domain_contact']['acountry'],
				$this->session['domain_contact']['aphone'],
				null,
				$this->session['domain_contact']['afax'] );
		$billingContactDBO =
				new ContactDBO( $this->session['domain_contact']['bcontactname'],
				$this->session['domain_contact']['bbusinessname'],
				$this->session['domain_contact']['bcontactemail'],
				$this->session['domain_contact']['baddress1'],
				$this->session['domain_contact']['baddress2'],
				$this->session['domain_contact']['baddress3'],
				$this->session['domain_contact']['bcity'],
				$this->session['domain_contact']['bstate'],
				$this->session['domain_contact']['bpostalcode'],
				$this->session['domain_contact']['bcountry'],
				$this->session['domain_contact']['bphone'],
				null,
				$this->session['domain_contact']['bfax'] );
		$techContactDBO =
				new ContactDBO( $this->session['domain_contact']['tcontactname'],
				$this->session['domain_contact']['tbusinessname'],
				$this->session['domain_contact']['tcontactemail'],
				$this->session['domain_contact']['taddress1'],
				$this->session['domain_contact']['taddress2'],
				$this->session['domain_contact']['taddress3'],
				$this->session['domain_contact']['tcity'],
				$this->session['domain_contact']['tstate'],
				$this->session['domain_contact']['tpostalcode'],
				$this->session['domain_contact']['tcountry'],
				$this->session['domain_contact']['tphone'],
				null,
				$this->session['domain_contact']['tfax'] );

		// Copy the form contents into the domain we are collecting for
		if ( isset( $this->session['domain_contact']['domains'] ) ) {
			foreach( $this->session['domain_contact']['domains'] as $item ) {
				$this->session['order']->setDomainContact( $item->getOrderItemID(),
						$adminContactDBO,
						$billingContactDBO,
						$techContactDBO );
			}
		}

		if ( count( $this->getDomainsNeedingContacts() ) < 1 ) {
			// No more domains to collect contact info for
			$this->done();
		}
	}
}
?>