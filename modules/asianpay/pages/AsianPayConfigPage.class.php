<?php
/**
 * AsianPayConfigPage.class.php
 *
 * This file contains the definition of the AsianPayConfigPage class.
 *
 */

require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

class AsianPayConfigPage extends SolidStateAdminPage {
	/**
	 * @var asianpay module
	 */
	var $AsianPayModule;

	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch ( $action_name ) {
			case "asianpay_config":
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

		$registry = ModuleRegistry::getModuleRegistry();
		$this->asianpayModule = $registry->getModule( "Asianpay" );
		$this->smarty->assign( "accountid", $this->asianpayModule->getAccountid() );
		$this->smarty->assign( "receiverid", $this->asianpayModule->getReceiverid() );
		$this->smarty->assign( "secretcode", $this->asianpayModule->getSecretcode() );
		$this->smarty->assign( "receiveremail", $this->asianpayModule->getReceiveremail() );
	}

	/**
	 * Save Settings
	 */
	function save() {
		// Update settings in DB
		
		$this->asianpayModule->setReceiverid( $this->post['receiverid'] );
		$this->asianpayModule->setAccountid( $this->post['accountid'] );
		$this->asianpayModule->setSecretcode( $this->post['secretcode'] );
		$this->asianpayModule->setReceiveremail( $this->post['receiveremail'] );
		
		$this->asianpayModule->saveSettings();

		$this->setMessage( array( "type" => "[asianpay_CONFIGURATION_SAVED]" ) );
	}
}
?>