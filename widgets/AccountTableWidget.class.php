<?php
/**
 * AccountTableWidget.class.php
 *
 * This file contains the definition of the AccountTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * AccountTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AccountTableWidget extends TableWidget
{
  /**
   * @var string Account status filter
   */
  private $statusFilter = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Build an account filter
    $where = isset( $this->statusFilter ) ? 
      sprintf( "status='%s'", $this->statusFilter ) : null;

    // Load the Account Table
    if( null != ($accounts = load_array_AccountDBO( $where )) )
      {
	// Build the table
	foreach( $accounts as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "id" => $dbo->getID(),
		     "accountname" => $dbo->getAccountName(),
		     "type" => $dbo->getType(),
		     "status" => $dbo->getStatus(),
		     "balance" => $dbo->getBalance(),
		     "billingstatus" => $dbo->getBillingStatus(),
		     "billingday" => $dbo->getBillingDay(),
		     "businessname" => $dbo->getBusinessName(),
		     "contactname" => $dbo->getContactName(),
		     "contactemail" => $dbo->getContactEmail() );
	  }
      }
  }

  /**
   * Set Account Status Filter
   *
   * @param string $status Account status
   */
  public function setStatus( $status )
  {
    $this->statusFilter = $status;
  }
}