<?php
/**
 * LanguageValidator.class.php
 *
 * This file contains the definition of the LanguageValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/validators/ChoiceValidator.class.php";

/**
 * LanguageValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LanguageValidator extends ChoiceValidator
{
  /**
   * Get Valid Choices
   *
   * Returns all the valid languages
   *
   * @return array An array of valid language choices
   */
  function getValidChoices()
  {
    $translator = Translator::getTranslator();
    return array_combine( $translator->getLanguages(), $translator->getLanguages() );
  }
}
?>