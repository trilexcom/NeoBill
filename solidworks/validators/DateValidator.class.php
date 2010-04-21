<?php
/**
 * DateValidator.class.php
 *
 * This file contains the definition of the DateValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Exceptions
require BASE_PATH . "solidworks/widgets/InvalidDateInputFormatException.class.php";
require BASE_PATH . "solidworks/exceptions/InvalidDateException.class.php";

/**
 * DateValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DateValidator extends TextValidator
{
  /**
   * @var string Date input format: MDY or DMY
   */
  private $format = "MDY";

  /**
   * Date Widget Constructor
   *
   * @param string $formName The name of the form this widget belongs to
   * @param string $fieldName The name of the field this widget represents
   * @param array $fieldConfig The configuration for this field
   * @param string $format Date input format: MDY or DMY
   */
  public function __construct( $formName, $fieldName, $fieldConfig, $format = "MDY" )
  {
    parent::__construct( $formName, $fieldName, $fieldConfig );
    $this->setFormat( $format );
  }

  /**
   * Get Date Input Format
   *
   * @return string Date input format: MDY or DMY
   */
  public function getFormat() { return $this->format; }

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

  /**
   * Validate a Date Field
   *
   * Date's may only contain numbers, seperated by a '/' or a '-', be in one of
   * the following formats: MM/DD/YYYY, DD/MM/YYYY (the year may also be 2 digits
   * instead of 4), and must be a legal date.
   *
   * @param string $data Field data
   * @return int Date as a timestamp value
   * @throws InvalidDateException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );
    $data = $this->validateDate( $data );
    return $data;
  }

  /**
   * Validate a Date
   *
   * @param string $data Field data
   * @return string This function may alter data before validating it, if so this is the result
   * @throws InvalidDateException
   */
  protected function validateDate( $data )
  {
    // Strip out white space and valid characters: '/' and '-'
    $data = preg_replace( "|([ 	]+)|", "", $data );
    $data = preg_replace("|[-/]|", " ", $data );

    // Explode the date into an array
    $components = explode( " ", $data );
    if( !$components || count( $components ) != 3 )
      {
	throw new InvalidDateException();
      }

    // Verify that the components are all numerical
    if( !ctype_digit( $components[0] ) || 
	!ctype_digit( $components[1] ) ||
	!ctype_digit( $components[2] ) )
      {
	throw new InvalidDateException();
      }

    // Extract day, month, and year
    $day = $components[$this->getFormat() == "DMY" ? 0 : 1];
    $month = $components[$this->getFormat() == "DMY" ? 1 : 0];
    $year = $components[2];

    // If the year is only 2 digits: < 70 = add 2000, > 70 = add 1900
    if( strlen( $year ) < 4 )
      {
	$year += intval( $year ) > 70 ? 1900 : 2000;
      }

    // Verify that the date is legal
    if( !checkdate( $month, $day, $year ) )
      {
	throw new InvalidDateException();
      }

    // Return the date as an integer timestamp
    if( ($data = mktime( 0, 0, 0, $month, $day, $year )) < 1 )
      {
	throw new InvalidDateException();
      }

    return $data;
  }
}
?>