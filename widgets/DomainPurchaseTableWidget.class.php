<?php
/**
 * DomainPurchaseTableWidget.class.php
 *
 * This file contains the definition of the DomainPurchaseTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DomainPurchaseTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainPurchaseTableWidget extends TableWidget
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

    // Build an DomainPurchase filter
    $where = isset( $this->accountID ) ? 
      sprintf( "accountid='%d'", $this->accountID ) : null;

    // Load the DomainPurchase Table
    if( null != ($purchases = load_array_DomainServicePurchaseDBO( $where )) )
      {
	// Build the table
	foreach( $purchases as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "fulldomainname" => $dbo->getFullDomainName(),
		     "term" => $dbo->getTerm(),
		     "date" => $dbo->getDate(),
		     "expiredate" => $dbo->getExpireDate() );
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