<?php
/**
 * ServicesPage.class.php
 *
 * This file contains the definition for the ServicesPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStatePage.class.php";

require_once BASE_PATH . "util/services.php";

/**
 * ServicesPage.class.php
 *
 * This class handles the Products & Services Summary Page.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServicesPage extends SolidStatePage {
	/**
	 * Initialize the Services Page
	 *
	 * Provides statistics to the template
	 */
	function init() {
		parent::init();

		// Get stats
		$services = services_stats();
		$domain_services = domain_services_stats();
		$products = products_stats();

		// Put stats on the page
		$this->smarty->assign( "services_count",        $services['count'] );
		$this->smarty->assign( "domain_services_count", $domain_services['count'] );
		$this->smarty->assign( "products_count",        $products['count'] );
	}

	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *   none
	 *
	 * @param string $action_name Action
	 */
	function action( $action_name ) {
		switch ( $action_name ) {
			default:
				// No matching action, refer to base class
				parent::action( $action_name );

		}
	}
}

?>