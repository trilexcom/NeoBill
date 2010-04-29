<?php
/*
 * @(#)install/pages/requirements.php
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

  $filepath = dirname(__FILE__).'/../../';
  $checkfailed = false;
?>
        <h2><?php echo _INSTALLERREQUIREMENTS; ?></h2>
        <h3><?php echo _INSTALLERPHPVERSION; ?></h3>
        <ul class="systemrequirements">
<?php
  $phpversion = (strpos(phpversion(), '-') !== false)
                 ? substr(phpversion(), 0, strpos(phpversion(), '-')) : phpversion();
  if (version_compare($phpversion, '4.0.6', '>=')) {
    echo '          <li class="passed">', str_replace('%0', $phpversion, _INSTALLERPHPVERSIONOK), '.</li>', "\n";
  } else {
    echo '          <li class="failed">', str_replace('%0', $phpversion, _INSTALLERPHPVERSIONKO), '.</li>', "\n";
    $checkfailed = true;
  }
?>
        </ul>
        <h3><?php echo _INSTALLERPERMISSIONS; ?></h3>
        <ul class="systemrequirements">
          <li class="description"><?php echo _INSTALLERPERMISSIONSFILE, ':'; ?></li>
<?php
  $file = realpath($filepath . 'config/config.inc.php');
  if (!file_exists($file)) {
    echo  '         <li class="failed">', $file, '</li>', "\n";
    echo '          <li class="failed">', "The configuration file does not exist, please make sure config.inc.php exists in directory config", '.</li>', "\n";
  }
  
  if (is_writable($file)) {
    echo '          <li class="passed">', $file, ' ', _INSTALLERPERMISSIONSWRITABLEOK, '.</li>', "\n";
  } else {
    echo '          <li class="failed">', $file, '</li>', "\n";
    echo '          <li class="failed">', _INSTALLERPERMISSIONSWRITABLEKOFILE, '.</li>', "\n";
    $checkfailed = true;
  }
?>
        </ul>
        <form action="index.php" method="post">
          <ul class="systemrequirements">
            <li class="description"><?php echo _INSTALLERPERMISSIONSDIRECTORY, ':'; ?></li>
<?php
  $compiled = '';
  if (isset($_POST['compiled'])) {
    $compiled = realpath($_POST['compiled']);
  }
  if (empty($compiled)) {
    $compiled = realpath($filepath . 'solidworks/smarty/templates_c');
  }
  if (is_writable($compiled)) {
    echo '            <li class="passed"><input type="text" name="compiled" value="', $compiled, '" size="90" /> ', _INSTALLERPERMISSIONSWRITABLEOK, '.</li>', "\n";
  } else {
    echo '            <li class="failed"><input type="text" name="compiled" value="', $compiled, '" size="90" /></li>', "\n";
    echo '            <li class="failed">', _INSTALLERPERMISSIONSWRITABLEKODIRECTORY, '.</li>', "\n";
    $checkfailed = true;
  }
?>
          </ul>
          <ul class="systemrequirements">
            <li class="description"><?php echo _INSTALLERPERMISSIONSDIRECTORY, ':'; ?></li>
<?php
  $cache = '';
  if (isset($_POST['cache'])) {
    $cache = realpath($_POST['cache']);
  }
  if (empty($cache)) {
    $cache= realpath($filepath . 'solidworks/smarty/cache');
  }
  if (is_writable($cache)) {
    echo '            <li class="passed"><input type="text" name="cache" value="', $cache, '" size="90" /> ', _INSTALLERPERMISSIONSWRITABLEOK, '.</li>', "\n";
  } else {
    echo '            <li class="failed"><input type="text" name="cache" value="', $cache, '" size="90" /></li>', "\n";
    echo '            <li class="failed">', _INSTALLERPERMISSIONSWRITABLEKODIRECTORY, '.</li>', "\n";
    $checkfailed = true;
  }
?>
          </ul>
          <div class="submit">
<?php
  if ($checkfailed) {
    echo '            <input type="hidden" name="install_step" value="2" />', "\n";
    echo '            <input type="submit" value="', _INSTALLERRECHECK, '" />', "\n";
  } else {
    echo '            <input type="hidden" name="function" value="config_system" />', "\n";
    echo '            <input type="hidden" name="install_step" value="3" />', "\n";
    echo '            <input type="submit" value="', _INSTALLERNEXT, '" />', "\n";
  }
?>
          </div>
        </form>