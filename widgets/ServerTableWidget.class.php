<?php
/**
 * ServerTableWidget.class.php
 *
 * This file contains the definition of the ServerTableWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ServerTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ServerTableWidget extends TableWidget {
	/**
	 * Initialize the Table
	 *
	 * @param array $params Parameters from the {form_table} tag
	 */
	public function init( $params ) {
		parent::init( $params );

		// Load the Server Table
		try {
			// Build the table
			$servers = load_array_ServerDBO( $where );
			foreach ( $servers as $dbo ) {
				// Put the row into the table
				$this->data[] =
						array( "id" => $dbo->getID(),
						"hostname" => $dbo->getHostName(),
						"location" => $dbo->getLocation() );
			}
		}
		catch ( DBNoRowsFoundException $e ) {

		}
	}
}