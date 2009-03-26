<?php
/*
 * @(#)install/index.php
 *
 *    Version: 0.50.20090326
 * Written by: Mark Chaney (MACscr) <mailto:mchaney@maximstudios.com>
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
 * Copyright (C) 2001-2008 by Mark Chaney
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

  // TBD: Disable in Production Environment
  error_reporting(E_ALL | E_STRICT);
  
  if (!isset($page)) {
    $page = 'welcome';
    $percent = "0%";
  }
  
  if (!isset($_COOKIE['language'])) {
    setcookie('language', 'english');
  }
  if(isset($_POST['language'])) {
    setcookie('language', $_POST['language']);
  }
  
  if (isset($_POST['language'])) {
    require_once 'languages/' . $_POST['language'] . '.php';
  } else if (isset($_COOKIE['language'])) {
    require_once 'languages/' . $_COOKIE['language'] . '.php';
  } else {
    require_once 'languages/english.php';
  }
  
  require_once 'include/solidstate.php';
  require_once 'templates/header.php';
  
  include 'pages/' . $page . '.php';
  
  require_once 'templates/footer.php';
?>