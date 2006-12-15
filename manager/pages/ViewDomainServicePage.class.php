<?php
/**
 * ViewDomainServicePage.class.php
 *
 * This file contains the definition for the ViewDomainService Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * ViewDomainServicePage
 *
 * View a domain service.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ViewDomainServicePage extends SolidStatePage
{
  /**
   * Initialize the View Domain Service Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "dservice", $this->get['dservice']->getTLD() );

    // Store service DBO in session
    $this->session['domain_service_dbo'] =& $this->get['dservice'];
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   view_domain_service_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "view_domain_service_action":
	if( isset( $this->post['edit'] ) )
	  {
	    // Edit this Domain Service
	    $this->goto( "services_edit_domain_service",
			 null,
			 "dservice=" . $this->get['dservice']->getTLD() );
	  }
	elseif( isset( $this->post['delete'] ) )
	  {
	    // Delete this Domain Service
	    $this->goto( "services_delete_domain_service",
			 null,
			 "dservice=" . $this->get['dservice']->getTLD() );
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }
}

?>