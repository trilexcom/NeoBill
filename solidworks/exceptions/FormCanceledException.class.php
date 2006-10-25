<?php
/**
 * FormCanceledException.class.php
 *
 * This file contains the definition of the FormCanceledException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/SWException.class.php";

/**
 * FormCanceledException
 *
 * Thrown by the Form process() method whenever a cancel field is encountered.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FormCanceledException extends SWException
{
  /**
   * @var string The internal error message for this exception
   */
  protected $message = "Form canceled";
}
?>