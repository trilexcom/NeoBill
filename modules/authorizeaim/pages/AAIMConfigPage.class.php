<?php
/**
 * AAIMConfigPage.class.php
 *
 * This file contains the definition of the AAIMConfigPage class.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * AAIMConfigPage
 *
 * This is the Manager's configuration page for the Authorize.net AIM module.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AAIMConfigPage extends SolidStateAdminPage {
	/**
	 * @var AuthorizeAIM AuthorizeAIM module
	 */
	var $aaimModule;

	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch ( $action_name ) {
			case "aaim_config":
				if ( isset( $this->post['save'] ) ) {
					$this->save();
				}
				break;

			default:
				// No matching action - refer to base class
				parent::action( $action_name );

		}
	}

	/**
	 * Initialize the Page
	 */
	function init() {
		parent::init();

		// Load the form values with Module settings
		$registry = ModuleRegistry::getModuleRegistry();
		$this->aaimModule = $registry->getModule( "authorizeaim" );
		$this->smarty->assign( "delimiter", $this->aaimModule->getDelimiter() );
		$this->smarty->assign( "loginid",  $this->aaimModule->getLoginID() );
		$this->smarty->assign( "transactionkey", $this->aaimModule->getTransactionKey() );
		$this->smarty->assign( "transactionurl", $this->aaimModule->getURL() );
	}

	/**
	 * Save Settings
	 */
	function save() {
		// Update settings in DB
		$this->aaimModule->setDelimiter( $this->post['delimiter'] );
		$this->aaimModule->setLoginID( $this->post['loginid'] );
		$this->aaimModule->setTransactionKey( $this->post['transactionkey'] );
		$this->aaimModule->setURL( $this->post['transactionurl'] );
		$this->aaimModule->saveSettings();

		$this->setMessage( array( "type" => "[AAIM_CONFIGURATION_SAVED]" ) );
	}
}
?>