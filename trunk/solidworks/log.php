<?php
/**
 * log.php
 *
 * This file contains functions related to the SolidState logging facility
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once $base_path . "DBO/LogDBO.class.php";

/**
 * Log Message
 *
 * Writes a new log entry
 *
 * @param string $type Type of log entry (notice, warning, error, critical, or security)
 * @param string $module Where (in the code) this message is coming from
 * @param string $message Log message
 */
function log_message( $type, $module, $message )
{
  global $DB;

  // Construct a LogDBO
  $logdbo = new LogDBO();
  $logdbo->setType( $type );
  $logdbo->setModule( $module );
  $logdbo->setText( $message );
  $logdbo->setUsername( !empty( $_SESSION['client']['userdbo'] ) ? 
			$_SESSION['client']['userdbo']->getUsername() : null );
  $logdbo->setRemoteIP( ip2long( $_SERVER['REMOTE_ADDR'] ) );
  $logdbo->setDate( $DB->format_datetime( time() ) );

  // Write the log message
  if( !add_LogDBO( $logdbo ) )
    {
      echo "There was an error attempting to write a log entry to the database";
      exit();
    }
}

/**
 * Log Notice
 *
 * Writes a new log entry of type "Notice"
 *
 * @param string $module Where (in the code) this message is coming from
 * @param string $message Log message
 */
function log_notice( $module, $message )
{
  log_message( "notice", $module, $message );
}

/**
 * Log Warning
 *
 * Writes a new log entry of type "warning"
 *
 * @param string $module Where (in the code) this message is coming from
 * @param string $message Log message
 */
function log_warning( $module, $message )
{
  log_message( "warning", $module, $message );
}

/**
 * Log Error
 *
 * Writes a new log entry of type "Error"
 *
 * @param string $module Where (in the code) this message is coming from
 * @param string $message Log message
 */
function log_error( $module, $message )
{
  log_message( "error", $module, $message );
}

/**
 * Log Critical
 *
 * Writes a new log entry of type "Critical"
 *
 * @param string $module Where (in the code) this message is coming from
 * @param string $message Log message
 */
function log_critical( $module, $message )
{
  log_message( "critical", $module, $message );
}

/**
 * Log Security
 *
 * Writes a new log entry of type "Security"
 *
 * @param string $module Where (in the code) this message is coming from
 * @param string $message Log message
 */
function log_security( $module, $message )
{
  log_message( "security", $module, $message );
}

/**
 * Fatal Error
 *
 * Log the message as "critical" and bring the program to a halt
 *
 * @param string $module Where (in the code) this message is coming from
 * @param string $message Log message
 */
function fatal_error( $module, $message )
{
  echo $message;
  log_critical( $module, $message );
  exit();
}
?>