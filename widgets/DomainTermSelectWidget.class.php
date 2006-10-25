<?php
/**
 * DomainTermSelectWidget.class.php
 *
 * This file contains the definition of the DomainTermSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// DOMAINTERM Service DBO
require_once BASE_PATH . "DBO/DomainServiceDBO.class.php";

/**
 * DomainTermSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainTermSelectWidget extends SelectWidget
{
  /**
   * @var DomainServiceDBO The TLD to display terms for
   */
  private $dservice = null;

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

    $terms = array( "1 year" => "1 [YEAR]",
		    "2 year" => "2 [YEAR]",
		    "3 year" => "3 [YEAR]",
		    "4 year" => "4 [YEAR]",
		    "5 year" => "5 [YEAR]",
		    "6 year" => "6 [YEAR]",
		    "7 year" => "7 [YEAR]",
		    "8 year" => "8 [YEAR]",
		    "9 year" => "9 [YEAR]",
		    "10 year" => "10 [YEAR]" );

    if( isset( $this->dservice ) )
      {
	$terms['1 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice1yr() );
	$terms['2 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice2yr() );
	$terms['3 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice3yr() );
	$terms['4 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice4yr() );
	$terms['5 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice5yr() );
	$terms['6 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice6yr() );
	$terms['7 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice7yr() );
	$terms['8 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice8yr() );
	$terms['9 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice9yr() );
	$terms['10 year'] .= sprintf( " - %s%.2f", $cs, $this->dservice->getPrice10yr() );
      }

    return $terms;
  }

  /**
   * Set Domain Service DBO
   *
   * @param DomainServiceDBO The domain service to display terms for
   */
  function setDomainService( $dservice ) { $this->dservice = $dservice; }
}
?>