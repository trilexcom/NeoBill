<?php
/*
 * @(#)install/pages/create_company.php
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

$company      = '';
$email        = '';
$currency     = '€';
$nameserver_1 = '';
$nameserver_2 = '';
$nameserver_3 = '';
$nameserver_4 = '';

if (isset($_POST['company'])) {
    $company = $_POST['company'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['currency'])) {
    $currency = $_POST['currency'];
}
if (isset($_POST['nameserver-1'])) {
    $nameserver_1 = $_POST['nameserver-1'];
}
if (isset($_POST['nameserver-2'])) {
    $nameserver_2 = $_POST['nameserver-2'];
}
if (isset($_POST['nameserver-3'])) {
    $nameserver_3 = $_POST['nameserver-3'];
}
if (isset($_POST['nameserver-4'])) {
    $nameserver_4 = $_POST['nameserver-4'];
}
?>
<h2><?php echo _INSTALLERCOMPANY; ?></h2>
<br />
<?php
if (isset($message) && $message != '') {
    ?>
<p class="error"><?php echo $message; ?>!</p>
    <?php
}
?>
<form method="post" action="index.php">
    <table border="0" cellpadding="5" summary="Company Info"><tr>
            <td class="dbtitle"><?php echo _INSTALLERCOMPANYNAME; ?>: *</td>
            <td><input type="text" name="company" value="<?php echo $company; ?>"/></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERCOMPANYEMAIL; ?>: *</td>
            <td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERCOMPANYCURRENCY; ?>: *</td>
            <td><input type="text" name="currency" value="<?php echo $currency; ?>" size="1" /></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERCOMPANYNAMESERVER; ?> 1: *</td>
            <td><input type="text" name="nameserver-1" value="<?php echo $nameserver_1; ?>" /></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERCOMPANYNAMESERVER; ?> 2: *</td>
            <td><input type="text" name="nameserver-2" value="<?php echo $nameserver_2; ?>" /></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERCOMPANYNAMESERVER; ?> 3:</td>
            <td><input type="text" name="nameserver-3" value="<?php echo $nameserver_3; ?>" /></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERCOMPANYNAMESERVER; ?> 4:</td>
            <td><input type="text" name="nameserver-4" value="<?php echo $nameserver_4; ?>" /></td>
        </tr></table>
    <div class="submit">
        <input type="hidden" name="function" value="create_company" />
        <input type="hidden" name="install_step" value="6" />
        <input type="submit" value="<?php echo _INSTALLERNEXT; ?>" />
    </div>
</form>