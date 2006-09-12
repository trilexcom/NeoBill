<h2><?php echo _INSTALLERDBSETUP;?></h2>
	<form method="post" action="index.php">
		<table border="0" cellpadding="5" summary="Database Setup">
			<tr>
                                <td class="dbtitle"><?php echo _INSTALLERDBHOST;?>:</td>
				<td><input type="text" name="host" value="localhost" /></td>
				<td class="dbdesc"><?php echo _INSTALLERDBHOSTEXP;?></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERDBUSER;?>:</td>
				<td><input type="text" name="user" /></td>
				<td class="dbdesc"><?php echo _INSTALLERDBUSEREXP;?></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERDBPASS;?>:</td>
				<td><input type="password" name="pass" /></td>
				<td class="dbdesc"><?php echo _INSTALLERDBPASSEXP;?></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERDBNAME;?>:</td>
				<td><input type="text" name="database" /></td>
				<td class="dbdesc"><?php echo _INSTALLERDBNAMEEXP;?></td>
			</tr>
			<tr>
				<td colspan="3"><input type="Submit" value="<?php echo _INSTALL;?>" /></td>
			</tr>
		</table>
	<input type="hidden" name="function" value="db_config" />
	<input type="hidden" name="loader" value="db_import" />
	</form>