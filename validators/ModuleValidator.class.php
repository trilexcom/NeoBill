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

    try 
      {
	$module = ModuleRegistry::getModuleRegistry()->getModule( $data );
      }
    catch( ModuleDoesNotExistException $e )
      {
	throw new RecordNotFoundException( "Module" );
      }

    return $module;
  }
}
?>