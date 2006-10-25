<?php
/**
 * ModuleValidator.class.php
 *
 * This file contains the definition of the ModuleValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/validators/FieldValidator.class.php";

// Exceptions
require_once BASE_PATH . "exceptions/RecordNotFoundException.class.php";

// Module DBO
require_once BASE_PATH . "DBO/ModuleDBO.class.php";

/**
 * ModuleValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ModuleValidator extends FieldValidator
{
  /**
   * Validate a Module
   *
   * Verifies that a module exists.
   *
   * @param string $data Field data
   * @return ModuleDBO Module DBO for this Module ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    global $conf;

    $data = parent::validate( $data );

    if( !isset( $conf['modules'][$data] ) )
      {
	// Order Item does not exist
	throw new RecordNotFoundException( "Module" );
      }

    return $conf['modules'][$data];
  }
}
?>