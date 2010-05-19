<?php
/**
 * RegistrarModule.class.php
 *
 * This file contains the definition of the RegistrarModule class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "modules/SolidStateModule.class.php";

// Exceptions
class RegistrarException extends SWUserException {
	public function __construct( $message ) {
		$this->message = "[REGISTRAR_TRANSACTION_FAILED]. " . $message;
	}
}

/**
 * RegistrarModule
 *
 * Provides a base class for modules of domain_registrar type.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class RegistrarModule extends SolidStateModule {
	/**
	 * @var string This is the name of the page that is called when the user wants to register a new page from the Manager.  It must be provided by the module programmer.
	 */
	protected $managerRegisterDomainPage = null;

	/**
	 * @var string Module type is registrar
	 */
	protected $type = "registrar";

	/**
	 * Check Domain Availability
	 *
	 * @param string $fqdn Domain name
	 * @return boolean True if the domain is available to be registered
	 */
	public function checkAvailability( $fqdn ) {
		throw new ModuleOperationNotSupported( "checkAvailability" );
	}

	/**
	 * Verify Domain is Transfer Eligible
	 *
	 * @param string $fqdn Domain name
	 * @return boolean True if the domain is transfer eligible
	 */
	public function isTransferable( $fqdn ) {
		throw new ModuleOperationNotSupported( "isTransferable" );
	}

	/**
	 * Register a New Domain
	 *
	 * @param string $domainName Domain name to be registered (without TLD)
	 * @param string $TLD Domain TLD to register
	 * @param integer $term Number of years to register the domain for
	 * @param array $contacts Admin, billing, and technical contacts
	 * @param AccountDBO $accountDBO The account that is registering this domain
	 * @return boolean True for success
	 */
	public function registerNewDomain( $domainName, $TLD, $term, $contacts, $accountDBO ) {
		throw new ModuleOperationNotSupported( "registerNewDomain" );
	}

	/**
	 * Renew a Domain
	 *
	 * @param DomainServicePurchaseDBO $purchseDBO The domain to be renewed
	 * @param integer $renewTerms Number of years to renew for
	 * @return boolean True for success
	 */
	public function renewDomain( $purchaseDBO, $renewTerms ) {
		throw new ModuleOperationNotSupported( "renewDomain" );
	}

	/**
	 * Transfer a Domain
	 *
	 * @param string $domainName Domain name to be transferred (without TLD)
	 * @param string $TLD Domain TLD
	 * @param integer $term Number of years to renew domain for
	 * @param string $secret The domain secret
	 * @param array $contacts Admin, billing, and technical contacts
	 * @param AccountDBO $accountDBO The account that is transferring this domain
	 * @return boolean True for success
	 */
	public function transferDomain( $domainName, $TLD, $term, $secret, $contacts, $accountDBO ) {
		throw new ModuleOperationNotSupported( "transferDomain" );
	}
}
?>