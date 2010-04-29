<?php
/*
 * @(#)install/pages/database_init.php
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

$message = init_db();
?>
<h2><?php echo _INSTALLERDBINIT; ?></h2>
<br />
<?php
if ($message != '') {
    ?>
<p class="error"><?php echo $message; ?></p>
    <?php
} else {
    ?>
<p class="success"><?php echo _INSTALLERDBINITOK; ?>.</p>
    <?php
}
?>
<form action="index.php" method="post">
    <div class="submit">
        <?php
        if ($message != '') {
            ?>
        <input type="hidden" name="install_step" value="3" />
        <input type="hidden" name="hostname" value="<?php if (isset($_POST['hostname'])) {
        echo $_POST['hostname'];
    } ?>" />
        <input type="hidden" name="username" value="<?php if (isset($_POST['username'])) {
                echo $_POST['username'];
            } ?>" />
        <input type="hidden" name="database" value="<?php if (isset($_POST['database'])) {
        echo $_POST['database'];
    } ?>" />
        <input type="submit" value="<?php echo _INSTALLERDBSETUP; ?>" />
            <?php
        } else {
    ?>
        <input type="hidden" name="install_step" value="4" />
        <input type="submit" value="<?php echo _INSTALLERNEXT; ?>" />
    <?php
}
?>
    </div>
</form>