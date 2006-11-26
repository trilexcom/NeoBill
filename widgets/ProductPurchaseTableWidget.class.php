<?php
/**
 * ProductPurchaseTableWidget.class.php
 *
 * This file contains the definition of the ProductPurchaseTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ProductPurchaseTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductPurchaseTableWidget extends TableWidget
{
  /**
   * @var integer Account ID
   */
  private $accountID = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Build an ProductPurchase filter
    $where = isset( $this->accountID ) ? 
      sprintf( "accountid='%d'", $this->accountID ) : null;

    // Load the ProductPurchase Table
    if( null != ($purchases = load_array_ProductPurchaseDBO( $where )) )
      {
	// Build the table
	foreach( $purchases as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "productname" => $dbo->getProductName(),
		     "note" => $dbo->getNote(),
		     "date" => $dbo->getDate(),
		     "nextbillingdate" => $dbo->getNextBillingDate() );
	  }
      }
  }

  /**
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  public function setAccountID( $id ) { $this->accountID = $id; }
}