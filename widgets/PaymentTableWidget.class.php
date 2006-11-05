<?php
/**
 * PaymentTableWidget.class.php
 *
 * This file contains the definition of the PaymentTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

// PaymentDBO
require_once BASE_PATH . "DBO/PaymentDBO.class.php";

/**
 * PaymentTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaymentTableWidget extends TableWidget
{
  /**
   * @var integer Invoice ID
   */
  private $invoiceID = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Build an Payment filter
    $where = isset( $this->invoiceID ) ? 
      sprintf( "invoiceid='%d'", $this->invoiceID ) : null;

    // Load the Payment Table
    if( null != ($items = load_array_PaymentDBO( $where )) )
      {
	// Build the table
	foreach( $items as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "date"=> $dbo->getDate(),
		     "amount" => $dbo->getAmount(),
		     "type" => $dbo->getType() );
	  }
      }
  }

  /**
   * Set Invoice ID
   *
   * @param integer $id Invoice ID
   */
  public function setInvoiceID( $id ) { $this->invoiceID = $id; }
}