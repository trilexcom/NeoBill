<?php
/**
 * security.php
 *
 * This file contains security routines
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Validate client
 *
 * Displays the login page if the client is not validated.
 */
function validate_client()
{
  global $conf;

  if( $conf['authenticate_user'] && !isset( $_SESSION['client'] ) )
    {
      $_GET['page'] = $conf['login_page'];
      $_GET['no_headers'] = 1;
    }

  // Client is valid
  return true;
}

?>