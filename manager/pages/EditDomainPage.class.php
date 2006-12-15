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
   * Initialize the Edit Domain Page
   */
  function init()
  {
    parent::init();

    // Set URL Field
    $this->setURLField( "dpurchase", $this->get['dpurchase']->getID() );

    // Store DBO in session
    $this->session['domain_dbo'] =& $this->get['dpurchase'];
  }

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
    $this->get['dpurchase']->setDomainName( $this->post['domainname'] );
    $this->get['dpurchase']->setTLD( $this->post['tld']->getTLD() );
    $this->get['dpurchase']->setTerm( $this->post['term'] );
    $this->get['dpurchase']->setDate( $this->DB->format_datetime( $this->post['date'] ) );
    if( !update_DomainServicePurchaseDBO( $this->get['dpurchase'] ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_PURCHASE_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Success!
    $this->setMessage( array( "type" => "DOMAIN_SERVICE_PURCHASE_UPDATED" ) );
    $this->goback();
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
    $this->get['dpurchase']->setDate( $this->DB->format_datetime( $this->post['date'] ) );
    $this->get['dpurchase']->setTerm( $this->post['term'] );
    if( !update_DomainServicePurchaseDBO( $this->get['dpurchase'] ) )
      {
	// Update error
	$this->setError( array( "type" => "DB_DOMAIN_SERVICE_PURCHASE_UPDATE_FAILED" ) );
	$this->reload();
      }

    // Update Registrar (but only if the "contact registrar" box was checked)
    if( $this->post['registrar'] )
      {
	try
	  {
	    $module->renewDomain( $this->get['dpurchase'], 
				  $this->get['dpurchase']->getTermInt() );
	  }
	catch( RegistrarException $e )
	  {
	    // Renew error
	    $this->setError( array( "type" => $e->getMessage() ) );
	    $this->goback();
	  }
      }

    // Success!
    $this->setMessage( array( "type" => "DOMAIN_RENEWED" ) );
    $this->goback();
  }
}

?>