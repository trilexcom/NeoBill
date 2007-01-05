<?
/**
 * EditDomainPage.class.php
 *
 * This file contains the definition for the EditDomainPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * EditDomainPage
 *
 * Edit a domain registration purchase
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EditDomainPage extends SolidStatePage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   edit_domain (form)
   *   renew_domain (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "edit_domain":
	if( isset( $this->post['continue'] ) )
	  {
	    $this->edit_domain();
	  }
	elseif( isset( $this->post['cancel'] ) )
	  {
	    $this->goback();
	  }
	break;

      case "renew_domain":
	if( isset( $this->post['continue'] ) )
	  {
	    $this->renew_domain();
	  }
	break;

      default:
	// No matching action - refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Edit Domain
   *
   * Take the changes from the form and store them in the DBO.  Then update the
   * DBO in the database.
   */
  function edit_domain()
  {
    // Update DBO
    $this->get['dpurchase']->setTerm( $this->post['term'] ?
				      $this->post['term']->getTermLength() : null );
    $this->get['dpurchase']->setNextBillingDate( DBConnection::format_datetime( $this->post['nextbillingdate'] ) );
    update_DomainServicePurchaseDBO( $this->get['dpurchase'] );

    // Success!
    $this->setMessage( array( "type" => "[DOMAIN_SERVICE_PURCHASE_UPDATED]" ) );
    $this->goback();
  }

  /**
   * Initialize the Edit Domain Page
   */
  function init()
  {
    parent::init();

    // Set URL Field
    $this->setURLField( "dpurchase", $this->get['dpurchase']->getID() );

    // Store DBO in session
    $this->smarty->assign_by_ref( "domainDBO", $this->get['dpurchase'] );

    try 
      { 
	$widget = $this->forms['edit_domain']->getField( "term" )->getWidget();
	$widget->setPurchasable( $this->get['dpurchase']->getPurchasable() );

	$widget = $this->forms['renew_domain']->getField( "term" )->getWidget();
	$widget->setPurchasable( $this->get['dpurchase']->getPurchasable() );
      }
    catch( DBNoRowsFoundException $e )
      {
	throw new SWUserException( "[THERE_ARE_NO_DOMAIN_SERVICES]" );
      }
  }

  /**
   * Renew Domain
   *
   * Set the DomainServucePurchase date to the date provided in the form, then update
   * the DomainServicePurchaseDBO in the database
   */
  function renew_domain()
  {
    $registry = ModuleRegistry::getModuleRegistry();
    if( !($module = $registry->getModule( $this->get['dpurchase']->getModuleName() )) )
      {
	throw new SWException( "Failed to load registrar module: " .
			       $this->get['dpurchase']->getModuleName() );
      }

    // Update DBO
    $this->get['dpurchase']->setDate( DBConnection::format_datetime( $this->post['date'] ) );
    $this->get['dpurchase']->setTerm( $this->post['term'] ?
				      $this->post['term']->getTermLength() : null );
    update_DomainServicePurchaseDBO( $this->get['dpurchase'] );

    // Update Registrar (but only if the "contact registrar" box was checked)
    if( $this->post['registrar'] )
      {
	$module->renewDomain( $this->get['dpurchase'], 
			      $this->get['dpurchase']->getTerm() );
      }

    // Success!
    $this->setMessage( array( "type" => "[DOMAIN_RENEWED]" ) );
    $this->goback();
  }
}

?>