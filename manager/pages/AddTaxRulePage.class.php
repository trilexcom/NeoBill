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
require_once $base_path . "solidworks/AdminPage.class.php";

// TaxRuleDBO class
require_once $base_path . "DBO/TaxRuleDBO.class.php";

/**
 * AddTaxRulePage
 *
 * Add a new Tax Rule
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddTaxRulePage extends AdminPage
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
	if( isset( $this->session['new_tax_rule']['continue'] ) )
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
    $this->goto( "taxes" );
  }

  /**
   * Add Tax Rule
   */
  function addTaxRule()
  {
    if( $this->session['new_tax_rule']['allstates'] )
      {
	$this->session['new_tax_rule']['allstates'] = "Yes";
	$this->session['new_tax_rule']['state'] = null;
      }
    else
      {
	if( !isset( $this->session['new_tax_rule']['state'] ) )
	  {
	    // A specific state was not provided
	    $this->setError( array( "type" => "FIELD_MISSING",
				    "args" => array( "[STATE]" ) ) );
	    $this->goback(1);
	  }
      }

    // Create a new Tax Rule DBO
    $taxrule_dbo = new TaxRuleDBO();
    $taxrule_dbo->setCountry( $this->session['new_tax_rule']['country'] );
    $taxrule_dbo->setState( $this->session['new_tax_rule']['state'] );
    $taxrule_dbo->setRate( $this->session['new_tax_rule']['rate'] );
    $taxrule_dbo->setAllStates( $this->session['new_tax_rule']['allstates'] ? 
				"Yes" : "Specific"  );
    $taxrule_dbo->setDescription( $this->session['new_tax_rule']['description'] );

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