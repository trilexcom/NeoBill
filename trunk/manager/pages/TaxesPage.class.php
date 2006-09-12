<?php
/**
 * TaxesPage.class.php
 *
 * This file contains the definition for the Taxes Page class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require_once $base_path . "solidworks/Page.class.php";

// TaxRuleDBO class
require_once $base_path . "DBO/TaxRuleDBO.class.php";

/**
 * TaxesPage
 *
 * Display all Taxes
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TaxesPage extends Page
{
  /**
   * Action
   *
   * Actions handled by this page:
   *   browse_taxes_action (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "taxes_action":
	// Create a new tax rule
	$this->goto( "add_tax_rule" );
	break;

      case "remove":
	$this->remove();
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Remove Tax Rule
   */
  function remove()
  {
    if( $_SESSION['client']['userdbo']->getType() != "Administrator" )
      {
	$this->setError( array( "type" => "ACCESS_DENIED" ) );
	return;
      }

    // Access the Tax Rule DBO
    $id = intval( form_field_filter( null, $_GET['id'] ) );
    if( ($taxrule_dbo = load_TaxRuleDBO( $id )) == null )
      {
	fatal_error( "TaxesPage::remove()", "That tax rule does not exist: " . $id );
      }

    // Remove the Tax Rule from the database
    if( !delete_TaxRuleDBO( $taxrule_dbo ) )
      {
	$this->setError( array( "type" => "DB_DELETE_TAX_RULE_FAILED",
				"args" => array( $id ) ) );
	return;
      }

    // Success
    $this->setMessage( array( "type" => "TAX_RULE_DELETED" ) );
  }
}

?>