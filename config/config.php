<?php
/*
 * @(#)config.php
 *
 *    Version: 0.50.20090327
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
 
  /*
   * This file contains a set of basic configuration variables that are needed to run SolidState. However most configuration 
   * options are stored in the database and can be set through the "Administration > Settings" page.
   *
   * Database configuration:
   *
   *   $db['hostname']      - This is the hostname that your MySQL database server runs on
   *   $db['username']      - Database user with access to the SolidState database
   *   $db['password']      - Password for the database user
   *   $db['database']      - The name of the database that SolidState will be using
   *   $db['encoded']	    - 0 for MySQL information unenccoded
   *                          1 for MySQL information encoded
   *
   * System configuration:
   *
   *   $config['installed'] - Is SolidState installed?
   *   $config['cache']     - Absolute path of smarty cache directory
   *   $config['compiled']  - Absolute path of smarty compiled directory (template_c)
   *   $config['encoded']   - 0 for MySQL information unenccoded
   *                   	      1 for MySQL information encoded
   */

  /*
   * Database configuration
   */

  global $db;

  $db['hostname'] = 'localhost';
  $db['username'] = 'solidstate';
  $db['password'] = '';
  $db['database'] = 'solidstate';
  $db['encoded']  = 1;

  /*
   * System configuration
   */

  global $config;

  $config['installed'] = 0;
  $config['cache']     = './solidworks/smarty/cache';
  $config['compiled']  = './solidworks/smarty/templates_c';
  $config['encoded']   = 1;

?>