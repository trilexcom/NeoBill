<?php
/*
 * @(#)install/pages/database_config.php
 *
 *    Version: 0.50.20090325
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

$hostname = 'localhost';
$username = 'solidstate';
$database = 'solidstate';

if (isset($_POST['hostname'])) {
    $hostname = $_POST['hostname'];
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['database'])) {
    $database = $_POST['database'];
}
?>
<h2><?php echo _INSTALLERDBSETUP; ?></h2>
<br />
<form action="index.php" method="post">
    <table border="0" cellpadding="5" summary="Database Setup"><tr>
            <td class="dbtitle"><?php echo _INSTALLERDBHOSTNAME; ?>:</td>
            <td><input type="text" name="hostname" value="<?php echo $hostname; ?>" /></td>
            <td class="dbdescription"><?php echo _INSTALLERDBHOSTNAMEEXPLANATION; ?></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERDBUSERNAME; ?>:</td>
            <td><input type="text" name="username" value="<?php echo $username; ?>"/></td>
            <td class="dbdescription"><?php echo _INSTALLERDBUSERNAMEEXPLANATION; ?></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERDBPASSWORD; ?>:</td>
            <td><input type="password" name="password" /></td>
            <td class="dbdescription"><?php echo _INSTALLERDBPASSWORDEXPLANATION; ?></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERDBDATABASE; ?>:</td>
            <td><input type="text" name="database" value="<?php echo $database; ?>"/></td>
            <td class="dbdescription"><?php echo _INSTALLERDBDATABASEEXPLANATION; ?></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERDBCREATE; ?>:</td>
            <td><input type="checkbox" name="create" /></td>
            <td class="dbdescription"><?php echo _INSTALLERDBCREATEEXPLANATION; ?></td>
        </tr></table>
    <div class="submit">
        <input type="hidden" name="function" value="config_db" />
        <input type="hidden" name="install_step" value="3" />
        <input type="submit" value="<?php echo _INSTALLERINIT; ?>" />
    </div>
</form>