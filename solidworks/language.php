<?php
/**
 * language.php
 *
 * This file contains functions related to multi-language support
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Translate
 *
 * Returns the correct translation for a given phrase and language.
 *
 * @param string $langauge The language to return the phrase in
 * @param string $phrase_id The phrase to translate
 * @return string The phrase in the language specified
 */
function translate( $language, $phrase_id )
{
  global $translations;

  $default_language = $translations['default_language'];

  $phrase = $translations[$language][$phrase_id];
  $default_phrase = $translations[$default_language][$phrase_id];

  if( !isset( $phrase ) && !isset( $default_phrase ) )
    {
      return "No translation available for the given phrase_id: " . $phrase_id;
    }
  else
    {
      return isset( $phrase ) ? $phrase : $default_phrase;
    }

}

/**
 * Translate String
 *
 * Searches a string for any phrase id's contained between '[' and ']' characters,
 * and returns the string with the translation of that phrase for the given language.
 *
 * @param string $langauge The language to return the phrases in
 * @param string $string The string to parse
 * @return string The string in the language specified
 */
function translate_string( $language, $string )
{
  // Translate all the phrases in the string
  $begin_phrase_pos = strpos( $string, "[" );
  while( $begin_phrase_pos !== false )
    {
      // Point to the beginning of the phrase ID
      $begin_phrase_pos++;

      // Point at the end of the phrase ID
      if( ($end_phrase_pos = strpos( $string, "]" )) === false )
	{
	  // Found an opening bracket but not an end bracket
	  break;
	}

      // Compute the length of the phrase ID
      $len = $end_phrase_pos - $begin_phrase_pos;

      // Extract the phrase ID
      $phrase = substr( $string, $begin_phrase_pos, $len );

      // Replace the phrase with it's translation
      $string = str_replace( "[" . $phrase . "]",
			     translate( $language, $phrase ),
			     $string );

      // Find the next phrase ID
      $begin_phrase_pos = strpos( $string, "[" );
    }

  return $string;
}

?>
