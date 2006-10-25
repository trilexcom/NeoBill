<?php
/**
 * EditHostingServicePage.class.php
 *
 * This file contains the definition for the Edit Hosting Service Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * EditHostingServicePage
 *
 * Edit a hosting service offered by the provider
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditHostingServicePage extends SolidStateAdminPage
{
  /**
   * Initialize the Edit Hosting Service Page
   */
  function init()
  {
    parent::init();

    // Set URL Fields
    $this->setURLField( "hservice", $this->get['hservice']->getID() );

    // Store service DBO in session
    $this->session['hosting_dbo'] =& $this->get['hservice'];
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_hosting (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_hosting":
	if( isset( $this->post['save'] ) )
	  {
	    // Save changes
	    $this->update_hosting_service();
	    $this->goback();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    // Cancel (return to view page)
	    $this->goback();
	  }

	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Update Hosting Service
   *
   * Place the changes from the form into the HostingServiceDBO and update the database.
   */
  function update_hosting_service()
  {
    // Update DBO
    $this->get['hservice']->setTitle( $this->post['title'] );
    $this->get['hservice']->setDescription( $this->post['description'] );
    $this->get['hservice']->setUniqueIP( $this->post['uniqueip'] );
    $this->get['hservice']->setSetupPrice1mo( $this->post['setupprice1mo'] );
    $this->get['hservice']->setPrice1mo( $this->post['price1mo'] );
    $this->get['hservice']->setSetupPrice3mo( $this->post['setupprice3mo'] );
    $this->get['hservice']->setPrice3mo( $this->post['price3mo'] );
    $this->get['hservice']->setSetupPrice6mo( $this->post['setupprice6mo'] );
    $this->get['hservice']->setPrice6mo( $this->post['price6mo'] );
    $this->get['hservice']->setSetupPrice12mo( $this->post['setupprice12mo'] );
    $this->get['hservice']->setPrice12mo( $this->post['price12mo'] );
    $this->get['hservice']->setTaxable( $this->post['taxable'] );
    if( !update_HostingServiceDBO( $this->get['hservice'] ) )
      {
	// Error
	throw new SWException( "Could not update hosting service!" );
      }
  }
}

?>