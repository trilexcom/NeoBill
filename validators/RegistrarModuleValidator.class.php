<?php
/**
 * RegistrarModuleValidator.class.php
 *
 * This file contains the definition of the RegistrarModuleValidator class.  
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
 * RegistrarModuleValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RegistrarModuleValidator extends FieldValidator
{
  /**
   * Validate a Registrar Module
   *
   * Verifies that the Registrar Module exists and is enabled
   *
   * @param string $data Field data
   * @return ModuleDBO Module DBO for this Registrar
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($moduleDBO = load_ModuleDBO( $data )) )
      {
	throw new RecordNotFoundException( "RegistrarModule" );
      }

    return $moduleDBO;
  }
}
?>