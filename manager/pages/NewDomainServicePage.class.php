<?php
/**
 * NewDomainServicePage.class.php
 *
 * This file contains the definition for the NewDomainServicePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * NewDomainServicePage
 *
 * Create a new domain service
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class NewDomainServicePage extends SolidStateAdminPage {
	/**
	 * Action
	 *
	 * Actions handled by this page:
	 *   new_domain_service (form)
	 *   new_domain_service_confirm (form)
	 *
	 * @param string $action_name Action
	 */
	public function action( $action_name ) {
		switch ( $action_name ) {
			case "new_domain_service":
				if ( isset( $this->post['continue'] ) ) {
					// Process new hosting service form
					$this->add_domain_service();
				}
				elseif ( isset( $this->post['cancel'] ) ) {
					// Canceled
					$this->goback();
				}
				break;

			default:
				// No matching action - refer to base class
				parent::action( $action_name );
		}
	}

	/**
	 * Add Domain Service
	 *
	 * Add the DomainServiceDBO to the database
	 */
	protected function add_domain_service() {
		// Prepare DomainServiceDBO for database
		$service_dbo = new DomainServiceDBO();
		$service_dbo->setTLD( $this->post['tld'] );
		$service_dbo->setModuleName( $this->post['modulename']->getName() );
		$service_dbo->setDescription( $this->post['description'] );
		$service_dbo->setPublic( isset( $this->post['public'] ) ? "Yes" : "No" );

		// Insert DomainServiceDBO into database
		add_DomainServiceDBO( $service_dbo );

		// Hosting Service added
		// Jump to View Domain Service page
		$this->gotoPage( "services_edit_domain_service",
				array( array( "type" => "[DOMAIN_SERVICE_ADDED]" ) ),
				"dservice=" . $service_dbo->getTLD() );
	}
}
?>