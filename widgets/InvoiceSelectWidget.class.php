<?php
/**
 * InvoiceSelectWidget.class.php
 *
 * This file contains the definition of the InvoiceSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// Invoice  DBO
require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * InvoiceSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvoiceSelectWidget extends SelectWidget
{
  /**
   * @var integer Account ID
   */
  protected $accountid = null;

  /**
   * @var boolean Filter Oustanding flag
   */
  protected $filterOutstanding = false;

  /**
   * Filter Outstanding
   *
   * Restricts the display of Invoices to only those which are outstanding
   */
  public function filterOutstanding() { $this->filterOutstanding = true; }

  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  public function getData()
  {
    // Check if there is a specific account ID to show invoices for
    $where = null;
    if( $this->accountid != null )
      {
	$where = "accountid=" . $this->accountID . " ";
      }

    // Check if we should only show outstanding invoices
    if( $this->filterOutstanding )
      {
	$where .= "outstanding='yes' ";
      }
    
    // Query InvoiceDBO's
    $invoiceDBOs = load_array_InvoiceDBO( $where );
    if( empty( $invoiceDBOs ) )
      {
	return array();
      }

    // Convery to an array: invoice ID => invoice name
    $invoices = array();
    foreach( $invoiceDBOs as $invoiceDBO )
      {
	$invoices[$invoiceDBO->getID()] = $invoiceDBO->getDescription();
      }

    return $invoices;
  }

  /**
   * Set Account ID
   *
   * Restricts the display of Invoices to only those with a specific account ID
   *
   * @param integer $accountID Account ID
   */
  public function setAccountID( $accountID )
  {
    $this->accountID = intval( $accountID );
  }
}
?>