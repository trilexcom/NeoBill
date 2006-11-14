<?php
/**
 * DomainServiceValidator.class.php
 *
 * This file contains the definition of the DomainServiceValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DomainServiceValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class DomainServiceValidator extends FieldValidator
{
  /**
   * Validate a Domain Service TLD
   *
   * Verifies that the domain service exists.
   *
   * @param string $data Field data
   * @return DomainServiceDBO Domain Service DBO for this TLD
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($domainDBO = load_DomainServiceDBO( $data )) )
      {
	throw new RecordNotFoundException( "DomainService" );
      }

    return $domainDBO;
  }
}
?>