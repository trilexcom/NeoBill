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
require_once BASE_PATH . "DBO/UserDBO.class.php";

/**
 * Validate client
 *
 * Displays the login page if the client is not validated.
 */
function validate_client()
{
  global $conf;

  if( $conf['authenticate_user'] && 
      (!isset( $_SESSION['client']['userdbo'] ) || 
       $_SESSION['client']['userdbo']->getType() == "Client") )
    {
      $_GET['page'] = $conf['login_page'];
      $_GET['no_headers'] = 1;

      $class = get_page_class( $_GET['page'] );
      require_once BASE_PATH . $conf['pages'][$class]['class_file'];
    }

  // Client is valid
  return true;
}

?>