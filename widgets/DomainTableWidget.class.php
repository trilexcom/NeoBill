<?php
/**
 * DomainTableWidget.class.php
 *
 * This file contains the definition of the DomainTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

// DomainDBO
require_once BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * DomainTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainTableWidget extends TableWidget
{
  /**
   * @var string Domain Status Flag
   */
  private $statusFlag = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Load the Domain Table
    if( null != ($domains = load_array_DomainServicePurchaseDBO( $where )) )
      {
	// Build the table
	foreach( $domains as $dbo )
	  {
	    if( ($this->statusFlag == "active" && !$dbo->isExpired()) ||
		($this->statusFlag == "expired" && $dbo->isExpired()) )
	      {
		// Skip
		continue;
	      }

	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
                     "tld" => $dbo->getTLD(),
		     "accountid" => $dbo->getAccountID(),
		     "domainname" => $dbo->getDomainName(),
		     "fulldomainname" => $dbo->getFullDomainName(),
		     "accountname" => $dbo->getAccountName(),
		     "date" => $dbo->getDate(),
		     "term" => $dbo->getTerm(),
		     "expiredate" => $dbo->getExpireDate() );
	  }
      }
  }

  /**
   * Show Active Domains Only
   */
  public function showActiveDomainsOnly() { $this->statusFlag = "active"; }

  /**
   * Show Expired Domains Only
   */
  public function showExpiredDomainsOnly() { $this->statusFlag = "expired"; }
}