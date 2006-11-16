<?php
/**
 * Enom.class.php
 *
 * This file contains the definition of the Enom class.
 *
 * @package enom
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "modules/RegistrarModule.class.php";

// Enom Interface
require BASE_PATH . "modules/enom/include/EnomInterface.class.php";

/**
 * Enom
 *
 * Provides an interface to the eNom Reseller API
 *
 * @package enom
 * @author John Diamond <jdiamond@solid-state.org>
 */
class Enom extends RegistrarModule
{
  /**
   * @var string Enom API URL
   */
  protected $APIURL = "reseller.enom.com";

  /**
   * @var string Configuration page
   */
  protected $configPage = "em_config";

  /**
   * @var string Long description
   */
  protected $description = "Enom Registrar Module";

  /**
   * @var EnomInterface Enom API Interface object
   */
  protected $enom = null;

  /**
   * @var string Module name
   */
  protected $name = "enom";

  /**
   * @var string Enom API Password
   */
  protected $password = "password";

  /**
   * @var string Short Description
   */
  protected $sDescription = "Enom";

  /**
   * @var string Enom API Username
   */
  protected $username = "username";

  /**
   * @var integer Version
   */
  protected $version = 1;

  /**
   * Check Domain Availability
   *
   * @param string $fqdn Domain name
   * @return boolean True if the domain is available to be registered
   */
  public function checkAvailability( $fqdn )
  {
    $domainParts = explode( ".", $fqdn );

    // Run the enom "Check" command
    $this->enom->NewRequest();
    $this->enom->AddParam( "uid", $this->getUsername() );
    $this->enom->AddParam( "pw", $this->getPassword() );
    $this->enom->AddParam( "sld", $domainParts[0] );
    $this->enom->AddParam( "tld", $domainParts[1] );
    $this->enom->AddParam( "command", "Check" );
    $this->enom->DoTransaction();
    $this->handleAnyErrors();

    return $this->enom->Values['RRPCode'] == "210";
  }

  /**
   * Get Enom API URL
   *
   * @return string Enom API URL
   */
  public function getAPIURL() { return $this->APIURL; }

  /**
   * Get Enom API Password
   *
   * @return string Enom API Password
   */
  public function getPassword() { return $this->password; }

  /**
   * Get Enom API Username
   *
   * @return string Enom API Username
   */
  public function getUsername() { return $this->username; }

  /**
   * Handle Any Enom API Errors
   *
   * Examines EnomInterface->Values for any error codes and if they exist, stuffs
   * them into a RegistrarException
   */
  protected function handleAnyErrors()
  {
    $errCount = intval( $this->enom->Values['ErrCount'] );
    if( $errCount > 0 )
      {
	$message = "[ENOM_THE_FOLLOWING_ERRORS_WERE]: ";
	for( $i = 1; $i <= $errCount; $i++ )
	  {
	    $message .= $this->enom->Values["Err" . $i] . ". ";
	  }

	throw new RegistrarException( $message );
      }
  }

  /**
   * Initialize Enom Module
   *
   * Invoked when the module is loaded.  Call the parent method first, then
   * load settings.
   *
   * @return boolean True for success
   */
  public function init()
  {
    parent::init();

    // Instantiate an EnomInterface to communicate with enom
    $this->enom = new EnomInterface();

    // Load settings
    $this->setAPIURL( $this->moduleDBO->loadSetting( "enom_apiurl" ) );
    $this->setUsername( $this->moduleDBO->loadSetting( "enom_username" ) );
    $this->setPassword( $this->moduleDBO->loadSetting( "enom_password" ) );
  }

  /**
   * Install Enom Module
   *
   * Invoked when the module is installed.  Calls the parent first, which does
   * most of the work, then saves the default settings to the DB.
   */
  public function install()
  {
    parent::install();
    $this->saveSettings();
  }

  /**
   * Verify Domain is Transfer Eligible
   *
   * @param string $fqdn Domain name
   * @return boolean True if the domain is transfer eligible
   */
  public function isTransferable( $fqdn )
  {
    $domainParts = explode( ".", $fqdn );

    // Run the enom "Check" command
    $this->enom->NewRequest();
    $this->enom->AddParam( "uid", $this->getUsername() );
    $this->enom->AddParam( "pw", $this->getPassword() );
    $this->enom->AddParam( "sld", $domainParts[0] );
    $this->enom->AddParam( "tld", $domainParts[1] );
    $this->enom->AddParam( "command", "Check" );
    $this->enom->DoTransaction();
    $this->handleAnyErrors();

    return $this->enom->Values['RRPCode'] == "211";
  }

