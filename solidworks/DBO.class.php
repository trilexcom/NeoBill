<?php
/**
 * DBO.class.php
 *
 * This file contains a definition for the Database Object (DBO) class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DBO
 *
 * Base object for Database Objects (DBOs)
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DBO
{
  /**
   * DBO Array to PHP Array
   *
   * Converts an array of DBO's (such as one returned by load_array_XyzDBO) to
   * a standard PHP array.
   *
   * @param array $dboArray Array of DBO's
   * @param string $keyField The name of the field to use as the key
   * @param array $fields An array of fields in the DBO that are to be included in the array
   * @return array New data array
   */
  public static function toArray( $dboArray, $keyField, $fields )
  {

  }

  /**
   * Load DBO
   *
   * Takes an associative array and calls the 'getXxx' method for each key in
   * the array
   *
   * @param array $data Data to load
   */
  function load( $data )
  {
    foreach( $data as $key => $value )
      {
	$method = sprintf( "set%s", $key );
	if( is_callable( array( $this, $method ) ) )
	  {
	    $this->$method( $value );
	  }
      }
  }
}
?>