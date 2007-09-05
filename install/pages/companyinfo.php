<?php

$name = '';
$email = '';
$currency = '$';
$ns1 = 'ns1.yourcompany.com';
$ns2 = 'ns2.yourcompany.com';
$ns3 ='';
$ns4 = '';

if (isset($_POST['name']))
        $name = $_POST['name'];

if (isset($_POST['email']))
        $email = $_POST['email'];

if (isset($_POST['currency']))
        $currency = $_POST['currency'];

if (isset($_POST['email']))
        $email = $_POST['email'];

if (isset($_POST['ns1']))
        $ns1 = $_POST['ns1'];

if (isset($_POST['ns2']))
        $ns2 = $_POST['ns2'];

if (isset($_POST['ns3']))
        $ns3 = $_POST['ns3'];

if (isset($_POST['ns4']))
        $ns4 = $_POST['ns4'];

?>
<h2><?php echo _INSTALLERCOMPANYINFO;?></h2>
	<form method="post" action="index.php">
		<table border="0" cellpadding="5" summary="Company Info">
			<tr>
                                <td class="dbtitle"><?php echo _INSTALLERCOMPANYNAME;?>: *</td>
				<td><input type="text" name="name" value="<?php echo $name; ?>"/></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERCOMPANYEMAIL;?>: *</td>
				<td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERLANGUAGE;?>: *</td>
				<td>
				  <select name="language">
                                    <option value="english">English</option>
                                    <option value="italian">Italian</option>
                                    <option value="portuguese">Portuguese</option>
                                  </select>
				</td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERCURRENCY;?>: *</td>
				<td><input type="text" name="currency" value="<?php echo $currency; ?>" size=1/></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 1: *</td>
				<td><input type="text" name="ns1" value="<?php echo $ns1; ?>" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 2: *</td>
				<td><input type="text" name="ns2" value="<?php echo $ns2; ?>" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 3:</td>
				<td><input type="text" name="ns3" value="<?php echo $ns3; ?>" /></td>
			</tr>
			<tr>
				<td class="dbtitle"><?php echo _INSTALLERNS;?> 4:</td>
				<td><input type="text" name="ns4" value="<?php echo $ns4; ?>" /></td>
			</tr>
		</table>
	<div class="submit">
		<input type="submit" value="Next" />
	</div>
	<input type="hidden" name="function" value="insert_company_info" />
	
	</form>
