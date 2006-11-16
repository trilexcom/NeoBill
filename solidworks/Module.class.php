<?php
/**
 * Module.class.php
 *
 * This file contains the definition of the Module class.
 *
 * @package solidworks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Module Exceptions
class SWModuleException extends SWException
{
}

class ModuleOperatinNotSupported extends SWException
{
  public function __construct( $operation = "unknown" ) { $this->message = "The requested operation is not supported by this module: " . $operation; }
}

class ModuleInitFailedException extends SWModuleException
{
  public function __construct( $name = "unknown module" ) { $this->message = "Failed to initialize module: " . $name; }
}

/**
 * Module
 *
 * Provides an abstract base-class for SolidWorks modules.
 *
 * @pacakge solidworks
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class Module
{
  /**
   * @var string Module name
   */
  protected $name = "module";

  /**
   * @var string Module description (short)
   */
  protected $sDescription = "default module";

  /**
   * @var string Module description (long)
   */
  protected $description = "default module";

  /**
   * @var integer Module version
   */
  protected $version = 1;

  /**
   * Convert the Module to a String (using the module name)
   *
   * @return string Module name
   */
  public function __toString() { return $this->getName(); }

  /**
   * Get Module Long Description
   *
   * @return string Long Description
   */
  public function getDescription() { return $this->description; }

  /**
   * Get Module Name
   *
   * @return string Module name
   */
  public function getName() { return $this->name; }

  /**
   * Get Module Short Description
   *
   * @return string Short description
   */
  public function getShortDescription() { return $this->sDescription; }

  /**
   * Get Module Version
   *
   * @return integer Module version
   */
  public function getVersion() { return $this->version(); }

  /**
   * Initialize Module
   *
   * This method is called when a module is loaded by SolidWorks.
   */
  public function init()
  {
  }
}
?>