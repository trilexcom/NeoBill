<h2>Welcome to the Solid State install wizard</h2><br />
<?php 
$languages = get_installer_languages();
?>
<form action="index.php" method="post">
<div>
	<input type="hidden" name="install_step" value="1" />
	<div> <?php echo _INSTALLERCHOOSELANG ?> : 
		<select name="lang">
                        <?php 
                                foreach($languages as $key=>$value)
			                echo '<option value="'.$value.'">'.$value.'</option>';
                        ?>
		</select>
	</div>
	<div class="submit">
		<input type="submit" value="Next" />
	</div>
</div>
</form>
