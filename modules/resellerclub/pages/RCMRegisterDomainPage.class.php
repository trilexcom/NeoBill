<?php
/**
 * RCMRegisterDomainPage.class.php
 *
 * This file contains the definition of the RCMRegisterDomainPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// Include DBO's
require_once $base_path . "DBO/AccountDBO.class.php";
require_once $base_path . "DBO/DomainServiceDBO.class.php";
require_once $base_path . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * RCMRegisterDomainPage
 *
 * This Page registers a domain name through the default Registrar module and places
 * an entry into the DomainServicePurchase table.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RCMRegisterDomainPage extends Page
{
  /**
   * @var AccountDBO Account this domain will be registered for
   */
  var $accountDBO = null;

  /**
   * @var DomainServicePurchaseDBO The domain service purchase being built for this registration
   */
  var $purchaseDBO = null;

  /**
   * @var ResellerClub Reseller Club Module
   */
  var $rcModule = null;

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
      case "rcm_register_confirm":
	if( isset( $this->session['rcm_register_confirm']['continue'] ) )
	  {
	    // Execute registration
	    $this->executeRegistration();
	  }
	elseif( isset( $this->session['rcm_register_confirm']['cancel'] ) )
	  {
	    $this->cancel();
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goto( "domains_register" );
  }

  /**
   * Execute Registration
   */
  function executeRegistration()
  {
    // Set the time of purchase
    $this->purchaseDBO->setDate( $this->DB->format_datetime( time() ) );

    // Prepare contact info
    $contacts['admin']['name'] = $this->accountDBO->getContactName();
    $contacts['admin']['company'] = $this->accountDBO->getBusinessName();
    $contacts['admin']['email'] = $this->accountDBO->getContactEmail();
    $contacts['admin']['address1'] = $this->accountDBO->getAddress1();
    $contacts['admin']['address2'] = $this->accountDBO->getAddress2();
    $contacts['admin']['address3'] = "";
    $contacts['admin']['city'] = $this->accountDBO->getCity();
    $contacts['admin']['state'] = $this->accountDBO->getState();
    $contacts['admin']['country'] = $this->accountDBO->getCountry();
    $contacts['admin']['zip'] = $this->accountDBO->getPostalCode();
    $contacts['admin']['phone'] = $this->accountDBO->getPhone();
    $contacts['admin']['fax'] = $this->accountDBO->getFax();
    $contacts['tech'] = $contacts['admin'];
    $contacts['billing'] = $contacts['admin'];

    // Execute the registration at the Registrar
    if( !$this->rcModule->registerNewDomain( $this->purchaseDBO->getDomainName(),
					     $this->purchaseDBO->getTLD(),
					     $this->purchaseDBO->getTermInt(),
					     $contacts,
					     $this->accountDBO ) )
      {
	$this->setError( array( "type" => "DOMAIN_REGISTER_FAILED_REGISTRAR" ) );
	$this->cancel();
      }

    // Store the purchase in database
    if( !add_DomainServicePurchaseDBO( $this->purchaseDBO ) )
      {
	$this->setError( array( "type" => "DOMAIN_REGISTER_FAILED_DB" ) );
	$this->cancel();
      }

    // Registration complete
    $this->setMessage( array( "type" => "DOMAIN_REGISTERED",
			      "args" => array( $this->purchaseDBO->getFullDomainName() ) ) );
    $this->goto( "domains_browse", null, null );
  }

  /**
   * Initialize the Page
   */
  function init()
  {
    if( isset( $_SESSION['dspdbo'] ) )
      {
	// Move the purchase DBO into the local session
	$this->session['dspdbo'] = $_SESSION['dspdbo'];
	unset( $_SESSION['dspdbo'] );
      }

    $this->purchaseDBO =& $this->session['dspdbo'];
    if( !isset( $this->purchaseDBO ) )
      {
	fatal_error( "RCMRegisterDomainPage::init()",
		     "No Domain Service Purchase found!" );
      }

    // Verify that the Reseller Club module is enabled
    $this->rcModule = $this->conf['modules']['resellerclub'];
    $this->rcModule->checkEnabled();

    // Display confirmation
    $this->session['accountdbo'] = 
      load_AccountDBO( $this->purchaseDBO->getAccountID() );
    $this->accountDBO =& $this->session['accountdbo'];
    $this->smarty->assign( "nameservers", $this->conf['dns']['nameservers'] );
  }
}
?>
