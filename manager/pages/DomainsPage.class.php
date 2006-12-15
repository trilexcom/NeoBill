<?php
/**
 * DomainsPage.class.php
 *
 * This file contains the definition for the DomainsPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

require BASE_PATH . "util/domains.php";

/**
 * Domains Summary Page
 *
 * This class handles the Domains Summary Page.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainsPage extends SolidStatePage
{
  /**
   * Provides statistics to the template
   */
  function init()
  {
    parent::init();

    // Get stats
    $stats = domain_stats();

    // Put stats on the page
    $this->smarty->assign( "domains_count",         $stats['domains_count'] );
    $this->smarty->assign( "expired_domains_count", $stats['expired_domains_count'] );
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