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
  protected $invoiceID = null;

  /**
   * @var integer Order ID
   */
  protected $orderID = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Build an Payment filter
    $where = "";
    if( isset( $this->invoiceID ) )
      {
	$where = sprintf( "invoiceid='%d'", $this->invoiceID );
      }
    if( isset( $this->orderID ) )
      {
	$where = sprintf( "orderid='%d'", $this->orderID );
      }

    // Load the Payment Table
    try
      {
	// Build the table
	$items = load_array_PaymentDBO( $where );
	foreach( $items as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "date"=> $dbo->getDate(),
		     "amount" => $dbo->getAmount(),
		     "type" => $dbo->getType(),
		     "module" => $dbo->getModule(),
		     "status" => $dbo->getStatus() );
	  }
      }
    catch( DBNoRowsFoundException $e ) {}
  }

  /**
   * Set Invoice ID
   *
   * @param integer $id Invoice ID
   */
  public function setInvoiceID( $id ) { $this->invoiceID = $id; }

  /**
   * Set Order ID
   *
   * @param integer $id Order ID
   */
  public function setOrderID( $id ) { $this->orderID = $id; }
}