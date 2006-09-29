<?php
/**
 * CustomerPage.class.php
 *
 * This file contains the definition for the CustomerPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

// Order DBO
require_once BASE_PATH . "DBO/OrderDBO.class.php";

// User DBO
require_once BASE_PATH . "DBO/UserDBO.class.php";

/**
 * CustomerPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CustomerPage extends Page
{
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
      case "customer_information":
	if( isset( $this->session['customer_information']['back'] ) )
	  {
	    $this->goto( "cart" );
	  }
	elseif( isset( $this->session['customer_information']['continue'] ) )
	  {
	    $this->process();
	  }
	elseif( isset( $this->session['customer_information']['startover'] ) )
	  {
	    $this->newOrder();
	  }
	break;

      case "repeat_customer":
	if( isset( $this->session['repeat_customer']['back'] ) )
	  {
	    $this->goto( "cart" );
	  }
	elseif( isset( $this->session['repeat_customer']['continue'] ) )
	  {
	    $this->process();
	  }
	elseif( isset( $this->session['repeat_customer']['startover'] ) )
	  {
	    $this->newOrder();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
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

    // Indicate to the template wether or not the order contains any domain items
    $this->smarty->assign( "orderHasDomains",
			   $this->session['order']->getDomainItems() != null );
       
    if( isset( $_SESSION['client']['userdbo'] ) )
      {
	// Use the account information already on file
	$userDBO = $_SESSION['client']['userdbo'];
	if( null == ($accountDBO = load_AccountDBO( $userDBO->getAccountID() )) )
	  {
	    fatal_error( "CustomerPage::init()",
			 "User account not found, account id = " . 
			 $userDBO->getAccountID() );
	  }

	$this->session['order']->setAccountID( $accountDBO->getID() );
	$this->session['order']->setBusinessName( $accountDBO->getBusinessName() );
	$this->session['order']->setContactname( $accountDBO->getContactName() );
	$this->session['order']->setContactEmail( $accountDBO->getContactEmail() );
	$this->session['order']->setAddress1( $accountDBO->getAddress1() );
	$this->session['order']->setAddress2( $accountDBO->getAddress2() );
	$this->session['order']->setCity( $accountDBO->getCity() );
	$this->session['order']->setState( $accountDBO->getState() );
	$this->session['order']->setCountry( $accountDBO->getCountry() );
	$this->session['order']->setPostalCode( $accountDBO->getPostalCode() );
	$this->session['order']->setPhone( $accountDBO->getPhone() );
	$this->session['order']->setMobilePhone( $accountDBO->getMobilePhone() );
	$this->session['order']->setFax( $accountDBO->getFax() );
	$this->session['order']->setUsername( $userDBO->getUsername() );

	if( $this->session['order']->getDomainItems() == null )
	  {
	    $this->process();
	  }

	$this->setTemplate( "repeatcustomer" );
      }
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
   * Process the Customer Information Form
   */
  function process()
  {
    if( $this->session['order']->getAccountID() == null )
      {
	// Verify password
	if( $this->session['customer_information']['password'] !=
	    $this->session['customer_information']['repassword'] )
	  {
	    $this->setError( array( "type" => "PASSWORD_MISMATCH" ) );
	    return;
	  }

	// Verify e-mail
	if( $this->session['customer_information']['contactemail'] !=
	    $this->session['customer_information']['verifyemail'] )
	  {
	    $this->setError( array( "type" => "EMAIL_MISMATCH" ) );
	    return;
	  }

	// Check for a duplicate username
	if( load_UserDBO( $this->session['customer_information']['username'] ) )
	  {
	    $this->setError( array( "type" => "USERNAME_EXISTS",
				    "args" => array( $this->session['customer_information']['username'] ) ) );
	    return;
	  }

	// Stuff the contact info into the order
	$ci = $this->session['customer_information'];
	$this->session['order']->setBusinessName( $ci['businessname'] );
	$this->session['order']->setContactname( $ci['contactname'] );
	$this->session['order']->setContactEmail( $ci['contactemail'] );
	$this->session['order']->setAddress1( $ci['address1'] );
	$this->session['order']->setAddress2( $ci['address2'] );
	$this->session['order']->setCity( $ci['city'] );
	$this->session['order']->setState( $ci['state'] );
	$this->session['order']->setCountry( $ci['country'] );
	$this->session['order']->setPostalCode( $ci['postalcode'] );
	$this->session['order']->setPhone( $ci['phone'] );
	$this->session['order']->setMobilePhone( $ci['mobilephone'] );
	$this->session['order']->setFax( $ci['fax'] );
	$this->session['order']->setUsername( $ci['username'] );
	$this->session['order']->setPassword( $ci['password'] );
      }

    if( null != ($domainItems = $this->session['order']->getDomainItems()) && 
	($this->session['customer_information']['domaincontact'] == "same" ||
	 $this->session['repeat_customer']['domaincontact'] == "same") )
      {
	// Contact information for all domains is the same as customer's contact info
	$contactDBO = new ContactDBO( $this->session['order']->getContactName(),
				      $this->session['order']->getBusinessName(),
				      $this->session['order']->getContactEmail(),
				      $this->session['order']->getAddress1(),
				      $this->session['order']->getAddress2(),
				      null,
				      $this->session['order']->getCity(),
				      $this->session['order']->getState(),
				      $this->session['order']->getPostalCode(),
				      $this->session['order']->getCountry(),
				      $this->session['order']->getPhone(),
				      $this->session['order']->getMobilePhone(),
				      $this->session['order']->getFax() );
	foreach( $domainItems as $domainItem )
	  {
	    $this->session['order']->setDomainContact( $domainItem->getOrderItemID(),
						       $contactDBO,
						       $contactDBO,
						       $contactDBO );
	  }
      }

    $this->goto( "domaincontact" );
  }
}
?>