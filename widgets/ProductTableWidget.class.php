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
    parent::init( $params );

    // Load the Product Table
    if( null != ($products = load_array_ProductDBO( $where )) )
      {
	// Build the table
	foreach( $products as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "name" => $dbo->getName(),
		     "description" => $dbo->getDescription(),
		     "price" => $dbo->getPrice(),
		     "taxable" => $dbo->getTaxable() );
	  }
      }
  }
}