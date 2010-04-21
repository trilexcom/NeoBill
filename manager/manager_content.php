<?php
/**
 * manager_content.php
 *
 * This file handles the content (right) pane of the Solid-State Manager application
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Uncomment to enabled profiling with APD
// If your PHP install is reporting an error with the line below, just comment it
// out.  If you're interested in profiling SS, then you need to install the APD
// package (find it on PECL)
// apd_set_pprof_trace();

// Load config file
require_once dirname(__FILE__)."/../config/config.inc.php";

require_once dirname(__FILE__)."/../include/SolidStateMenu.class.php";

// Load SolidWorks
require_once dirname(__FILE__)."/../solidworks/solidworks.php";

// Load settings from database
require_once dirname(__FILE__)."/../util/settings.php";
load_settings( $conf );

// Set the current theme
$theme = isset( $_SESSION['client']['userdbo'] ) ?
  $_SESSION['client']['userdbo']->getTheme() : $conf['themes']['manager'];
$conf['themes']['current'] = $theme;

// Build the core menu
$menu = SolidStateMenu::getSolidStateMenu();
$username = isset( $_SESSION['client']['userdbo'] ) ?
  $_SESSION['client']['userdbo']->getUsername() : null;
$menu->addItem( new SolidStateMenuItem( "myinfo", 
					"[MY_INFO]", 
					"vcard_edit.png", 
					"manager_content.php?page=config_edit_user&user=" . $username ),
		"administration" );

$menuItems = $menu->getItemArray();
$smarty->assign( "menuItems", $menuItems );

// Remove any uninstalled modules from the database
require_once BASE_PATH . "modules/SolidStateModule.class.php";
removeMissingModules();

// Hand off to SolidWorks
solidworks( $conf, $smarty );
?>