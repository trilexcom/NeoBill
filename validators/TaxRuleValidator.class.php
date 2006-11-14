<?php
/**
 * TaxRuleValidator.class.php
 *
 * This file contains the definition of the TaxRuleValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * TaxRuleValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TaxRuleValidator extends FieldValidator
{
  /**
   * Validate a TaxRule ID
   *
   * Verifies that the TaxRule exists.
   *
   * @param string $data Field data
   * @return TaxRuleDBO TaxRule DBO for this TaxRule ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($taxRuleDBO = load_TaxRuleDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "TaxRule" );
      }

    return $taxRuleDBO;
  }
}
?>