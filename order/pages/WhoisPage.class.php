<?php
/**
 * WhoisPage.class.php
 *
 * This file contains the definition for the WhoisPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once BASE_PATH . "include/SolidStatePage.class.php";

/**
 * WhoisPage
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class WhoisPage extends SolidStatePage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *
	 * @param string $action_name Action
	 */
	public function action( $action_name ) {
		switch ( $action_name ) {
			case "whoispurchase":
				if ( $this->post['option'] == "hosting" ) {
					$page = "purchasehosting";
				}
				elseif ( $this->post['option'] == "nohosting" ) {
					$page = "purchasedomain";
				}

				$this->gotoPage( $page,
						null,
						sprintf( "domain=%s&tld=%s",
						$this->get['domain'],
						$this->get['tld']->getTLD() ) );

				break;

			default:
				parent::action( $action_name );
				break;
		}
	}

	/**
	 * Initialize Page
	 */
	public function init() {
		parent::init();

		// Access the registrar module for the selected TLD
		$moduleName = $this->get['tld']->getModuleName();
		$registrar = ModuleRegistry::getModuleRegistry()->getModule( $moduleName );

		$fqdn = $this->get['domain'] . '.' . $this->get['tld']->getTLD();
		$this->smarty->assign( "fqdn", $fqdn );
		if ( !$registrar->checkAvailability( $fqdn ) ) {
			$this->setTemplate( "unavailable" );
		}
		else {
			$this->setURLField( "domain", $this->get['domain'] );
			$this->setURLField( "tld", $this->get['tld']->getTLD() );
		}
	}
}