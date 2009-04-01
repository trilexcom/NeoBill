<?php
/*
 * @(#)management/index.php
 *
 *    Version: 0.50.20090401
 * Written by: John Diamond <mailto:jdiamond@solid-state.org>
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
 * Copyright (C) 2006-2008 by John Diamond
 * Copyright (C) 2009 by Yves Kreis
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the 
 * Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */

  require_once '../config/config.php';
  require_once BASE_PATH . 'include/menu.class.php';
  
  echo is_null(Menu::test1());
  echo '<br />';
  echo is_null(Menu::test2());
  echo '<br />';
  echo is_null(Menu::test1());
  echo '<br />';
  echo Menu::test1();
  echo '<br />';
  echo Menu::test2();
  echo '<br />';
  echo Menu::test1();
  echo '<br />';
  echo phpversion();
  
/*  
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

// Display frames
$smarty->assign( "company_name", $conf['company']['name'] );
$smarty->display( Page::selectTemplateFile( "manager_frames.tpl" ) );
*/
?>