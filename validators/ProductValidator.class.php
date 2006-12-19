<?php
/**
 * ProductValidator.class.php
 *
 * This file contains the definition of the ProductValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ProductValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ProductValidator extends FieldValidator
{
  /**
   * Validate a Product ID
   *
   * Verifies that the product exists.
   *
   * @param array $config Field configuration
   * @param string $data Field data
   * @return ProductDBO Product DBO for this Product ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    try { $productDBO = load_ProductDBO( intval( $data ) ); }
    catch( DBNoRowsFoundException $e ) { throw new RecordNotFoundException( "Product" ); }

    return $productDBO;
  }
}
?>