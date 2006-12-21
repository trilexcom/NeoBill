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
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * CustomerPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CustomerPage extends SolidStatePage
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
	if( isset( $this->post['back'] ) )
	  {
	    $this->goto( "cart" );
	  }
	elseif( isset( $this->post['continue'] ) )
	  {
	    $this->process();
	  }
	elseif( isset( $this->post['startover'] ) )
	  {
	    $this->newOrder();
	  }
	break;

      case "repeat_customer":
	if( isset( $this->post['back'] ) )
	  {
	    $this->goto( "cart" );
	  }
	elseif( isset( $this->post['continue'] ) )
	  {
	    $this->process();
	  }
	elseif( isset( $this->post['startover'] ) )
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
    $domainItems = $this->session['order']->getDomainItems();
    $this->smarty->assign( "orderHasDomains", !empty( $domainItems ) );
       
    if( isset( $_SESSION['client']['userdbo'] ) )
      {
	// Use the account information already on file
	$userDBO = $_SESSION['client']['userdbo'];
	$accountDBO = load_AccountDBO( $userDBO->getAccountID() );

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

	$domainItems = $this->session['order']->getDomainItems();
	if( empty( $domainItems ) )
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
	if( $this->post['password'] != $this->post['repassword'] )
	  {
	    $this->setError( array( "type" => "PASSWORD_MISMATCH" ) );
	    return;
	  }

	// Verify e-mail
	if( $this->post['contactemail'] != $this->post['verifyemail'] )
	  {
	    $this->setError( array( "type" => "EMAIL_MISMATCH" ) );
	    return;
	  }

	// Check for a duplicate username
	try 
	  { 
	    load_UserDBO( $this->post['username'] ); 
	    throw new SWUserException( "[USERNAME_EXISTS]" );
	  }
	catch( DBNoRowsFoundException $e ) {}

	$this->session['order']->setNote( $this->post['note'] );

	// Stuff the contact info into the order
	$this->session['order']->setBusinessName( $this->post['businessname'] );
	$this->session['order']->setContactname( $this->post['contactname'] );
	$this->session['order']->setContactEmail( $this->post['contactemail'] );
	$this->session['order']->setAddress1( $this->post['address1'] );
	$this->session['order']->setAddress2( $this->post['address2'] );
	$this->session['order']->setCity( $this->post['city'] );
	$this->session['order']->setState( $this->post['state'] );
	$this->session['order']->setCountry( $this->post['country'] );
	$this->session['order']->setPostalCode( $this->post['postalcode'] );
	$this->session['order']->setPhone( $this->post['phone'] );
	$this->session['order']->setMobilePhone( $this->post['mobilephone'] );
	$this->session['order']->setFax( $this->post['fax'] );
	$this->session['order']->setUsername( $this->post['username'] );
	$this->session['order']->setPassword( $this->post['password'] );
      }

    $domainItems = $this->session['order']->getDomainItems();
    if( !empty( $domainItems ) && 
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