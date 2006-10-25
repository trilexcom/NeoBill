<?php
/**
 * SolidStateException.class.php
 *
 * This file contains the definition of the SolidStateException class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Parent class
require_once BASE_PATH . "solidworks/SWException.class.php";

/**
 * SolidStateException
 *
 * A SolidState Exception is the most primitive exception that should be thrown by 
 * one of the SolidState interfaces.  All exceptions should descend from this class.
 *
 * @package util
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SolidState extends SWException
{
  /**
   * @var string Error Message
   */
  var $message = "SolidState has encountered an undefined exception.";

  /**
   * SolidStateException Constructor
   */
  function __construct()
  {
  }
}
?>