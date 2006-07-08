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
require_once $base_path . "solidworks/Page.class.php";

// Order DBO
require_once $base_path . "DBO/OrderDBO.class.php";

// User DBO
require_once $base_path . "DBO/UserDBO.class.php";

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

    if( null != ($domainItems = $this->session['order']->getDomainItems()) && 
	$this->session['customer_information']['domaincontact'] == "same" )
      {
	// Contact information for all domains is the same as customer's contact info
	$contactDBO = new ContactDBO( $ci['contactname'],
				      $ci['businessname'],
				      $ci['contactemail'],
				      $ci['address1'],
				      $ci['address2'],
				      null,
				      $ci['city'],
				      $ci['state'],
				      $ci['postalcode'],
				      $ci['country'],
				      $ci['phone'],
				      $ci['mobilephone'],
				      $ci['fax'] );
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