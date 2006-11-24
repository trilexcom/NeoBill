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
  protected $accountID = null;

  /**
   * @var integer Server ID
   */
  protected $serverID = null;

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
    $where = isset( $this->serverID ) ?
      sprintf( "serverid='%d'", $this->serverID ) : $where;

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
		     "recurringprice" => $dbo->getRecurringPrice(),
		     "onetimeprice" => $dbo->getOnetimePrice(),
		     "date" => $dbo->getDate(),
		     "accountname" => $dbo->getAccountName() );
	  }
      }
  }

  /**
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  public function setAccountID( $id ) { $this->accountID = $id; }

  /**
   * Set Server ID
   *
   * @param integer $id Server ID
   */
  public function setServerID( $id ) { $this->serverID = $id; }
}