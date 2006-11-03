<?php
/**
 * InvoiceTableWidget.class.php
 *
 * This file contains the definition of the InvoiceTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

// InvoiceDBO
require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * InvoiceTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvoiceTableWidget extends TableWidget
{
  /**
   * @var string Oustanding invoice filter
   */
  private $outstandingFilter = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Build an invoice filter
    $where = isset( $this->outstandingFilter ) ?
      sprintf( "outstanding='%s'", $this->outstandingFilter ) : null;

    // Load the Invoice Table
    if( null != ($invoices = load_array_InvoiceDBO( $where )) )
      {
	// Build the table
	foreach( $invoices as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "accountid" => $dbo->getAccountID(),
                     "accountname" => $dbo->getAccountName(),
		     "date" => $dbo->getDate(),
		     "periodbegin" => $dbo->getPeriodBegin(),
		     "periodend" => $dbo->getPeriodEnd(),
		     "note" => $dbo->getNote(),
		     "terms" => $dbo->getTerms(),
		     "outstanding" => $dbo->getOutstanding(),
		     "total" => $dbo->getTotal(),
		     "totalpayments", $dbo->getTotalPayments(),
		     "balance" => $dbo->getBalance() );
	  }
      }
  }

  /**
   * Set Outstanding Filter
   *
   * @param string $outstanding Outstanding flag (yes/no/null)
   */
  public function setOutstanding( $outstanding )
  {
    $this->outstandingFilter = $outstanding;
  }
}