<?php
/**
 * DuplicateTranslationException.class.php
 *
 * This file contains the definition of the DuplicateTranslationException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/SWException.class.php";

// Translator class
require_once BASE_PATH . "solidworks/Translator.class.php";

/**
 * DuplicateTranslationException
 *
 * DuplicateTranslation exception's are thrown by the Translator whenever an
 * attempt is made to register a translation for a phrase id that already exists.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DuplicateTranslationException extends SWException
{
  /**
   * @var string The internal error message for this exception
   */
  protected $message = "Attempted to register a duplicate translation.\n\tLanguage: %s\n\tPhrase id: %s\n\tCurrent translation: %s\n\tDuplicate translation: %s\n";

  /**
   * DuplicateTranslationException Constructor
   *
   * @param string $language The language the translation is for
   * @param string $phraseid The phrase id for the translation
   * @param string $duplicate The duplicate translation
   */
  public function __construct( $language, $phraseid, $translation )
  {
    // Let the parent set us up
    parent::__construct();

    // Access the translator
    $translator = Translator::getTranslator();

    // Complete the error message
    $this->message = sprintf( $this->message, 
			      $language, 
			      $phraseid,
			      $translator->translate( $phraseid, $language ),
			      $translation );
  }
}
?>