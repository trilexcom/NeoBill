<?php
/**
 * InvoiceItemDBO.class.php
 *
 * This file contains the definition for the InvoiceItemDBO class.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * InvoiceItemDBO
 *
 * Represents an Invoice line item.
 *
 * @package DBO
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvoiceItemDBO extends DBO
{
  /**
   * @var integer Invoice Item ID
   */
  var $id;

  /**
   * @var integer Invoice ID
   */
  var $invoiceid;

  /**
   * @var integer Quantity
   */
  var $quantity;

  /**
   * @var double Unit price
   */
  var $unitamount;

  /**
   * @var string Unit description
   */
  var $text;

  /**
   * @var string Tax item flag
   */
  var $taxItem = "No";

  /**
   * Convert to a String
   *
   * @return string Invoice Item ID
   */
  function __toString() { return $this->getID(); }

  /**
   * Set Invoice Item ID
   *
   * @param integer $id Invoice Item ID
   */
  function setID( $id ) { $this->id = $id; }

  /**
   * Get Invoice Item ID
   *
   * @return integer Invoice Ited ID
   */
  function getID() { return $this->id; }

  /**
   * Set Invoice ID
   *
   * @param integer $id Invoice ID
   */
  function setInvoiceID( $id ) 
  { 
    $this->invoiceid = $id; 
  }

  /**
   * Get Invoice ID
   *
   * @return integer Invoice ID
   */
  function getInvoiceID() { return $this->invoiceid; }

  /**
   * Set Unit Quantity
   *
   * @param integer $quantity Unit quantity
   */
  function setQuantity( $quantity ) { $this->quantity = $quantity; }

  /**
   * Get Unit Quantity
   *
   * @return integer Unit quantity
   */
  function getQuantity() { return $this->quantity; }

  /**
   * Set Unit Price
   *
   * @param double $amount Unit price
   */
  function setUnitAmount( $amount ) { $this->unitamount = $amount; }

  /**
   * Get Unit Price
   *
   * @return double Unit price
   */
  function getUnitAmount() { return $this->unitamount; }

  /**
   * Get Line Item Price
   *
   * Returns the total price of the line item.  That is, the unit price multiplied
   * by the number of units.
   *
   * @return double Line item price
   */
  function getAmount()
  {
    if( $this->getQuantity() == null ) 
      {
	return $this->getUnitAmount();
      }
    return $this->getUnitAmount() * $this->getQuantity();
  }

  /**
   * Set Item Description
   *
   * @param string $text Item description
   */
  function setText( $text ) { $this->text = $text; }

  /**
   * Get Item Description
   *
   * @return string Item description
   */
  function getText() { return $this->text; }

  /**
   * Set Tax Item Flag
   *
   * @param string $taxitem 'Yes' if this item is a tax item, 'No' otherwise
   */
  function setTaxItem( $taxitem )
  {
    if( !( $taxitem == "Yes" || $taxitem == "No" ) )
      {
	fatal_error( "InvoiceItemDBO::setTaxItem()", 
		     "Invalid value for tax item flag: " . $taxitem );
      }
    $this->taxItem = $taxitem;
  }

  /**
   * Get Tax Item Flag
   *
   * @return string Tax item flag ("Yes" or "No)
   */
  function getTaxItem() { return $this->taxItem; }

  /**
   * Is This Item a Tax Item
   *
   * @return boolean True if this invoice item is a tax item
   */
  function isTaxItem() { return $this->taxItem == "Yes"; }

  /**
   * Load member data from an array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    $this->setID( $data['id'] );
    $this->setInvoiceID( $data['invoiceid'] );
    $this->setQuantity( $data['quantity'] );
    $this->setUnitAmount( $data['unitamount'] );
    $this->setText( $data['text'] );
    $this->setTaxItem( $data['taxitem'] );
  }

  /**
   * Touch Invoice
   *
   * When a line item is added to an Invoice we must "touch" the Invoice to make
   * sure it's oustanding flag gets set properly.
   */
  function touchInvoice()
  {
    if( ($invoicedbo = load_InvoiceDBO( $this->invoiceid )) == null )
      {
	fatal_error( "InvoiceItemDBO::touchInvoice()",
		     "PaymentDBO::touchInvoice(), error: could not load InvoiceDBO" );
      }
    update_InvoiceDBO( $invoicedbo );
  }
}

/**
 * Insert InvoiceItemDBO into database
 *
 * @param InvoiceItemDBO &$dbo InvoiceItemDBO to add to database
 * @return boolean True on success
 */
