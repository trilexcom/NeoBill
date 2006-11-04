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

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

// LogDBO
require_once BASE_PATH . "DBO/LogDBO.class.php";

/**
 * LogTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LogTableWidget extends TableWidget
{
  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Load the Log Table
    if( null != ($logs = load_array_LogDBO( $where )) )
      {
	// Build the table
	foreach( $logs as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "type" => $dbo->getType(),
		     "text" => $dbo->getText(),
		     "user" => $dbo->getUsername(),
		     "ip" => $dbo->getRemoteIPString(),
		     "date" => $dbo->getDate() );
	  }
      }
  }
}