<?php
/**
 * LanguageSelectWidget.class.php
 *
 * This file contains the definition of the LanguageSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// DOMAINTERM Service DBO
require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

/**
 * LanguageSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class LanguageSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  function getData()
  {
    $translator = Translator::getTranslator();
    return array_combine( $translator->getLanguages(), $translator->getLanguages() );
  }
}
?>