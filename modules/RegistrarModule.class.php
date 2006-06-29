<?php
/**
 * RegistrarModule.class.php
 *
 * This file contains the definition of the RegistrarModule class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once $base_path . "modules/SolidStateModule.class.php";

/**
 * RegistrarModule
 *
 * Provides a base class for modules of domain_registrar type.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
class RegistrarModule extends SolidStateModule
{
  /**
   * @var string This is the name of the page that is called when the user wants to register a new page from the Manager.  It must be provided by the module programmer.
   */
  var $managerRegisterDomainPage = null;

  /**
   * @var string Module type is registrar
   */
  var $type = "registrar";

  /**
   * Check Domain Availability
   *
   * @return boolean True if the domain is available to be registered
   */
  function checkAvailability( $fqdn )
  {
    echo "checkAvailability() not implemented!";
    return false;
  }

  /**
   * Get Manager Register Domain Page
   *
   * @return string The name of the Register Domain Page for the Manager
   */
  function getManagerRegisterDomainPage()
  {
    if( !isset( $this->managerRegisterDomainPage ) )
      {
	fatal_error( "RegistrarModule::getManagerRegisterDomainPage()",
		     "The required Register Domain Page is not provided by module: " . $this->getName() );
      }

    return $this->managerRegisterDomainPage;
  }
}
?>