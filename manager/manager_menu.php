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
require_once "../config/config.inc.php";

// Load SolidWorks
require_once $base_path . "solidworks/solidworks.php";

// Load settings from database
require_once $base_path . "util/settings.php";
load_settings( $conf );

// Load the user's language preference
session_start();
$language = isset( $_SESSION['client']['userdbo'] ) ? 
  $_SESSION['client']['userdbo']->getLanguage() : null;
if( isset( $translations[$language] ) )
  {
    $conf['locale']['language'] = $language;
  }

// Display menu
$smarty->display( "manager_menu.tpl" );

?>