function add_InvoiceItemDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_insert_sql( "invoiceitem",
				array( "invoiceid" => intval( $dbo->getInvoiceID() ),
				       "quantity" => intval( $dbo->getQuantity() ),
				       "unitamount" => $dbo->getUnitAmount(),
				       "text" => $dbo->getText(),
				       "taxitem" => $dbo->getTaxItem() ) );

  
  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      return false;
    }

  // Get auto-increment ID
  $id = mysql_insert_id( $DB->handle() );

  // Validate ID
  if( $id == false )
    {
      // DB error
      fatal_error( "add_InvoiceItemDBO()",
		   "Could not retrieve ID from previous INSERT!" );
    }
  if( $id == 0 )
    {
      // No ID?
      fatal_error( "add_InvoiceItemDBO()",
		   "Previous INSERT did not generate an ID" );
    }

  // Store ID in DBO
  $dbo->setID( $id );

  // Update Invoice's outstanding flag
  $dbo->touchInvoice();

  return true;
}

/**
 * Update InvoiceItemDBO
 *
 * @param InvoiceItemDBO &$dbo InvoiceItemDBO to update
 * @return boolean True on success
 */
function update_InvoiceItemDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_update_sql( "invoiceitem",
				"id = " . intval( $dbo->getID() ),
				array( "invoiceid" => intval( $dbo->getInvoiceID() ),
				       "quantity" => $dbo->getQuantity(),
				       "unitamount" => $dbo->getUnitAmount(),
				       "text" => $dbo->getText(),
				       "taxitem" => $dbo->getTaxItem() ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      return false;
    }

  // Update Invoice's outstanding flag
  $dbo->touchInvoice();

  return true;
}

/**
 * Delete InvoiceItemDBO from Database
 *
 * @param InvoiceItemDBO &$dbo InvoiceItemDBO to delete
 * @return boolean True on success
 */
function delete_InvoiceItemDBO( &$dbo )
{
  global $DB;

  // Build SQL
  $sql = $DB->build_delete_sql( "invoiceitem",
				"id = " . intval( $dbo->getID() ) );

  // Run query
  return mysql_query( $sql, $DB->handle() );
}

/**
 * Load InvoiceItemDBO from Database
 *
 * @param integer $id InvoiceItem ID
 * @return InvoiceItemDBO Invoice Item, or null if not found
 */
function load_InvoiceItemDBO( $id )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "invoiceitem",
				"*",
				"id=" . intval( $id ),
				null,
				null,
				null,
				null );

  // Run query
  if( !($result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatal_error( "load_InvoiceItemDBO()",
		   "Attempt to load DBO failed on SELECT" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No rows found
      return null;
    }

  // Load a new HostingServiceDBO
  $dbo = new InvoiceItemDBO();
  $data = mysql_fetch_array( $result );
  $dbo->load( $data );
  
  // Return the new UserDBO
  return $dbo;
}

/**
 * Load multiple InvoiceItemDBO's from database
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return array Array of InvoiceItemDBO's
 */
function &load_array_InvoiceItemDBO( $filter = null,
				     $sortby = null,
				     $sortdir = null,
				     $limit = null,
				     $start = null )
{
  global $DB;

  // Build query
  $sql = $DB->build_select_sql( "invoiceitem",
				"*",
				$filter,
				$sortby,
				$sortdir,
				$limit,
				$start );

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // Query error
      fatal_error( "load_array_InvoiceItemDBO()",
		   "SELECT failure" );
    }

  if( mysql_num_rows( $result ) == 0 )
    {
      // No services found
      return null;
    }

  // Build an array of DBOs from the result set
  $dbo_array = array();
  while( $data = mysql_fetch_array( $result ) )
    {
      // Create and initialize a new DBO with the data from the DB
      $dbo =& new InvoiceItemDBO();
      $dbo->load( $data );

      // Add HostingServiceDBO to array
      $dbo_array[] = $dbo;
    }

  return $dbo_array;
}

/**
 * Count InvoiceItemDBO's
 *
 * Same as load_array_InvoiceDBO, except this function just COUNTs the 
 * number of rows in the database.
 *
 * @param string $filter A WHERE clause
 * @param string $sortby Field name to sort results by
 * @param string $sortdir Direction to sort in (ASEC or DESC)
 * @param int $limit Limit the number of results
 * @param int $start Record number to start the results at
 * @return integer Number of InvoiceItem records
 */
function count_all_InvoiceItemDBO( $filter = null )
{
  global $DB;
  
  // Build query
  $sql = $DB->build_select_sql( "invoiceitem",
				"COUNT(*)",
				$filter,
				null,
				null,
				null,
				null );

  // Run query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      // SQL error
      fatal_error( "count_all_InvoiceItemDBO", "SELECT COUNT failure" );
    }

  // Make sure the number of rows returned is exactly 1
  if( mysql_num_rows( $result ) != 1 )
    {
      // This must return 1 row
      fatal_error( "count_all_InvoiceItemDBO()", "Expected SELECT to return 1 row" );
    }

  $data = mysql_fetch_array( $result );
  return $data[0];
}


?>