  /**
   * Register a New Domain
   *
   * @param string $domainName Domain name to be registered (without TLD)
   * @param string $TLD Domain TLD to register
   * @param integer $term Number of years to register the domain for
   * @param array $contacts Admin, billing, and technical contacts
   * @param AccountDBO $accountDBO The account that is registering this domain
   */
  public function registerNewDomain( $domainName, $TLD, $term, $contacts, $accountDBO )
  {
    global $conf;

    // Begin a new enom API request
    $this->enom->NewRequest();

    // Set the loginn information and the domain to register
    $this->enom->AddParam( "uid", $this->getUsername() );
    $this->enom->AddParam( "pw", $this->getPassword() );
    $this->enom->AddParam( "sld", $domainName );
    $this->enom->AddParam( "tld", $TLD );

    // Bypass "unrecognized name server" errors
    $this->enom->AddParam( "IgnoreNSFail", "Yes" );

    // Set the term
    $this->enom->AddParam( "NumYears", $term );

    // Set the name servers
    $i = 1;
    foreach( $conf['dns']['nameservers'] as $nameserver )
      {
	$this->enom->AddParam( "NS" . $i, $nameserver );
	$i++;
      }

    // Set the registrant contact
    $name = explode( " ", $contacts['billing']->getName() );
    $this->enom->AddParam( "RegistrantOrganizationName", $contacts['billing']->getBusinessName() );
    $this->enom->AddParam( "RegistrantFirstName", $name[0] );
    $this->enom->AddParam( "RegistrantLastName", $name[1] );
    $this->enom->AddParam( "RegistrantJobTitle", "n/a" );
    $this->enom->AddParam( "RegistrantAddress1", $contacts['billing']->getAddress1() );
    $this->enom->AddParam( "RegistrantAddress2", $contacts['billing']->getAddress2() );
    $this->enom->AddParam( "RegistrantCity", $contacts['billing']->getCity() );
    $this->enom->AddParam( "RegistrantStateProvince", $contacts['billing']->getState() );
    $this->enom->AddParam( "RegistrantPostalCode", $contacts['billing']->getPostalCode() );
    $this->enom->AddParam( "RegistrantCountry", $contacts['billing']->getCountry() );
    $this->enom->AddParam( "RegistrantEmailAddress", $contacts['billing']->getEmail() );
    $this->enom->AddParam( "RegistrantPhone", $contacts['billing']->getPhone() );
    $this->enom->AddParam( "RegistrantFax", $contacts['billing']->getFax() );

    // Set the technical contact
    $name = explode( " ", $contacts['tech']->getName() );
    $this->enom->AddParam( "TechOrganizationName", $contacts['tech']->getBusinessName() );
    $this->enom->AddParam( "TechFirstName", $name[0] );
    $this->enom->AddParam( "TechLastName", $name[1] );
    $this->enom->AddParam( "TechJobTitle", "n/a" );
    $this->enom->AddParam( "TechAddress1", $contacts['tech']->getAddress1() );
    $this->enom->AddParam( "TechAddress2", $contacts['tech']->getAddress2() );
    $this->enom->AddParam( "TechCity", $contacts['tech']->getCity() );
    $this->enom->AddParam( "TechStateProvince", $contacts['tech']->getState() );
    $this->enom->AddParam( "TechPostalCode", $contacts['tech']->getPostalCode() );
    $this->enom->AddParam( "TechCountry", $contacts['tech']->getCountry() );
    $this->enom->AddParam( "TechEmailAddress", $contacts['tech']->getEmail() );
    $this->enom->AddParam( "TechPhone", $contacts['tech']->getPhone() );
    $this->enom->AddParam( "TechFax", $contacts['tech']->getFax() );

    // Set the billing contact
    $name = explode( " ", $contacts['billing']->getName() );
    $this->enom->AddParam( "AuxBillingOrganizationName", $contacts['billing']->getBusinessName() );
    $this->enom->AddParam( "AuxBillingFirstName", $name[0] );
    $this->enom->AddParam( "AuxBillingLastName", $name[1] );
    $this->enom->AddParam( "AuxBillingJobTitle", "n/a" );
    $this->enom->AddParam( "AuxBillingAddress1", $contacts['billing']->getAddress1() );
    $this->enom->AddParam( "AuxBillingAddress2", $contacts['billing']->getAddress2() );
    $this->enom->AddParam( "AuxBillingCity", $contacts['billing']->getCity() );
    $this->enom->AddParam( "AuxBillingStateProvince", $contacts['billing']->getState() );
    $this->enom->AddParam( "AuxBillingPostalCode", $contacts['billing']->getPostalCode() );
    $this->enom->AddParam( "AuxBillingCountry", $contacts['billing']->getCountry() );
    $this->enom->AddParam( "AuxBillingEmailAddress", $contacts['billing']->getEmail() );
    $this->enom->AddParam( "AuxBillingPhone", $contacts['billing']->getPhone() );
    $this->enom->AddParam( "AuxBillingFax", $contacts['billing']->getFax() );

    // Set the admin contact
    $name = explode( " ", $contacts['admin']->getName() );
    $this->enom->AddParam( "AdminOrganizationName", $contacts['admin']->getBusinessName() );
    $this->enom->AddParam( "AdminFirstName", $name[0] );
    $this->enom->AddParam( "AdminLastName", $name[1] );
    $this->enom->AddParam( "AdminJobTitle", "n/a" );
    $this->enom->AddParam( "AdminAddress1", $contacts['admin']->getAddress1() );
    $this->enom->AddParam( "AdminAddress2", $contacts['admin']->getAddress2() );
    $this->enom->AddParam( "AdminCity", $contacts['admin']->getCity() );
    $this->enom->AddParam( "AdminStateProvince", $contacts['admin']->getState() );
    $this->enom->AddParam( "AdminPostalCode", $contacts['admin']->getPostalCode() );
    $this->enom->AddParam( "AdminCountry", $contacts['admin']->getCountry() );
    $this->enom->AddParam( "AdminEmailAddress", $contacts['admin']->getEmail() );
    $this->enom->AddParam( "AdminPhone", $contacts['admin']->getPhone() );
    $this->enom->AddParam( "AdminFax", $contacts['admin']->getFax() );

    // Run the enom "Purchase" command
    $this->enom->AddParam( "command", "Purchase" );
    $this->enom->DoTransaction();
    $this->handleAnyErrors();
  }

