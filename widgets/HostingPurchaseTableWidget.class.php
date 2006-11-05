<?php
/**
 * HostingPurchaseTableWidget.class.php
 *
 * This file contains the definition of the HostingPurchaseTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

// HostingPurchaseDBO
require_once BASE_PATH . "DBO/HostingServicePurchaseDBO.class.php";

/**
 * HostingPurchaseTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingPurchaseTableWidget extends TableWidget
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

    // Build an HostingPurchase filter
    $where = isset( $this->accountID ) ? 
      sprintf( "accountid='%d'", $this->accountID ) : null;

    // Load the HostingPurchase Table
    if( null != ($purchases = load_array_HostingServicePurchaseDBO( $where )) )
      {
	// Build the table
	foreach( $purchases as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "title" => $dbo->getTitle(),
		     "term" => $dbo->getTerm(),
		     "serverid" => $dbo->getServerID(),
		     "hostname" => $dbo->getHostName(),
		     "price" => $dbo->getPrice(),
		     "date" => $dbo->getDate() );
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