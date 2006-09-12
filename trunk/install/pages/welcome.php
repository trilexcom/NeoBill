<form action="index.php" method="post">
<div>
	<input type="hidden" name="install_step" value="1" />
	<div> <?php echo _INSTALLERCHOOSELANG ?> : 
		<select name="lang">
			<option value="eng">English</option>
		</select>
	</div>
	<div class="submit">
		<input type="submit" value="Next" />
	</div>
</div>
</form>