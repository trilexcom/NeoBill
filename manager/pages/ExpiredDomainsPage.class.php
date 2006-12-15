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
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ExpiredDomainsPage
 *
 * Display all Expired domains
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ExpiredDomainsPage extends SolidStatePage
{
  /**
   * Initialize Expired Domains Page
   *
   * Tell the DBO table to filter based on an expire date before today's date
   */
  function init()
  {
    parent::init();

    // Only show expired domains
    $this->forms['expired_domains']->getField( "domains" )->getWidget()->showExpiredDomainsOnly();
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
      case "search_expired_domains":
	$this->searchTable( "expired_domains", "domains", $this->post );
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}
?>