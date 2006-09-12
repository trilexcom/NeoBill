<script type="text/javascript" src="javascript/password.js"></script>
<script type="text/javascript" src="javascript/verifynotify.js"></script>
<h2>Create Admin Account</h2>
	<form method="post" action="index.php" name="password_form">
	<input type="hidden" name="function" value="create_admin" />
	<input type="hidden" name="type" value="Administrator" />
		<table border="0" cellpadding="5" summary="table">
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERADMINFIRSTNAME; ?></td>
				<td><input type="text" name="firstname" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERADMINLASTNAME; ?></td>
				<td><input type="text" name="lastname" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERADMINUSERNAME; ?></td>
				<td><input type="text" name="username" value="Administrator" /></td>
			</tr>			
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERADMINPASSWORD; ?></td>
				<td>
					<input onkeyup="EvalPwdStrength(document.forms[0],this.value);verify.check()" type="password" id="inputPC" name="user_password" /></td>
			</tr>
			<?php
			  if (extension_loaded("gd") and ($gfx_chk == 3 or $gfx_chk == 4 or $gfx_chk == 6 or $gfx_chk == 7)) {
			?>
			<tr>
				<td><?php echo _INSTALLERADMINSECURITYCODE; ?></td>
				<td><img src='?gfx=gfx&amp;random_num=<?php echo $random_num; ?> border="1" alt="<?php echo _INSTALLERADMINSECURITYCODE; ?>"></td>
			</tr>
			<tr>
				<td><?php echo _INSTALLERADMINTYPESECCODE; ?></td
				<td>
				<input type="text" name="gfx_check" size="7" maxlenght="6"></td>
			</tr>
			<input type="hidden" name="random_num" value="<?php echo $random_num; ?>" />
			<?php } ?>
			<tr>
				<td class="pwdChkTd1 dbtitle" align="right"><?php echo _INSTALLERADMINPASSSTRENGTH; ?></td>
				<td valign="top" class="pwdChkTd2">
					<table cellpadding="0" cellspacing="0" class="pwdChkTbl2" summary="table">
						<tr>
							<td id="idSM1" width="25%" class="pwdChkCon0" align="center">
								<span id="idSMT1" style="display:none;">Weak</span></td>
							<td id="idSM2" width="25%" class="pwdChkCon0" align="center" style="border-left:solid 1px #fff">
								<span id="idSMT0" style="display:inline;font-weight:normal;color:#666">Not rated</span>
								<span id="idSMT2" style="display:none;">Medium</span></td>
							<td id="idSM3" width="25%" class="pwdChkCon0" align="center" style="border-left:solid 1px #fff">
								<span id="idSMT3" style="display:none;">Strong</span></td>
							<td id="idSM4" width="25%" class="pwdChkCon0" align="center" style="border-left:solid 1px #fff">
								<span id="idSMT4" style="display:none;">BEST</span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERADMINRETYPEPASSWORD; ?></td>
				<td>
					<table cellpadding="0" cellspacing="0" summary="table">
						<tr>
							<td><input type="password" name="passverify" onkeyup="verify.check()" /></td>
							<td><div style="margin-left:5px;" id="password_result">&nbsp;</div></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERADMINEMAIL; ?></td>
				<td><input type="text" name="email" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Create" /></td>
			</tr>
		</table>
	</form>
<script type="text/javascript">
<!--

verify = new verifynotify();
verify.field1 = document.password_form.user_password;
verify.field2 = document.password_form.passverify;
verify.result_id = "password_result";
verify.match_html = "<span style=\"color:green;font-weight:700;\">&radic;<\/span>";
verify.nomatch_html = "<span style=\"color:red;font-weight:700;\">&empty;<\/span>";

// Update the result message
verify.check();

// -->
</script>