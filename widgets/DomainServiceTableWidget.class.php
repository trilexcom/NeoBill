<?php
/**
 * DomainServiceTableWidget.class.php
 *
 * This file contains the definition of the DomainServiceTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DomainServiceTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServiceTableWidget extends TableWidget
{
  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Load the DomainService Table
    if( null != ($services = load_array_DomainServiceDBO( $where )) )
      {
	// Build the table
	foreach( $services as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "tld" => $dbo->getTLD(),
		     "description" => $dbo->getDescription(),
		     "price1yr" => $dbo->getPrice1yr(),
		     "price2yr" => $dbo->getPrice2yr(),
		     "price3yr" => $dbo->getPrice3yr(),
		     "price4yr" => $dbo->getPrice4yr(),
		     "price5yr" => $dbo->getPrice5yr(),
		     "price6yr" => $dbo->getPrice6yr(),
		     "price7yr" => $dbo->getPrice7yr(),
		     "price8yr" => $dbo->getPrice8yr(),
		     "price9yr" => $dbo->getPrice9yr(),
		     "price10yr" => $dbo->getPrice10yr(),
		     "taxable" => $dbo->getTaxable() );
	  }
      }
  }
}