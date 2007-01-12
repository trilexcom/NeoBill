<?php
/**
 * PurchaseDBO.class.php
 *
 * This file contains the definition for the PurchaseDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * PurchaseDBO
 *
 * Represent a Purchase.  This class is abstract, it is implemented by the
 * DomainServicePurchase, HostingServicePurchase, and ProductPurchase classes.
 * A PurchaseDBO is still abstract, but it is more concrete than SaleDBO.  A
 * "Purchase" attaches a product or service to a specific account.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class PurchaseDBO extends SaleDBO
{
  /**
   * @var integer Account ID
   */
  protected $accountid;

  /**
   * @var AccountDBO Account
   */
  protected $accountdbo;

  /**
   * @var string Purchase date (MySQL datetime)
   */
  protected $date = null;

  /**
   * @var string The next day that this purchase will be billed on
   */
  protected $nextBillingDate = null;

  /**
   * @var string Purchase note
   */
  protected $note;

  /**
   * @var integer ID of the last invoice this purchase was billed on
   */
  protected $prevInvoiceID = null;

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();

    // Initialize the next payment date to today
    $this->setNextBillingDate( DBConnection::format_date( time() ) );
  }

  /**
   * Get Account ID
   *
   * @return integer Account ID
   */
  public function getAccountID() { return $this->accountid; }

  /**
   * Get Account Name
   *
   * @return string Account Name
   */
  public function getAccountName() { return $this->accountdbo->getAccountName(); }

  /**
   * Get Purchase Date
   *
   * @return string Purchase date (MySQL datetime)
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * Get Description for "One-time" Line Item
   *
   * @return string The text that should appear on the invoice for this purchase
   */
  public function getLineItemTextOneTime()
  {
    return $this->getTitle() . " ([ONETIME])";
  }

  /**
   * Get Description for "Recurring" Line Item
   *
   * @return string The text that should appear on the invoice for this purchase
   */
  public function getLineItemTextRecurring()
  {
    return $this->getTitle();
  }

  /**
   * Get Description for "Tax" Line Item
   *
   * @return string The text that should appear on the invoice for this purchase
   */
  public function getLineItemTextTax()
  {
    return $this->getTitle() . ": [TAX]";
  }

  /**
   * Get Next Billing Date
   *
   * @return string The next billing date for this purchase (MySQL DATETIME)
   */
  public function getNextBillingDate() { return $this->nextBillingDate; }

  /**
   * Get Purchase Note
   *
   * @return string Purchase note
   */
  function getNote() { return $this->note; }

  /**
   * Get Previous Invoice ID
   *
   * @return integer The ID of the invoice this purchase last appeared on or -1 if last charged to an order
   */
  public function getPrevInvoiceID() { return $this->prevInvoiceID; }

  /**
   * Get Tax Rules
   *
   * @return array An array of tax rules that apply to this purchase
   */
  protected function getTaxRules() 
  { 
    $DB = DBConnection::getDBConnection();

    $filter = 
      "country=" . $DB->quote_smart( $this->accountdbo->getCountry() ) . " AND (" .
      "allstates=" . $DB->quote_smart( "YES" ) . " OR " .
      "state=" . $DB->quote_smart( $this->accountdbo->getState() ) . ")";

    try { return load_array_TaxRuleDBO( $filter ); }
    catch( DBNoRowsFoundException $e ) { return array(); }
  }

  /**
   * Get Product/Service Title
   *
   * @return string Product/Service title
   */
  abstract function getTitle();

  /**
   * Increment Next Billing Date
   */
  public function incrementNextBillingDate()
  {
    $nextBillingDateTS = DBConnection::date_to_unix( $this->getNextBillingDate() );
    $oldBillingDate = getdate( $nextBillingDateTS );
    $nextBillingDate = 
      DBConnection::format_date( mktime( 0, 0, 1,
					 $oldBillingDate['mon'] + $this->getTerm(),
					 $oldBillingDate['mday'],
					 $oldBillingDate['year'] ) );

    $this->setNextBillingDate( $nextBillingDate );
    return $nextBillingDate;
  }

  /**
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  public function setAccountID( $id )
  {
    $this->accountid = $id;
    $this->accountdbo = load_AccountDBO( $id );
  }

  /**
   * Set Purchase Date
   *
   * @param string $date Purchase date (MySQL datetime)
   */
  public function setDate( $date ) { $this->date = $date; }

  /**
   * Set Next Billing Date
   *
   * @param string The next billing date for this purchase (MySQL DATETIME)
   */
  public function setNextBillingDate( $date ) { $this->nextBillingDate = $date; }

  /**
   * Set Purchase Note
   *
   * @param string $note Purchase note
   */
  function setNote( $note ) { $this->note = $note; }

  /**
   * Set Previous Invoice ID
   *
   * @param integer The ID of the Invoice this purchase last appeared on
   */
  public function setPrevInvoiceID( $id ) { $this->prevInvoiceID = $id; }
}

?>