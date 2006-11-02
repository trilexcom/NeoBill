<?php
/**
 * AccountValidator.class.php
 *
 * This file contains the definition of the AccountValidator class.  
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

/**
 * AccountValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AccountValidator extends FieldValidator
{
  /**
   * Validate an Account ID
   *
   * Verifies that the account exists.
   *
   * @param string $data Field data
   * @return AccountDBO Account DBO for this Account ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($accountDBO = load_AccountDBO( intval( $data ) )) )
      {
	throw new RecordNotFoundException( "Account" );
      }

    return $accountDBO;
  }
}
?>