<?php
/**
 * IPPoolTableWidget.class.php
 *
 * This file contains the definition of the IPPoolTableWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * IPPoolTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class IPPoolTableWidget extends TableWidget {
	/**
	 * @var integer Server ID to filter by
	 */
	protected $serverID = null;

	/**
	 * Initialize the Table
	 *
	 * @param array $params Parameters from the {form_table} tag
	 */
	public function init( $params ) {
		parent::init( $params );

		// Build a where clause
		$where = isset( $this->serverID ) ?
				sprintf( "serverid='%d'", $this->serverID ) : null;

		// Load the IP Address pool
		try {
			// Build the table
			$IPAddresses = load_array_IPAddressDBO( $where );
			foreach ( $IPAddresses as $dbo ) {
				// Put the row into the table
				$this->data[] =
						array( "ipaddress" => $dbo->getIP(),
						"ipaddressstring" => $dbo->getIPString(),
						"server" => $dbo->getServerID(),
						"hostname" => $dbo->getHostName(),
						"isAvailable" => $dbo->isAvailable(),
						"accountname" => $dbo->getAccountName(),
						"service" => $dbo->getServiceTitle() );
			}
		}
		catch ( DBNoRowsFoundException $e ) {

		}
	}

	/**
	 * Set Server ID
	 *
	 * @param interger $id Server ID to filter by
	 */
	public function setServerID( $id ) {
		$this->serverID = $id;
	}
}