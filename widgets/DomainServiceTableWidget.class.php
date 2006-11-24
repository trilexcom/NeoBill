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
	    // Format the pricing for this hosting service
	    $priceString = "";
	    $prices = array_merge( $dbo->getPricing( "Onetime" ),
				   $dbo->getPricing( "Recurring" ) );
	    foreach( $prices as $priceDBO )
	      {
		$price = sprintf( "%s%01.2f", $conf['locale']['currency_symbol'],
				  $priceDBO->getPrice() );
		$priceString .= $priceDBO->getType() == "Onetime" ? 
		  sprintf( "[ONETIME]: %s<br/>", $price ) :
		  sprintf( "%d [MONTHS]: %s<br/>", $priceDBO->getTermLength(), $price );
	      }

	    // Put the row into the table
	    $this->data[] = 
	      array( "tld" => $dbo->getTLD(),
		     "description" => $dbo->getDescription(),
		     "pricing" => $priceString,
		     "module" => $dbo->getModuleName() );
	  }
      }
  }
}