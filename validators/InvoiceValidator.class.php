<?php
/**
 * InvoiceValidator.class.php
 *
 * This file contains the definition of the InvoiceValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/validators/FieldValidator.class.php";

// Exceptions
require_once BASE_PATH . "exceptions/RecordNotFoundException.class.php";

// Invoice DBO
require_once BASE_PATH . "DBO/InvoiceDBO.class.php";

/**
 * InvoiceValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class InvoiceValidator extends FieldValidator
{
  /**
   * Validate an Invoice ID
   *
   * Verifies that the invoice exists.
   *
   * @param array $config Field configuration
   * @param string $data Field data
   * @return InvoiceDBO Invoice DBO for this Invoice ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($invoiceDBO = load_InvoiceDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "Invoice" );
      }

    return $invoiceDBO;
  }
}
?>