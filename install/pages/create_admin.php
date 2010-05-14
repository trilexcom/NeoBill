<?php
/*
 * @(#)install/pages/create_admin.php
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

$firstname = '';
$lastname  = '';
$username  = 'admin';
$email     = '';

if (isset($_POST['firstname'])) {
	$firstname = $_POST['firstname'];
}
if (isset($_POST['lastname'])) {
	$lastname = $_POST['lastname'];
}
if (isset($_POST['username'])) {
	$username = $_POST['username'];
}
if (isset($_POST['email'])) {
	$email = $_POST['email'];
}
?>
<script type="text/javascript" src="javascript/password.js"></script>
<h2><?php echo _INSTALLERADMIN; ?></h2>
<br />
<?php
if (isset($message) && $message != '') {
	?>
<p class="error"><?php echo $message; ?>!</p>
	<?php
}
?>
<form method="post" action="index.php">
    <table border="0" cellpadding="5" summary="Create Admin Account"><tr>
            <td class="dbtitle"><?php echo _INSTALLERADMINFIRSTNAME; ?>:</td>
            <td><input type="text" name="firstname" value="<?php echo $firstname; ?>"/></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERADMINLASTNAME; ?>:</td>
            <td><input type="text" name="lastname" value="<?php echo $lastname; ?>"/></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERADMINUSERNAME; ?>: *</td>
            <td><input type="text" name="username" value="<?php echo $username; ?>" /></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERADMINPASSWORD; ?>: *</td>
            <td><input type="password" name="password-1" onblur="_password(this);" onkeyup="_password(this);" /></td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERADMINPASSWORDSTRENGTH; ?>:</td>
            <td valign="top" class="pwdChkTd">
                <table cellpadding="0" cellspacing="0" class="pwdChkTbl" summary="Password Strength"><tr>
                        <td id="idSM0" class="pwdChkCon" align="center">
                            <span id="idSMT" style="display: inline; font-weight: normal; color: #666;"><?php echo _INSTALLERADMINPASSWORDSTRENGTHNOTRATED; ?></span>
                            <span id="idSMT0" style="display: none;"><?php echo _INSTALLERADMINPASSWORDSTRENGTHWORST ?></span>
                        </td>
                        <td id="idSM1" class="pwdChkCon" align="center" style="border-left: solid 1px #fff"><span id="idSMT1" style="display: none;"><?php echo _INSTALLERADMINPASSWORDSTRENGTHWEAK; ?></span></td>
                        <td id="idSM2" class="pwdChkCon" align="center" style="border-left: solid 1px #fff"><span id="idSMT2" style="display: none;"><?php echo _INSTALLERADMINPASSWORDSTRENGTHMEDIUM ?></span></td>
                        <td id="idSM3" class="pwdChkCon" align="center" style="border-left: solid 1px #fff"><span id="idSMT3" style="display: none;"><?php echo _INSTALLERADMINPASSWORDSTRENGTHSTRONG ?></span></td>
                        <td id="idSM4" class="pwdChkCon" align="center" style="border-left: solid 1px #fff"><span id="idSMT4" style="display: none;"><?php echo _INSTALLERADMINPASSWORDSTRENGTHBEST ?></span></td>
                    </tr></table>
            </td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERADMINPASSWORDRETYPE; ?>: *</td>
            <td>
                <table cellpadding="0" cellspacing="0" summary="Password Check"><tr>
                        <td><input type="password" name="password-2" onblur="_password(this);" onkeyup="_password(this);" /></td>
                        <td><div style="margin-left: 5px;" id="result">&nbsp;</div></td>
                    </tr></table>
            </td>
        </tr><tr>
            <td class="dbtitle"><?php echo _INSTALLERADMINEMAIL; ?>: *</td>
            <td><input type="text" name="email" value="<?php echo $email;?>" /></td>
        </tr></table>
    <div class="submit">
        <input type="hidden" name="function" value="create_admin" />
        <input type="hidden" name="install_step" value="5" />
        <input type="submit" value="<?php echo _INSTALLERNEXT;?>" />
    </div>
</form>