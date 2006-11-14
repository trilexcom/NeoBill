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

/**
 * InvoiceTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvoiceTableWidget extends TableWidget
{
  /**
   * @var integer Account ID
   */
  protected $accountID = null;

  /**
   * @var string Oustanding invoice filter
   */
  protected $outstandingFilter = null;

  /**
   * @var InvoiceDBO When set, show only outstanding invoices prior to this one
   */
  protected $priorToInvoice = null;

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
      sprintf( "outstanding='%s' ", $this->outstandingFilter ) : null;
    $where .= isset( $this->accountID ) ?
      sprintf( "accountid='%d' ", $this->accountID ) : null;

    // If a prior-to invoice is given, just go with this clause:
    $where = isset( $this->priorToInvoice ) ?
      sprintf( "id <> %d AND accountid=%d AND outstanding='%s' AND `date` < '%s'",
	       $this->priorToInvoice->getID(),
	       $this->priorToInvoice->getAccountID(),
	       "yes",
	       $this->priorToInvoice->getPeriodBegin() ) : $where;

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
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  public function setAccountID( $id ) { $this->accountID = $id; }

  /**
   * Set Outstanding Filter
   *
   * @param string $outstanding Outstanding flag (yes/no/null)
   */
  public function setOutstanding( $outstanding )
  {
    $this->outstandingFilter = $outstanding;
  }

  /**
   * Set Priot To Invoice
   *
   * @param InvoiceDBO $invoice Invoice
   */
  public function setPriorToInvoice( InvoiceDBO $invoice )
  {
    $this->priorToInvoice = $invoice;
  }
}