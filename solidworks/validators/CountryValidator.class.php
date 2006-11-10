<?php
/**
 * CountryValidator.class.php
 *
 * This file contains the definition of the CountryValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * CountryValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CountryValidator extends ChoiceValidator
{
  /**
   * Get Valid Choices
   *
   * Returns an array of values that are considered valid for this choice
   *
   * @return array An array of valid choices
   */
  function getValidChoices()
  {
    global $cc;
    return array_keys( $cc );
  }
}
?>