<?php
/**
 * ExpiredDomainsPage.class.php
 *
 * This file contains the definition for the ExpiredDomainsPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// InvoiceDBO class
require_once $base_path . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * ExpiredDomainsPage
 *
 * Display all Expired domains
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ExpiredDomainsPage extends Page
{
  /**
   * Initialize Expired Domains Page
   *
   * Tell the DBO table to filter based on an expire date before today's date
   */
  function init()
  {
    // Only show expired domains
    $this->session['domaindbo_table_properties']['filter'] = 
      "UNIX_TIMESTAMP(expiredate) < UNIX_TIMESTAMP(NOW())";
  }

  /**
   * Actions
   *
   * Actions handled by this page:
   *   none
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {

      default:
	
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }
}

?>
