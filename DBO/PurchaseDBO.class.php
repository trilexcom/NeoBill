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
class PurchaseDBO extends DBO
{
  /**
   * @var string Purchase date (MySQL datetime)
   */
  var $date = null;

  /**
   * @var string Purchase term ("1 month", "3 month", ..., "10 year")
   */
  var $term = null;

  /**
   * Calculate Tax
   *
   * Given a Tax Rule, determine the amount of tax on this purchase
   *
   * @param TaxRuleDBO $taxruledbo Tax rule
   * @return float Amount of tax
   */
  function calculateTax( $taxruledbo )
  {
    return $this->getPrice() * ($taxruledbo->getRate() / 100.00);
  }

  /**
   * Get Purchase Date
   *
   * @return string Purchase date (MySQL datetime)
   */
  function getDate()
  {
    return $this->date;
  }

  /**
   * Get Price
   *
   * @return float Price of this purchase
   */
  function getPrice() { return 0; }

  /**
   * Get Setup Fee
   *
   * @return float Setup fee
   */
  function getSetupFee() { return 0; }

  /**
   * Get Taxes
   *
   * @return array An array of tax rules that apply to this purchase
   */
  function getTaxes() 
  { 
    global $DB;

    if( !$this->isTaxable() )
      {
	return array(); 
      }

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
   * @return string Purchase term (as string: "1 month", "3 month", etc.)
   */
  function getTerm() { return $this->term; }

  /**
   * Get Purchase Term (in months)
   *
   * Gives the length of the purchase terms in months.
   *
   * @return integer Length of the purchase term in months
   */
  function getTermMonths()
  {
    switch( $this->getTerm() )
      {
      case "1 month": return 1;
      case "3 month": return 3;
      case "6 month": return 6;
      case "12 month":
      case "1 year": return 12;
      case "2 year": return 24;
      case "3 year": return 36;
      case "4 year": return 48;
      case "5 year": return 60;
      case "6 year": return 72;
      case "7 year": return 84;
      case "8 year": return 96;
      case "9 year": return 108;
      case "10 year": return 120;
      default: return 0;
      }
  }

  /**
   * Get Product/Service Title
   *
   * @return string Product/Service title
   */
  function getTitle() { return null; }

  /**
   * Is Billable This Term
   *
   * Takes two timestamps: the beginning of an invoice term and the end of an
   * invoice term.  If this purchase is billable during the period, return true.
   *
   * @param integer $periodBeginTS The beginning of the billing period (timestamp)
   * @param integer $periodEndTS The end of the billing period (timestamp)
   * @return boolean True if this purchase should be billed
   */
  function isBillable( $periodBeginTS, $periodEndTS )
  {
    global $DB;

    $purchaseTS = $DB->datetime_to_unix( $this->getDate() );

    if( $periodEndTS < $purchaseTS )
      {
	// This invoice bills before this purchases existed
	return false;
      }
    if( $this->isNewThisTerm( $periodBeginTS, $periodEndTS ) )
      {
	// This purchase is new this billing term
	return true;
      }

    if( !$this->isRecurring() )
      {
	// Only recurring purchases are tested beyond this point
	return false;
      }

    // Calcuate the distance (in months) between the purchase date and the beginning
    // (and end) of the invoice period
    $yearDiff1 = date('y', $periodBeginTS) - date('y', $purchaseTS) ;
    $monthDiff1 = date('m', $periodBeginTS) - date('m', $purchaseTS) + ($yearDiff * 12);
    $monthDiff1 = $monthDiff1 < 0 ? $monthDiff1 + 12 : $monthDiff1;

    $yearDiff2 = date('y', $periodEndTS) - date('y', $purchaseTS) ;
    $monthDiff2 = date('m', $periodEndTS) - date('m', $purchaseTS) + ($yearDiff * 12);
    $monthDiff2 = $monthDiff2 < 0 ? $monthDiff2 + 12 : $monthDiff2;

    // These truths help determine if the purchases recurs during the invoice period

    $purchasedSameMonthButBeforePeriodBegins =
      ($monthDiff1 == 0) && (date( 'j', $purchaseTS ) < date( 'j', $periodBeginTS ));

    $recursAfterPeriodBegins = 
      (($monthDiff1 % $this->getTermMonths() == 0) &&
       (date( 'j', $purchaseTS ) >= date( 'j', $periodBeginTS ))) ||
      (($monthDiff1 % $this->getTermMonths() == 0 ||
	$monthDiff2 % $this->getTermMonths() == 0 ||
	$monthDiff1 % $this->getTermMonths() == $monthDiff1) &&
       (date( 'j', $purchaseTS ) < date( 'j', $periodBeginTS )));

    $recursBeforePeriodEnds =
      (($monthDiff2 % $this->getTermMonths() == 0) && 
       (date( 'j', $purchaseTS ) < date( 'j', $periodEndTS ))) ||
      (($monthDiff2 % $this->getTermMonths() == 0 ||
	$monthDiff2 % $this->getTermMonths() == 1) &&
       (date( 'j', $purchaseTS ) >= date( 'j', $periodEndTS )));

    // Usefull for debugging
    /*
    echo $this->getTitle() . ": " .
      !($purchasedSameMonthButBeforePeriodBegins && !$recursBeforePeriodEnds) . "/" .
      $recursAfterPeriodBegins . "/" .
      $recursBeforePeriodEnds . " monthDiff2: " . $monthDiff2 % $this->getTermMonths() . "\n";
    */

    // Test if this purchase recurs during the invoice period using the truths
    // calculated above
    return !($purchasedSameMonthButBeforePeriodBegins && !$recursBeforePeriodEnds) && 
      ($recursAfterPeriodBegins && $recursBeforePeriodEnds);
  }

  /**
   * Is New Purchase This Term
   *
   * Takes two timestamps: the beginning of an invoice term and then end of an
   * invoice term.  If this purchase was made during the period, return true.
   *
   * @param integer $periodBeginTS The beginning of the billing period (timestamp)
   * @param integer $periodEndTS The end of the billing period (timestamp)
   * @return boolean True if this purchase should be billed
   */
  function isNewThisTerm( $periodBeginTS, $periodEndTS )
  {
    global $DB;

    $purchaseTS = $DB->datetime_to_unix( $this->getDate() );
    return ($purchaseTS >= $periodBeginTS) && ($purchaseTS < $periodEndTS);
  }

  /**
   * Is Recurring
   *
   * @return boolean True if this purchase is a recurring purchase
   */
  function isRecurring() { return $this->getTermMonths() > 0; }

  /**
   * Is Taxable
   *
   * @return boolean True if this purchase is taxable
   */
  function isTaxable() { return false; }

  /**
   * Set Purchase Date
   *
   * @param string $date Purchase date (MySQL datetime)
   */
  function setDate( $date ) { $this->date = $date; }

  /**
   * Set Purchase Term
   *
   * @param string $term Purchase term ("1 year", "2 year" ... "10 year")
   */
  function setTerm( $term ) { $this->term = $term; }
}

?>