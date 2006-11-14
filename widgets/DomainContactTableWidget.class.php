<?php
/**
 * DomainContactTableWidget.class.php
 *
 * This file contains the definition of the DomainContactTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DomainContactTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainContactTableWidget extends TableWidget
{
  /**
   * @var OrderDBO The order
   */
  protected $order = null;

  /**
   * Determine Value
   *
   * Note: all elements in this table are checked by default
   */
  public function determineValue( $params ) { return $params['option']; }

  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    if( !isset( $this->order ) || 
	null == ($domains = $this->order->getDomainItems() ) )
      {
	// Nothing to do
	return ;
      }

    // Build the table
    foreach( $domains as $dbo )
      {
	if( $dbo->hasContactInformation() )
	  {
	    // Skip this domain
	    continue;
	  }

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
}