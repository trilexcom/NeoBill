<?php
/**
 * PriceTableWidget.class.php
 *
 * This file contains the definition of the PriceTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PriceTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PriceTableWidget extends TableWidget
{
  /**
   * @var array Array of prices to display
   */
  protected $prices = array();

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Build the table
    foreach( $this->prices as $dbo )
      {
	// Put the row into the table
	$this->data[] = 
	  array( "id" => $dbo->getID(),
		 "type" => $dbo->getType(),
		 "termlength" => $dbo->getTermLength(),
		 "price" => $dbo->getPrice(),
		 "taxable" => $dbo->getTaxable() );
      }
  }

  /**
   * Set Prices
   *
   * @param array Price array
   */
  public function setPrices( $prices ) { $this->prices = $prices; }
}