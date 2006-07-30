<h2><?php echo _INSTALLERCOMPANYINFO;?></h2>
	<form method="post" action="index.php">
		<table border="0" cellpadding="5" summary="Company Info">
			<tr>
                                <td class="dbtitle"><?php echo _INSTALLERCOMPANYNAME;?>:</td>
				<td><input type="text" name="name"/></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERCOMPANYEMAIL;?>:</td>
				<td><input type="text" name="email" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERLANGUAGE;?>:</td>
				<td>
				  <select name="language">
                                    <option value="english">English</option>
                                    <option value="italian">Italian</option>
                                    <option value="portuguese">Portuguese</option>
                                  </select>
				</td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERCURRENCY;?>:</td>
				<td><input type="text" name="currency" value="$" size=1/></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 1:</td>
				<td><input type="text" name="ns1" value="ns1.yourcompany.com" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 2:</td>
				<td><input type="text" name="ns2" value="ns2.yourcompany.com" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 3:</td>
				<td><input type="text" name="ns3" value="ns3.yourcompany.com" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 4:</td>
				<td><input type="text" name="ns4" value="ns4.yourcompany.com" /></td>
			</tr>
		</table>
	<div class="submit">
		<input type="submit" value="Next" />
	</div>
	<input type="hidden" name="function" value="insert_company_info" />
	<input type="hidden" name="install_step" value="6" />
	</form>