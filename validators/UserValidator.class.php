<?php
/**
 * UserValidator.class.php
 *
 * This file contains the definition of the UserValidator class.  
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
 * UserValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class UserValidator extends FieldValidator
{
  /**
   * Validate an User
   *
   * Verifies that the user exists.
   *
   * @param string $data Field data
   * @return UserDBO User DBO for this User ID
   * @throws RecordNotFoundException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if( null == ($userDBO = load_UserDBO( $data )) )
      {
	throw new RecordNotFoundException( "User" );
      }

    return $userDBO;
  }
}
?>