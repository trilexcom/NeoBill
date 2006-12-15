<?php
/**
 * EditAccountPage.class.php
 *
 * This file contains the definition for the EditAccountPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * EditAccountPage
 *
 * Edit Account information and save any changes to the database
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditAccountPage extends SolidStatePage
{
  /**
   * Initialize the Edit Account Page
   *
   * If the Account ID is provided in the query string, load the AccountDBO from
   * the database and store it in the session.  Otherwise, use the DBO that is already
   * there.
   */
  function init()
  {
    parent::init();

    // Set URL fields
    $this->setURLField( "account", $this->get['account']->getID() );

    // Store service DBO in session
    $this->session['account_dbo'] = $this->get['account'];
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_account (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_account":
	if( isset( $this->session['edit_account']['save'] ) )
	  {
	    // Save changes
	    $this->update_account();
	    $this->goto( "accounts_view_account",
			 array( array( "type" => "ACCOUNT_UPDATED" ) ),
			 "account=" . $this->get['account']->getID() );
	  }
	elseif( isset( $this->session['edit_account']['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goto( "accounts_view_account",
			 null,
			 "account=" . $this->get['account']->getID() );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Update Account
   *
   * Take the Account data from the form and place it in the DBO, then update
   * the DBO in the database.
   */
  function update_account()
  {
    // Access DBO
    $account_dbo =& $this->get['account'];

    // Pull form data from session
    $account_data = $this->session['edit_account'];
   
    if( !isset( $account_data ) )
      {
	// Missing form data
	fatal_error( "EditAccountPage::update_account()",
		     "no form data received!" );
      }

    // Update DBO
    $account_dbo->setType( $account_data['type'] );
    $account_dbo->setStatus( $account_data['status'] );
    $account_dbo->setBillingStatus( $account_data['billingstatus'] );
    $account_dbo->setBillingDay( $account_data['billingday'] );
    $account_dbo->setBusinessName( $account_data['businessname'] );
    $account_dbo->setContactName( $account_data['contactname'] );
    $account_dbo->setContactEmail( $account_data['contactemail'] );
    $account_dbo->setAddress1( $account_data['address1'] );
    $account_dbo->setAddress2( $account_data['address2'] );
    $account_dbo->setCity( $account_data['city'] );
    $account_dbo->setState( $account_data['state'] );
    $account_dbo->setCountry( $account_data['country'] );
    $account_dbo->setPostalCode( $account_data['postalcode'] );
    $account_dbo->setPhone( $account_data['phone'] );
    $account_dbo->setMobilePhone( $account_data['mobilephone'] );
    $account_dbo->setFax( $account_data['fax'] );
    if( !update_AccountDBO( $account_dbo ) )
      {
	// Error
	$this->setError( array( "type" => "DB_ACCOUNT_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Sucess!
    $this->setMessage( array( "type" => "ACCOUNT_UPDATED" ) );
  }
}

?>