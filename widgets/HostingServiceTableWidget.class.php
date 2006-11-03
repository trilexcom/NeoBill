<?php
/**
 * HostingServiceTableWidget.class.php
 *
 * This file contains the definition of the HostingServiceTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

// HostingServiceDBO
require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * HostingServiceTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingServiceTableWidget extends TableWidget
{
  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Load the HostingService Table
    if( null != ($services = load_array_HostingServiceDBO( $where )) )
      {
	// Build the table
	foreach( $services as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "title" => $dbo->getTitle(),
		     "description" => $dbo->getDescription(),
		     "uniqueip" => $dbo->getUniqueIP(),
		     "setupprice1mo" => $dbo->getSetupPrice1mo(),
		     "setupprice3mo" =>  $dbo->getSetupPrice3mo(),
		     "setupprice6mo" => $dbo->getSetupPrice6mo(),
		     "setupprice12mo" => $dbo->getSetupPrice12mo(),
		     "price1mo" => $dbo->getPrice1mo(),
		     "price3mo" => $dbo->getPrice3mo(),
		     "price6mo" => $dbo->getPrice6mo(),
		     "price12mo" => $dbo->getPrice12mo(),
		     "taxable" => $dbo->getTaxable() );
	  }
      }
  }
}