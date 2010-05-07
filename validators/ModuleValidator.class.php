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
class ModuleValidator extends FieldValidator {
	/**
	 * @var string Type requirement
	 */
	protected $type = null;

	/**
	 * Validate a Module
	 *
	 * Verifies that a module exists.
	 *
	 * @param string $data Field data
	 * @return ModuleDBO Module DBO for this Module ID
	 * @throws RecordNotFoundException
	 */
	public function validate( $data ) {
		global $conf;

		$data = parent::validate( $data );

		try {
			$module = ModuleRegistry::getModuleRegistry()->getModule( $data );
			if( isset( $this->type ) && $module->getType() != $this->type ) {
				throw new FieldException( "Invalid module type" );
			}
		}
		catch( ModuleDoesNotExistException $e ) {
			throw new RecordNotFoundException( "Module" );
		}

		return $module;
	}

	/**
	 * Set Module Type Requirement
	 *
	 * @param string $type Module type requirement
	 */
	public function setType( $type ) {
		$this->type = $type;
	}
}
?>