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
class EditAccountPage extends SolidStatePage {
	/**
	 * Initialize the Edit Account Page
	 *
	 * If the Account ID is provided in the query string, load the AccountDBO from
	 * the database and store it in the session.  Otherwise, use the DBO that is already
	 * there.
	 */
	function init() {
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
	function action( $action_name ) {
		switch ( $action_name ) {
			case "edit_account":
				if ( isset( $this->session['edit_account']['save'] ) ) {
					// Save changes
					$this->update_account();
					$this->gotoPage( "accounts_view_account",
							array( array( "type" => "ACCOUNT_UPDATED" ) ),
							"account=" . $this->get['account']->getID() );
				}
				elseif ( isset( $this->session['edit_account']['cancel'] ) ) {
					// Cancel (return to view page)
					$this->gotoPage( "accounts_view_account",
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
	function update_account() {
		// Access DBO
		$account_dbo =& $this->get['account'];

		// Update DBO
		$account_dbo->setType( $this->post['type'] );
		$account_dbo->setStatus( $this->post['status'] );
		$account_dbo->setBillingStatus( $this->post['billingstatus'] );
		$account_dbo->setBillingDay( $this->post['billingday'] );
		$account_dbo->setBusinessName( $this->post['businessname'] );
		$account_dbo->setContactName( $this->post['contactname'] );
		$account_dbo->setContactEmail( $this->post['contactemail'] );
		$account_dbo->setAddress1( $this->post['address1'] );
		$account_dbo->setAddress2( $this->post['address2'] );
		$account_dbo->setCity( $this->post['city'] );
		$account_dbo->setState( $this->post['state'] );
		$account_dbo->setCountry( $this->post['country'] );
		$account_dbo->setPostalCode( $this->post['postalcode'] );
		$account_dbo->setPhone( $this->post['phone'] );
		$account_dbo->setMobilePhone( $this->post['mobilephone'] );
		$account_dbo->setFax( $this->post['fax'] );
		update_AccountDBO( $account_dbo );

		// Success!
		$this->setMessage( array( "type" => "[ACCOUNT_UPDATED]" ) );
	}
}

?>