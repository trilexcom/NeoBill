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

/**
 * RegistrarModule
 *
 * Provides a base class for modules of domain_registrar type.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class RegistrarModule extends SolidStateModule
{
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
  abstract public function checkAvailability( $fqdn );

  /**
   * Verify Domain is Transfer Eligible
   *
   * @param string $fqdn Domain name
   * @return boolean True if the domain is transfer eligible
   */
  abstract public function isTransferable( $fqdn );

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
  abstract public function registerNewDomain( $domainName, $TLD, $term, $contacts, $accountDBO );

  /**
   * Renew a Domain
   *
   * @param DomainServicePurchaseDBO $purchseDBO The domain to be renewed
   * @param integer $renewTerms Number of years to renew for
   * @return boolean True for success
   */
  abstract public function renewDomain( $purchaseDBO, $renewTerms );

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
  abstract public function transferDomain( $domainName, $TLD, $term, $secret, $contacts, $accountDBO );
}
?>