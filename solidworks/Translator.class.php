<?php
/**
 * Translator.class.php
 *
 * This file contains the definition for the Translator class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Exceptions
require_once BASE_PATH . "solidworks/exceptions/DuplicateTranslationException.class.php";

/**
 * Translator
 *
 * Handles multi-language support for SolidWorks
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class Translator
{
  /**
   * @var Translator Singleton instance for the Translator object
   */
  private static $instance = null;

  /**
   * @var string The language to translate into
   */
  private $activeLanguage = "english";

  /**
   * @var string The default language to translate into
   */
  private $defaultLanguage = "english";

  /**
   * @var array Phrase translations in the form: language => phrase id => translation
   */
  private $translations = array();

  /**
   * Get Translator
   *
   * Provides access to the Translator singleton
   *
   * @return Translator The translator object
   */
  public static function getTranslator()
  {
    if( self::$instance == null )
      {
	self::$instance = new Translator();
      }

    return self::$instance;
  }

  /**
   * Smarty Output Filter/Translator
   *
   *
   * This output filter is invoked by Smarty whenever the display() method is invoked
   * to output the template.  It scans the output and replaces all phrases in the
   * form: [PHRASE_ID] with the translation for the active language.  If a translation
   * under the active language does not exist, the default language is used instead.
   *
   * @param string $output The template output
   * @param Smarty &$smarty The smarty object
   * @return string Template output with translated phrases
   */
  public static function filter( $output, &$smarty )
  {
    $translator = self::getTranslator();
    return $translator->translateString( $output );
  }

  /**
   * Translator Constructor
   *
   * Translator is a singleton - it must be instantiate through Translator::getTranslator().
   */
  private function __construct() { }

  /**
   * Get Languages
   *
   * @return array A list of installed languages
   */
  function getLanguages() { return array_keys( $this->translations ); }

  /**
   * Register a Translation
   *
   * @param string $phraseid The phrase id this translation is for
   * @param string $translation The translation text
   * @param string $language The language this translation is in
   * @throws DuplicateTranslationException
   */
  public function registerTranslation( $phraseid, $translation, $language = null )
  {
    $language = ($language == null) ? $this->activeLanguage : $language;

    // Check for duplicates
    if( isset( $this->translations[$language][$phraseid] ) )
      {
	throw new DuplicateTranslationException( $language, 
						 $phraseid,
						 $translation );
      }

    // Register the new translation
    $this->translations[$language][$phraseid] = $translation;
  }

  /**
   * Set Active Language
   *
   * @param string Active language
   */
  public function setActiveLanguage( $language )
  {
    $this->activeLanguage = strtolower( $language );
  }

  /**
   * Set Default Language
   *
   * @param string Default language
   */
  public function setDefaultLanguage( $language )
  {
    $this->defaultLanguage = strtolower( $language );
  }

  /**
   * Translate
   *
   * @param string $phraseid The phrase to translate
   * @param string $language The language to translate to (optional, if not given the active language is used)
   * @return string The translation (or an error message)
   */
  public function translate( $phraseid, $language = null )
  {
    $language = ($language == null) ? $this->activeLanguage : $language;

    if( !isset( $this->translations[$language][$phraseid] ) &&
	!isset( $this->translations[$this->defaultLanguage][$phraseid] ) )
      {
	return $phraseid;
	//return sprintf( "(No translation for: %s)", $phraseid );
      }

    return isset( $this->translations[$language][$phraseid] ) ?
      $this->translations[$language][$phraseid] :
      $this->translations[$this->defaultLanguage][$phraseid];
  }
  
  /**
   * Translate String
   *
   * Searches a string for any phrase id's contained between '[' and ']' characters,
   * and returns the string with the translation of that phrase for the given language.
   *
   * @param string $string The string to parse
   * @param string $langauge The language to return the phrases in
   * @return string The string in the language specified
   * @throws SWException
   */
  public function translateString( $string, $language = null )
  {
    $language = ($language == null) ? $this->activeLanguage : $language;

    // Translate all the phrases in the string
    $result = "";
    $beginPhrasePos = strpos( $string, "[" );
    while( $beginPhrasePos !== false )
      {
	// Point to the beginning of the phrase ID
	$beginPhrasePos++;
	
	// Point at the end of the phrase ID
	if( ($endPhrasePos = strpos( $string, "]" )) === false )
	  {
	    // Found an opening bracket but not an end bracket
	    throw new SWException( "Parse error: expected to find a ']' but none was found" );
	  }
	
	// Compute the length of the phrase ID
	$len = $endPhrasePos - $beginPhrasePos;
	
	// Extract the phrase ID
	$phrase = substr( $string, $beginPhrasePos, $len );

	// Replace the phrase with it's translation
	if( strlen( $phrase ) > 0 )
	  {
	    $string = str_replace( "[" . $phrase . "]",
				   $this->translate( $phrase, $language ),
				   $string );
	  }
	else
	  {
	    $string = str_replace( "[]", "&#91;&#93;", $string );
	  }

	// Find the next phrase ID
	$beginPhrasePos = strpos( $string, "[" );
      }
    
    return str_replace( "&#91;&#93;", "[]", $string );
}

}