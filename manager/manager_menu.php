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

require BASE_PATH . "include/SolidStateMenu.class.php";

// Load SolidWorks
require BASE_PATH . "solidworks/solidworks.php";

// Load settings from database
require BASE_PATH . "util/settings.php";
load_settings( $conf );

// Set the current theme
$theme = isset( $_SESSION['client']['userdbo'] ) ?
  $_SESSION['client']['userdbo']->getTheme() : $conf['themes']['manager'];
$conf['themes']['current'] = $theme;

// Load the user's language preference
session_start();
$language = isset( $_SESSION['client']['userdbo'] ) ? 
  $_SESSION['client']['userdbo']->getLanguage() : null;
if( $language != null )
  {
    TranslationParser::load( "language/" . $language );
    Translator::getTranslator()->setActiveLanguage( $language );
  }
  
// Change the charset to UTF-8
header( "Content-type: text/html; charset=utf-8" );

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

// Display menu
$smarty->display( Page::selectTemplateFile( "manager_menu.tpl" ) );
?>