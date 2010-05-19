<?php
/**
 * LogTableWidget.class.php
 *
 * This file contains the definition of the LogTableWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * LogTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LogTableWidget extends TableWidget {
	/**
	 * Initialize the Table
	 *
	 * @param array $params Parameters from the {form_table} tag
	 */
	public function init( $params ) {
		parent::init( $params );

		// Load the Log Table
		try {
			// Build the table
			$logs = load_array_LogDBO( $where );
			foreach ( $logs as $dbo ) {
				// Put the row into the table
				$this->data[] =
						array( "id" => $dbo->getID(),
						"type" => $dbo->getType(),
						"text" => $dbo->getText(),
						"username" => $dbo->getUsername(),
						"ip" => $dbo->getRemoteIPString(),
						"date" => $dbo->getDate() );
			}
		}
		catch ( DBNoRowsFoundException $e ) {

		}
	}
}