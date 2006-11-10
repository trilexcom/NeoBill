<?php
/**
 * manager_menu.php
 *
 * This file handles the menu (left) pane of the Solid State Manager application.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Load config file
require "../config/config.inc.php";

// Load SolidWorks
require BASE_PATH . "solidworks/solidworks.php";

// Load settings from database
require BASE_PATH . "util/settings.php";
load_settings( $conf );

// Load the user's language preference
session_start();
$language = isset( $_SESSION['client']['userdbo'] ) ? 
  $_SESSION['client']['userdbo']->getLanguage() : null;
if( isset( $translations[$language] ) )
  {
    $conf['locale']['language'] = $language;
  }

// Populate the username field
$smarty->assign( "username", isset( $_SESSION['client']['userdbo'] ) ?
				    $_SESSION['client']['userdbo']->getUsername() :
				    null );

// Change the charset to UTF-8
header( "Content-type: text/html; charset=utf-8" );

// Display menu
$smarty->display( "manager_menu.tpl" );

?>