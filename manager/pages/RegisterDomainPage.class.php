<?php
/**
 * RegisterDomainPage.class.php
 *
 * This file contains the definition of the RegisterDomainPage class.
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
 * RegisterDomainPage
 *
 * This Page registers a domain name through the default Registrar module and places
 * an entry into the DomainServicePurchase table.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RegisterDomainPage extends Page
{
  /**
   * Initialize the Page
   *
   * If an account ID is provided via GET parameters, load the AccountDBO and place
   * it in the session.
   */
  function init()
  {
    $id = $_GET['id'];

    if( isset( $id ) )
      {
	// Retrieve the Account from the database
	$dbo = load_AccountDBO( intval( $id ) );
      }
    else
      {
	// Retrieve DBO from session
	$dbo = $this->session['account_dbo'];
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   register_domain (form)
   *   register_domain_service (form)
   *   register_domain_customer_select (form)
   *   register_domain_customer_new (form)
   *   register_domain_confirm (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "register_domain":
	if( isset( $this->session['register_domain']['continue'] ) )
	  {
	    $this->checkAvailability();
	  }
	break;

      case "register_domain_service":
	if( isset( $this->session['register_domain_service']['continue'] ) )
	  {
	    // Proceed to register the domains selected
	    $this->registerDomain();
	  }
	elseif( isset( $this->session['register_domain_service']['cancel'] ) )
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
   * Cancel the Domain Registration process
   *
   * Called whenever a user clicks a "cancel" button.  Returns the user to the
   * first template.
   */
  function cancel()
  {
    $this->goto( "domains_register",
		 null,
		 null );
  }

  /**
   * Check Domain's Availability
   */
  function checkAvailability()
  {
    $serviceDBO = 
      load_DomainServiceDBO( $this->session['register_domain']['servicetld'] );
    $module = $this->conf['modules'][$serviceDBO->getModuleName()];

    $fqdn = sprintf( "%s.%s",
		     $this->session['register_domain']['domainname'],
		     $this->session['register_domain']['servicetld'] );
    if( !$module->checkAvailability( $fqdn ) )
      {
	// Domain is NOT available
	$this->setError( array( "type" => "DOMAIN_NOT_AVAILABLE",
				"args" => array( $fqdn ) ) );
	$this->goback( 1 );
      }

    // Domain is avaialble
    $this->session['dspdbo'] = new DomainServicePurchaseDBO();
    $this->session['dspdbo']->setTLD( $this->session['register_domain']['servicetld'] );
    $this->session['dspdbo']->setDomainName( $this->session['register_domain']['domainname'] );
    $this->setMessage( array( "type" => "DOMAIN_IS_AVAILABLE",
			      "args" => array( $fqdn ) ) );
    $this->setTemplate( "whois_results" );
  }

  /**
   * Populate the Registration Term drop-down menu
   *
   * @return array Term => Description + price
   */
  function populateTermField()
  {
    global $cs;

    $cs = $this->conf['locale']['currency_symbol'];
    $dsDBO = load_DomainServiceDBO( $this->session['dspdbo']->getTLD() );
    $return['1 year'] = "[1_YEAR] - " . $cs . $dsDBO->getPrice1yr();
    $return['2 year'] = "[2_YEARS] - " . $cs . $dsDBO->getPrice2yr();
    $return['3 year'] = "[3_YEARS] - " . $cs . $dsDBO->getPrice3yr();
    $return['4 year'] = "[4_YEARS] - " . $cs . $dsDBO->getPrice4yr();
    $return['5 year'] = "[5_YEARS] - " . $cs . $dsDBO->getPrice5yr();
    $return['6 year'] = "[6_YEARS] - " . $cs . $dsDBO->getPrice6yr();
    $return['7 year'] = "[7_YEARS] - " . $cs . $dsDBO->getPrice7yr();
    $return['8 year'] = "[8_YEARS] - " . $cs . $dsDBO->getPrice8yr();
    $return['9 year'] = "[9_YEARS] - " . $cs . $dsDBO->getPrice9yr();
    $return['10 year'] = "[10_YEARS] - " . $cs . $dsDBO->getPrice10yr();
    return $return;
  }

  /**
   * Register Domain
   */
  function registerDomain()
  {
    $this->session['dspdbo']->setAccountID( $this->session['register_domain_service']['accountid'] );
    $this->session['dspdbo']->setTerm( $this->session['register_domain_service']['term'] );

    // Pass the Domain Service Purchase to the Registrar module
    $_SESSION['dspdbo'] = $this->session['dspdbo'];

    // Hand off to the Registrar module
    $moduleName = $_SESSION['dspdbo']->getModuleName(); 
    $this->goto( $this->conf['modules'][$moduleName]->getManagerRegisterDomainPage() );
  }

}

?>