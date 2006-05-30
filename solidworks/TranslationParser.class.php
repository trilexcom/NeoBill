<?php
/**
 * TranslationParser.class.php
 *
 * This file contains the definition for the TranslationParser class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * TranslationParser
 *
 * Implements an XML parser for the translation/language file.  After
 * parsing, the translations are stored into a PHP array.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TranslationParser
{
  /**
   * @var array Translations
   */
  var $translations;

  /**
   * @var array A stack of tags being processed
   */
  var $tag_stack;

  /**
   * @var string The language being processed
   */
  var $language;

  /**
   * @var string The Phrase being processed
   */
  var $phrase_id;

  /**
   * Start element
   *
   * Called by the XML parser for a begin-tag
   *
   * @param object $parser
   * @param string $tagName The name of the tag being processed
   * @param array $attrs An array of attributes provided for the tag
   */
  function startElement( $parser, $tagName, $attrs )
  {
    $this->tag_stack[] = $tagName;
    switch( $tagName )
      {
      case "TRANSLATIONS":
	$this->translations = array();
	$this->translations['default_language'] = $attrs['DEFAULT_LANGUAGE'];
	break;

      case "TRANSLATION":
	$this->language = $attrs['LANGUAGE'];
	$this->translations[$this->language] = array();
	break;

      case "PHRASE":
	$this->phrase_id = $attrs['ID'];
	$this->translation[$this->language][$this->phrase_id] = "";
	break;

      default:
	echo "unrecognized tag: " . $tagName . "\n";
	break;
      }
  }

  /**
   * End Element
   *
   * Process the end of an element.
   *
   * @param object $parser
   * @param string $tagName The tag being closed
   */
  function endElement( $parser, $tagName )
  {
    array_pop( $this->tag_stack );
    switch( $tagName )
      {
      case "TRANSLATION":
	unset( $this->language );
	break;

      case "PHRASE":
	unset( $this->phrase_id );
	break;
      }
  }

  /**
   * Process Character Data
   *
   * Process the character data that appears between tags.
   *
   * @param object $parser
   * @param string $data Character data
   */
  function characterData( $parser, $data )
  {
    $tag_name = $this->tag_stack[count( $this->tag_stack ) - 1];
    switch( $tag_name )
      {
      case "PHRASE":
	$this->translations[$this->language][$this->phrase_id] .= $data;
	break;
      }
  }

  /**
   * Get Translations
   *
   * Returns a copy of the translations array
   *
   * @return array Translations
   */
  function getTranslations() { return $this->translations; }
}