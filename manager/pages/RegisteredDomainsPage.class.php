<?php
/**
 * RegisteredDomainsPage.class.php
 *
 * This file contains the definition for the RegisteredDomainsPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "solidworks/Page.class.php";

// InvoiceDBO class
require_once BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";

/**
 * RegisteredDomainsPage
 *
 * Display all Registered domains
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RegisteredDomainsPage extends Page
{
  /**
   * Initialize Registered Domains Page
   *
   * Sets up the domaindbo table to filter out expired domains.
   */
  function init()
  {
    // Filter out expired domains
    $this->session['domaindbo_table_properties']['filter'] = 
      "UNIX_TIMESTAMP(expiredate) > UNIX_TIMESTAMP(NOW())";
  }

  /**
   * Action
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