<?php
/**
 * HostingTermSelectWidget.class.php
 *
 * This file contains the definition of the HostingTermSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// HOSTINGTERM Service DBO
require_once BASE_PATH . "DBO/HostingServiceDBO.class.php";

/**
 * HostingTermSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class HostingTermSelectWidget extends SelectWidget
{
  /**
   * @var HostingServiceDBO The Hosting Service to display terms for
   */
  protected $hservice = null;

  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  function getData()
  {
    global $conf;
    $cs = $conf['locale']['currency_symbol'];

    $terms = array( "1 month" => "1 [MONTH]",
		    "3 month" => "3 [MONTHS]",
		    "6 month" => "6 [MONTHS]",
		    "12 month" => "12 [MONTHS]" );

    if( isset( $this->hservice ) )
      {
	$terms['1 month'] .= sprintf( " - %s%.2f", $cs, $this->hservice->getPrice1mo() );
	$terms['3 month'] .= sprintf( " - %s%.2f", $cs, $this->hservice->getPrice3mo() );
	$terms['6 month'] .= sprintf( " - %s%.2f", $cs, $this->hservice->getPrice6mo() );
	$terms['12 month'] .= sprintf( " - %s%.2f", $cs, $this->hservice->getPrice12mo() );
      }

    return $terms;
  }

  /**
   * Set Hosting Service DBO
   *
   * @param HostingServiceDBO The hosting service to display terms for
   */
  function setHostingService( $hservice ) { $this->hservice = $hservice; }
}
?>