<?php
/**
 * SWException.class.php
 *
 * This file contains the definition of the SWException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * SWException
 *
 * A SolidWorks Exception is the most primitive exception that can be thrown by a 
 * SolidWorks applications.  All exceptions should descend from this class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SWException extends Exception
{
  /**
   * @var string Error Message
   */
  protected $message = "An undefined exception has occured.";

  /**
   * SWException Constructor
   */
  public function __construct( $message = null )
  {
    parent::__construct();

    if( isset( $message ) ) 
      {
	$this->message = $message;
      }
  }

  /**
   * Error Message
   *
   * @return string The error message to be displayed to the user
   */
  function __toString() { return $this->message; }
}

class SWUserException extends SWException
{
}
?>