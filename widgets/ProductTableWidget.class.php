<?php
/**
 * ProductTableWidget.class.php
 *
 * This file contains the definition of the ProductTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ProductTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductTableWidget extends TableWidget
{
  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    global $conf;

    parent::init( $params );

    // Load the Product Table
    try
      {
	// Build the table
	$products = load_array_ProductDBO( $where );
	foreach( $products as $dbo )
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
	      array( "id" => $dbo->getID(),
		     "name" => $dbo->getName(),
		     "description" => $dbo->getDescription(),
		     "pricing" => $priceString );
	  }
      }
    catch( DBNoRowsFoundException $e ) {}
  }
}