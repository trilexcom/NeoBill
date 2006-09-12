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

/**
 * Module
 *
 * Provides an abstract base-class for SolidWorks modules.
 *
 * @pacakge solidworks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class Module
{
  /**
   * @var string Module name
   */
  var $name = "module";

  /**
   * @var string Module description (short)
   */
  var $sDescription = "default module";

  /**
   * @var string Module description (long)
   */
  var $description = "default module";

  /**
   * @var integer Module version
   */
  var $version = 1;

  /**
   * Get Module Long Description
   *
   * @return string Long Description
   */
  function getDescription() { return $this->description; }

  /**
   * Get Module Name
   *
   * @return string Module name
   */
  function getName() { return $this->name; }

  /**
   * Get Module Short Description
   *
   * @return string Short description
   */
  function getShortDescription() { return $this->sDescription; }

  /**
   * Get Module Version
   *
   * @return integer Module version
   */
  function getVersion() { return $this->version(); }

  /**
   * Initialize Module
   *
   * This method is called when a module is loaded by SolidWorks.
   *
   * @return boolean True for success
   */
  function init()
  {
    return true;
  }
}
?>