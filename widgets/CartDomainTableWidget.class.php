<?php
/**
 * CartDomainTableWidget.class.php
 *
 * This file contains the definition of the CartDomainTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/TableWidget.class.php";

/**
 * CartDomainTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CartDomainTableWidget extends TableWidget
{
  /**
   * @var boolean When true, show "existing domains" only
   */
  protected $existingDomainsFlag = false;

  /**
   * @var OrderDBO The order
   */
  protected $order = null;

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    if( !isset( $this->order ) || 
	null == ($domains = $this->existingDomainsFlag ? 
		 $this->order->getExistingDomains() : $this->order->getDomainItems() ) )
      {
	// Nothing to do
	return ;
      }

    // Build the table
    foreach( $domains as $dbo )
      {
	// Put the row into the table
	$this->data[] = 
	  array( "orderitemid" => $dbo->getOrderItemID(),
		 "domainname" => $dbo->getFullDomainName() );
      }
  }

  /**
   * Set Order
   *
   * @param OrderDBO $order The order to be displayed
   */
  function setOrder( OrderDBO $order ) { $this->order = $order; }

  /**
   * Show Existing Domains
   */
  public function showExistingDomains() { $this->existingDomainsFlag = true; }
}