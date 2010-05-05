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
 * Abstract base class for Database Objects (DBOs)
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class DBO {
	/**
	 * To String
	 *
	 * Every DBO must implement toString() to provide a unique indentifier for the
	 * DBO (such as a database primary key).
	 *
	 * @return string DBO identifier
	 */
	abstract public function __toString();

	/**
	 * Load DBO
	 *
	 * Takes an associative array and calls the 'getXxx' method for each key in
	 * the array
	 *
	 * @param array $data Data to load
	 */
	public function load( $data ) {
		/*    foreach ($data as $key => $value)
        {
        if (!is_numeric($key))
        echo 'Key: '.$key.'&nbsp;&nbsp;&nbsp;&nbsp;Value: '.$value.'<br />';
        }
        die();    */
		foreach ( $data as $key => $value ) {
			$method = sprintf( "set%s", $key );
			if ( is_callable( array( $this, $method ) ) ) {
				$this->$method( $value );
			}
		}
	}
}
?>
