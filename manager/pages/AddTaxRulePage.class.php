<?php
/**
 * AddTaxRulePage.class.php
 *
 * This file contains the definition for the AddTaxRulePage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * AddTaxRulePage
 *
 * Add a new Tax Rule
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddTaxRulePage extends SolidStateAdminPage
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   new_tax_rule (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "new_tax_rule":
	if( isset( $this->post['continue'] ) )
	  {
	    $this->addTaxRule();
	  }
	else
	  {
	    $this->cancel();
	  }
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );

      }
  }

  /**
   * Cancel
   */
  function cancel()
  {
    $this->goback();
  }

  /**
   * Add Tax Rule
   */
  function addTaxRule()
  {
    if( $this->post['allstates'] == "true" )
      {
	$this->post['state'] = null;
      }
    else
      {
	if( !isset( $this->post['state'] ) )
	  {
	    // A specific state was not provided
	    $this->setError( array( "type" => "FIELD_MISSING",
				    "args" => array( "[STATE]" ) ) );
	    $this->reload();
	  }
      }

    // Create a new Tax Rule DBO
    $taxrule_dbo = new TaxRuleDBO();
    $taxrule_dbo->setCountry( $this->post['country'] );
    $taxrule_dbo->setState( $this->post['state'] );
    $taxrule_dbo->setRate( $this->post['rate'] );
    $taxrule_dbo->setAllStates( $this->post['allstates'] == "true" ? "Yes" : "Specific"  );
    $taxrule_dbo->setDescription( $this->post['description'] );

    // Insert Tax Rule into database
    if( !add_TaxRuleDBO( $taxrule_dbo ) )
      {
	// Add failed
	$this->setError( array( "type" => "DB_ADD_TAX_RULE_FAILED" ) );
	$this->cancel();
      }

    // Success
    $this->setMessage( array( "type" => "TAX_RULE_CREATED" ) );
    $this->cancel();
  }
}

?>