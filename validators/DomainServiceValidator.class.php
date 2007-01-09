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
   * @var boolean Allow private items flag
   */
  protected $allowPrivateItems = true;

  /**
   * No Private Items Allowed
   */
  public function noPrivateItems() { $this->allowPrivateItems = false; }
  
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

    try { $domainDBO = load_DomainServiceDBO( $data ); }
    catch( DBNoRowsFoundException $e ) { throw new RecordNotFoundException( "DomainService" ); }

    if( !$this->allowPrivateItems && !$domainDBO->isPublic() )
      {
	throw new RecordNotFoundException( "DomainService" );
      }

    return $domainDBO;
  }
}
?>