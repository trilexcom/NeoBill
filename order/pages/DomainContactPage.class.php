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
require_once $base_path . "solidworks/Page.class.php";

// Order DBO
require_once $base_path . "DBO/OrderDBO.class.php";

/**
 * DomainContactPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainContactPage extends Page
{
  /**
   * @var OrderDomainItem The domain we are collecting contact information for
   */
  var $domainItem;

  /**
   * @var array Array of Order Domain Item's that still need contact info
   */
  var $domainsNeedContact = array();

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
      case "domain_contact":
	if( isset( $this->session['domain_contact']['startover'] ) )
	  {
	    $this->newOrder();
	  }
	elseif( isset( $this->session['domain_contact']['back'] ) )
	  {
	    $this->goto( "customer" );
	  }
	elseif( isset( $this->session['domain_contact']['continue'] ) )
	  {
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
  function done()
  {
    $this->goto( "review" );
  }

  /**
   * Build an array of Domain Items that need contact info
   *
   * @return array Domain items
   */
  function getDomainsNeedingContacts()
  {
    // Build a list of domains that need contact information
    $domains = array();
    foreach( $this->session['order']->getDomainItems() as $domainItem )
      {
	if( !$domainItem->hasContactInformation() )
	  {
	    // Add this domain to the list of those who need contact info
	    $domains[] = $domainItem;
	  }
      }

    return $domains;
  }

  /**
   * Initialize Customer Page
   */
  function init()
  {
    if( !isset( $_SESSION['order'] ) || $_SESSION['order']->isEmpty() )
      {
	// No order, or order is empty.  Go back the the cart and start a new one
	$this->goto( "cart" );
      }

    // Give access to the template
    $this->session['order'] =& $_SESSION['order'];

    if( null == ($domainItems = $this->session['order']->getDomainItems()) )
      {
	// No domains, skip this step
	$this->done();
      }

    $this->domainsNeedContact = $this->getDomainsNeedingContacts();
    if( count( $this->domainsNeedContact ) < 1 )
      {
	// No domains need contact information
	$this->done();
      }

    // We will collect contact information for the item on the top of the list
    $this->domainItem = $this->domainsNeedContact[0];

    $this->smarty->assign( "fqdn", $this->domainItem->getfullDomainName() );
  }

  /**
   * Start New Order
   */
  function newOrder()
  {
    // Start a new order
    unset( $_SESSION['order'] );
    $this->goto( "cart" );
  }

  /**
   * Populate Domains Table
   *
   * @return array Array of OrderDomainDBO's that still need contact info
   */
  function populateDomainTable()
  {
    // Return a list of domain that need contact information, except for the one
    // that is being collected right now.
    $domains = $this->domainsNeedContact;
    array_shift( $domains );
    return $domains;
  }

  /**
   * Process Domain Contact
   */
  function processContact()
  {
    $adminContact =
      array( "bussinessname" => $this->session['domain_contact']['abusinessname'],
	     "contactname" => $this->session['domain_contact']['acontactname'],
	     "contactemail" => $this->session['domain_contact']['acontactemail'],
	     "address1" => $this->session['domain_contact']['aaddress1'],
	     "address2" => $this->session['domain_contact']['aaddress2'],
	     "address3" => $this->session['domain_contact']['aaddress3'],
	     "country" => $this->session['domain_contact']['acountry'],
	     "city" => $this->session['domain_contact']['acity'],
	     "state" => $this->session['domain_contact']['astate'],
	     "postalcode" => $this->session['domain_contact']['apostalcode'],
	     "phone" => $this->session['domain_contact']['aphone'],
	     "fax" => $this->session['domain_contact']['afax'] );

    $billingContact =
      array( "bussinessname" => $this->session['domain_contact']['bbusinessname'],
	     "contactname" => $this->session['domain_contact']['bcontactname'],
	     "contactemail" => $this->session['domain_contact']['bcontactemail'],
	     "address1" => $this->session['domain_contact']['baddress1'],
	     "address2" => $this->session['domain_contact']['baddress2'],
	     "address3" => $this->session['domain_contact']['baddress3'],
	     "country" => $this->session['domain_contact']['bcountry'],
	     "city" => $this->session['domain_contact']['bcity'],
	     "state" => $this->session['domain_contact']['bstate'],
	     "postalcode" => $this->session['domain_contact']['bpostalcode'],
	     "phone" => $this->session['domain_contact']['bphone'],
	     "fax" => $this->session['domain_contact']['bfax'] );

    $techContact =
      array( "bussinessname" => $this->session['domain_contact']['tbusinessname'],
	     "contactname" => $this->session['domain_contact']['tcontactname'],
	     "contactemail" => $this->session['domain_contact']['tcontactemail'],
	     "address1" => $this->session['domain_contact']['taddress1'],
	     "address2" => $this->session['domain_contact']['taddress2'],
	     "address3" => $this->session['domain_contact']['taddress3'],
	     "country" => $this->session['domain_contact']['tcountry'],
	     "city" => $this->session['domain_contact']['tcity'],
	     "state" => $this->session['domain_contact']['tstate'],
	     "postalcode" => $this->session['domain_contact']['tpostalcode'],
	     "phone" => $this->session['domain_contact']['tphone'],
	     "fax" => $this->session['domain_contact']['tfax'] );

    // Copy the form contents into the domain we are collecting for
    $this->session['order']->setDomainContact( $this->domainItem->getOrderItemID(),
					       $adminContact,
					       $billingContact,
					       $techContact );

    // And all the other domains selected from the table
    if( isset( $this->session['domain_contact']['domains'] ) )
      {
	foreach( $this->session['domain_contact']['domains'] as $itemID )
	  {
	    $this->session['order']->setDomainContact( $itemID,
						       $adminContact,
						       $billingContact,
						       $techContact );
	  }
      }

    if( count( $this->getDomainsNeedingContacts() ) < 1 )
      {
	// No more domains to collect contact info for
	$this->done();
      }
  }
}
?>