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
 * OrderItemDBO
 *
 * Represent a Purchase.  This class is abstract, it is implemented by the
 * DomainServicePurchase, HostingServicePurchase, and ProductPurchase classes.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class PurchaseDBO extends DBO
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
   * @var integer ID of the last invoice this purchase was billed on
   */
  protected $prevInvoiceID = null;

  /**
   * @var PurchasableDBO The purchased item
   */
  protected $purchasable = null;

  /**
   * @var string Purchase term length (in months)
   */
  protected $term = null;

  /**
   * Constructor
   */
  public function __construct()
  {
    global $DB;

    // Initialize the next payment date to today
    $this->setNextBillingDate( $DB->format_date( time() ) );
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
   * Get Next Billing Date
   *
   * @return string The next billing date for this purchase (MySQL DATETIME)
   */
  public function getNextBillingDate() { return $this->nextBillingDate; }

  /**
   * Get Previous Invoice ID
   *
   * @return integer The ID of the invoice this purchase last appeared on
   */
  public function getPrevInvoiceID() { return $this->prevInvoiceID; }

  /**
   * Get Onetime price
   *
   * @return float Onetime price or null if none exists
   */
  public function getOnetimePrice()
  {
    $prices = $this->purchasable->getPricing( "Onetime" );
    if( empty( $prices ) )
      {
	return null;
      }

    return $prices[0]->getPrice();
  }

  /**
   * Get Taxes on Onetime Price
   *
   * @return float Total amount due for taxes on the onetime price
   */
  public function getOnetimeTaxes()
  {
    $priceDBO = array_shift( $this->purchasable->getPricing( "Onetime" ) );
    if( $priceDBO == null || !$priceDBO->isTaxable() )
      {
	return 0;
      }

    $taxes = 0.00;
    foreach( $this->getTaxRules() as $taxRuleDBO )
      {
	$taxes += $this->getOnetimePrice() * ($taxRuleDBO->getRate() / 100.00);
      }

    return $taxes;
  }

  /**
   * Get Purchasable
   *
   * @return PurchasableDBO Returns the purchasable
   */
  public function getPurchasable() { return $this->purchasable; }

  /**
   * Get Recurring Price
   *
   * @return float Recurring price of this purchase or null if none exists
   */
  public function getRecurringPrice()
  {
    $prices = $this->purchasable->getPricing( "Recurring", $this->getTerm() );
    if( empty( $prices ) )
      {
	return null;
      }

    return $prices[0]->getPrice();
  }

  /**
   * Get Taxes on Recurring Price
   *
   * @return float Total amount due for taxes on the recurring price
   */
  public function getRecurringTaxes()
  {
    $priceDBO = array_shift( $this->purchasable->getPricing( "Recurring", 
							     $this->getTerm() ) );
    if( $priceDBO == null || !$priceDBO->isTaxable() )
      {
	return 0;
      }

    $taxes = 0.00;
    foreach( $this->getTaxRules() as $taxRuleDBO )
      {
	$taxes += $this->getRecurringPrice() * ($taxRuleDBO->getRate() / 100.00);
      }

    return $taxes;
  }

  /**
   * Get Tax Rules
   *
   * @return array An array of tax rules that apply to this purchase
   */
  protected function getTaxRules() 
  { 
    global $DB;

    $filter = 
      "country=" . $DB->quote_smart( $this->accountdbo->getCountry() ) . " AND (" .
      "allstates=" . $DB->quote_smart( "YES" ) . " OR " .
      "state=" . $DB->quote_smart( $this->accountdbo->getState() ) . ")";
    $taxes = load_array_TaxRuleDBO( $filter );

    return $taxes == null ? array() : $taxes;
  }

  /**
   * Get Purchase Term
   *
   * @return integer Purchase term length (in months)
   */
  public function getTerm() { return $this->term; }

  /**
   * Get Product/Service Title
   *
   * @return string Product/Service title
   */
  abstract function getTitle();

  /**
   * Set Account ID
   *
   * @param integer $id Account ID
   */
  public function setAccountID( $id )
  {
    $this->accountid = $id;
    if( ($this->accountdbo = load_AccountDBO( $id )) == null )
      {
	fatal_error( "ProductPurchaseDBO::setAccountID()",
		     "could not load AccountDBO for AccountPurchaseDBO, id = " . $id );
      }
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
   * Set Previous Invoice ID
   *
   * @param integer The ID of the Invoice this purchase last appeared on
   */
  public function setPrevInvoiceID( $id ) { $this->prevInvoiceID = $id; }

  /**
   * Set Purchasable
   *
   * @param PurchasableDBO The purchased item
   */
  public function setPurchasable( PurchasableDBO $purchasable )
  {
    $this->purchasable = $purchasable;
  }

  /**
   * Set Purchase Term
   *
   * @param integer $term Purchase term (in months)
   */
  public function setTerm( $term ) { $this->term = $term; }
}

?>