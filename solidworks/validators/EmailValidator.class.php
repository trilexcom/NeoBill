<?php
/**
 * EmailValidator.class.php
 *
 * This file contains the definition of the EmailValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Exceptions
require BASE_PATH . "solidworks/exceptions/EmailFieldException.class.php";

/**
 * EmailValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class EmailValidator extends TextValidator
{
  /**
   * Validate a Email Field
   *
   * Email fields are text fields that must contain a legal e-mail address.
   *
   * @param string $data Field data
   * @return string Data in MD5 form
   * @throws FieldException, FieldSizeException
   */
  public function validate( $data )
  {
    $data = parent::validate( $data );

    if (!preg_match( '"^[-!#$%&\'*+\\\\./0-9=?A-Z^_`a-z{|}~]+'.
	       '@'.
	       '[-!#$%&\'*+\\\\/0-9=?A-Z^_`a-z{|}~]+\.'.
	       '[-!#$%&\'*+\\\\./0-9=?A-Z^_`a-z{|}~]+$"', $data ))
      {
	// Not a valid email address
	throw new EmailFieldException();
      }

    return $data;
  }
}
?>