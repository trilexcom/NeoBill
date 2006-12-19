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

    try { $moduleDBO = load_ModuleDBO( $data ); }
    catch( DBNoRowsFoundException $e ) { throw new RecordNotFoundException( "RegistrarModule" ); }

    return $moduleDBO;
  }
}
?>