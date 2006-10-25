<?php
/**
 * TLDSelectWidget.class.php
 *
 * This file contains the definition of the TLDSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// TLD Service DBO
require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

/**
 * TLDSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TLDSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  function getData()
  {
    // Query TLDServiceDBO's
    $domainDBOs = load_array_DomainServiceDBO();
    if( empty( $domainDBOs ) )
      {
	return array();
      }

    // Convery to an array: TLD => TLD
    $tlds = array();
    foreach( $domainDBOs as $domainDBO )
      {
	$tlds[$domainDBO->getTLD()] = $domainDBO->getTLD();
      }

    return $tlds;
  }
}
?>