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
   * @var Translator The translator object
   */
  protected $translator;

  /**
   * @var array A stack of tags being processed
   */
  protected $tag_stack;

  /**
   * @var integer The size of the tag stack
   */
  protected $tagStackSize = 0;

  /**
   * @var string The Phrase being processed
   */
  protected $phrase_id;

  /**
   * @var string Translation data
   */
  protected $data = null;

  /**
   * Load Translation File
   *
   * Loads and parses a translation file
   *
   * @param string $file Path to the translations file
   * @return array Configuration data
   */
  public static function load( $file )
  {
    $xml_parser = xml_parser_create();
    $translation_parser = new TranslationParser();
    xml_set_object( $xml_parser, $translation_parser );
    xml_set_element_handler( $xml_parser, "startElement", "endElement" );
    xml_set_character_data_handler( $xml_parser, "characterData" );
    
    if( !($fp = @fopen( $file, "r" )) )
      {
	throw new SWException( "Could not load translation file: " . $file );
      }
    
    while( $data = fread( $fp, 4096 ) )
      {
	if( !xml_parse( $xml_parser, $data, feof( $fp ) ) )
	  {
	    throw new SWException( sprintf( "<pre>There is an error in your translations file:\n %s at line %d</pre>",
					    xml_error_string( xml_get_error_code( $xml_parser ) ),
					    xml_get_current_line_number( $xml_parser ) ) );
	  }
      }
    fclose( $fp );
    
    xml_parser_free( $xml_parser );
  }


  /**
   * Translation Parser Constructor
   */
  public function __construct()
  {
    // Get access to the Translator
    $this->translator = Translator::getTranslator();
  }

  /**
   * Start element
   *
   * Called by the XML parser for a begin-tag
   *
   * @param object $parser
   * @param string $tagName The name of the tag being processed
   * @param array $attrs An array of attributes provided for the tag
   */
  public function startElement( $parser, $tagName, $attrs )
  {
    $this->tag_stack[] = $tagName;
    $this->tagStackSize++;
    switch( $tagName )
      {
      case "TRANSLATIONS":
	if( isset( $attrs['DEFAULT_LANGUAGE'] ) )
	  {
	    $this->translator->setDefaultLanguage( $attrs['DEFAULT_LANGUAGE'] );
	  }
	break;

      case "TRANSLATION":
	$this->translator->setActiveLanguage( $attrs['LANGUAGE'] );
	break;

      case "PHRASE":
	$this->phrase_id = $attrs['ID'];
	$this->data = null;
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
    $this->tagStackSize--;
    switch( $tagName )
      {
      case "TRANSLATION":
	unset( $this->language );
	break;

      case "PHRASE":
	$this->translator->registerTranslation( $this->phrase_id, $this->data );
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
    /*
    switch( $this->tag_stack[$this->tagStackSize - 1] )
      {
      case "PHRASE":
	$this->data .= $data;
	break;
      
      }
    */
    $this->data .= $data; // Assume "PHRASE"
  }
}
?>