<?php
/**
 * DateWidget.class.php
 *
 * This file contains the definition of the DateWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DateWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DateWidget extends TextWidget
{
  /**
   * @var boolean This flag indicates wether the javascript for the calendar link has been included or not
   */
  public static $jsFlag = false;

  /**
   * @var string Date input format: MDY or DMY
   */
  private $format = "MDY";

  /**
   * Date Widget Constructor
   *
   * @param Page $page Page object
   * @param string $format Date input format: MDY or DMY
   */
  public function __construct( $formName, $fieldName, $fieldConfig, $format = "MDY" )
  {
    parent::__construct( $formName, $fieldName, $fieldConfig );
    $this->setFormat( $format );
  }

  /**
   * Determine Widget Value
   *
   * Determines the correct source to use for the value of this widget and
   * format that value as such: MM-DD-YYYY or DD-MM-YYYY
   * The order goes like this:
   *   5. No value
   *   4. The default value set in the config file
   *   3. The value given by the 'value' parameter of the {form_field} tag
   *   2. The value of this field in the specified DBO
   *   1. The value as entered by the user
   *
   * @param array $params Paramets passed from the template
   * @throws SWException
   * @return string The value to use
   */
  protected function determineValue( $params )
  {
    global $DB;
    $value = parent::determineValue( $params );
    if( is_string( $value ) )
      {
	$tsValue = strlen( $value ) > 10 ? 
	  $DB->datetime_to_unix( $value ) : $DB->date_to_unix( $value );
      }
    else
      {
	$tsValue = $value;
      }

    return $this->TS2Date( $tsValue == null ? time() : $tsValue );
  }

  /**
   * Format a Date String from a Time Stamp
   *
   * Takes a unix timestamp value and format it as MM-DD-YYYY or DD-MM-YYYY
   *
   * @param integer $ts Time stamp
   * @return string Date string
   */
  function TS2Date( $ts )
  {
    $date = getdate( $ts );
    return $this->getFormat() == "MDY" ?
      sprintf( "%d/%d/%d", $date['mon'], $date['mday'], $date['year'] ) :
      sprintf( "%d/%d/%d", $date['mday'], $date['mon'], $date['year'] );
  }

  /**
   * Get Date Input Format
   *
   * @return string Date input format: MDY or DMY
   */
  public function getFormat() { return $this->format; }

  /**
   * Get Widget HTML
   *
   * Returns HTML code for this widget
   *
   * @param array $params Parameters passed from the template
   * @return string HTML code for this widget
   */
  public function getHTML( $params ) 
  {
    // Get widget value if available
    $myParams['value'] = $this->determineValue( $params );

    // If this is the first calendar widget, add code to include the javascript
    // for the calendar window
    if( !self::$jsFlag )
      {
	$js = "\n<script language=\"Javascript\" src=\"../solidworks/widgets/popupcalendar/calendar.js\"></script>\n";
	self::$jsFlag = true;
      }
    else
      {
	$js = null;
      }

    // Create HTML for the calendar pop-up link
    $calHTML = 
      sprintf( "<a href=\"#\" onclick=\"return getCalendar(document.%s.%s);\">",
	       $this->formName,
	       $this->fieldName ) .
      "<img src=\"../solidworks/widgets/popupcalendar/calendar.png\" border=\"0\" />" .
      "</a>";

    // Generate HTML for a text box control
    $myParams['type'] = "text";
    $myParams['size'] = 10;
    return $js . "<input " . $this->buildParams( $params, $myParams ) . "/> " . $calHTML;
  }

  /**
   * Set Date Input Format
   *
   * @param string $format Date input format: MDY or DMY
   * @throws InvalidDateInputFormat
   */
  public function setFormat( $format )
  {
    if( !($format == "MDY" || $format == "DMY") )
      {
	throw new InvalidDateInputFormatException( $format );
      }

    $this->format = $format;
  }
}
?>