  /**
   * Renew a Domain
   *
   * @param DomainServicePurchaseDBO $purchseDBO The domain to be renewed
   * @param integer $renewTerms Number of years to renew for
   */
  public function renewDomain( $purchaseDBO, $renewTerms )
  {
    // Begin a new enom API request
    $this->enom->NewRequest();

    // Set the login information
    $this->enom->AddParam( "uid", $this->getUsername() );
    $this->enom->AddParam( "pw", $this->getPassword() );

    // Set the number of years to renew for
    $this->enom->AddParam( "NumYears", $renewTerms );

    // Set the domain to be renewed
    $this->enom->AddParam( "tld", $purchaseDBO->getTLD() );
    $this->enom->AddParam( "sld", $purchaseDBO->getDomainName() );

    // Execute the Enom API "Extend" command
    $this->enom->AddParam( "command", "Purchase" );
    $this->enom->DoTransaction();
    $this->handleAnyErrors();
  }

  /**
   * Save Enom Settings
   */
  public function saveSettings()
  {
    $this->moduleDBO->saveSetting( "enom_username", $this->getUsername() );
    $this->moduleDBO->saveSetting( "enom_password", $this->getPassword() );
    $this->moduleDBO->saveSetting( "enom_apiurl", $this->getAPIURL() );
  }

  /**
   * Set Enom API URL
   *
   * @param string $url Enom API URL
   */
  public function setAPIURL( $url ) { $this->APIURL = $url; }

  /**
   * Set Enom API Password
   *
   * @param string $password Enom API Password
   */
  public function setPassword( $password ) { $this->password = $password; }

  /**
   * Set Enom API Username
   *
   * @param string $username Enom API Username
   */
  public function setUsername( $username ) { $this->username = $username; }

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
  public function transferDomain( $domainName, $TLD, $term, $secret, $contacts, $accountDBO )
  {
    // Begin a new enom API request
    $this->enom->NewRequest();

    // Set the login information
    $this->enom->AddParam( "uid", $this->getUsername() );
    $this->enom->AddParam( "pw", $this->getPassword() );

    // Transfering 1 domain
    $this->enom->AddParam( "DomainCount", "1" );
    $this->enom->AddParam( "SLD1", $domainName );
    $this->enom->AddParam( "TLD1", $TLD );

    // Set Order Type to "auto" (as opposed to fax)
    $this->enom->AddParam( "OrderType", "Autoverification" );

    // Supply domain secret if there is one
    if( isset( $secret ) )
      {
	$this->enom->AddParam( "AuthInfo1", $secret );
      }

    // Use existing contact info
    $this->enom->AddParam( "UseContacts", "1" );

    // Execute the Enom API "TP_CreateOrder" command
    $this->enom->AddParam( "command", "TP_CreateOrder" );
    $this->enom->DoTransaction();
    $this->handleAnyErrors();
  }
}
?>