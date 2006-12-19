<?php
/**
 * DomainServicePriceValidator.class.php
 *
 * This file contains the definition of the DomainServicePriceValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DomainServicePriceValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServicePriceValidator extends FieldValidator
{
  /**
   * Validate a Domain Service Price
   *
   * Verifies that the domain service price exists.
   *
   * @param string $data Field data
   * @return DomainServiceDBO DomainService DBO for this DomainService ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    $id = explode( "-", $data );
    try
      {
	$priceDBO = load_DomainServicePriceDBO( $id[0], 
						$id[1], 
						intval( $id[2] ) );
      }
    catch( DBNoRowsFoundException $e ) 
      { 
	throw new RecordNotFoundException( "DomainServicePrice" ); 
      }

    return $priceDBO;
  }
}
?>