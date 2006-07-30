<?php
	load_db();
?>
<form action="index.php" method="post">
<div>
	<input type="hidden" name="install_step" value="4" />
	<div class="submit">
		<input type="submit" value="<?php echo _NEXT;?>" />
	</div>
</div>
</form>