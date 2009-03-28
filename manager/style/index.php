<?php
/*
 * @(#)manager/style/index.php
 *
 *    Version: 0.50.20090327
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
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

  $folder = 'style';
  if (strrpos($_SERVER['PHP_SELF'], '/' . $folder . '/index.php') === (strlen($_SERVER['PHP_SELF']) - strlen('/' . $folder . '/index.php'))) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . substr($_SERVER['PHP_SELF'], 1, strrpos($_SERVER['PHP_SELF'], '/' . $folder . '/index.php')));
  } else {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
  }
?>