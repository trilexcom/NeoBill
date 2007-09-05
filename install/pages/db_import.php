<?php
	$msg = load_db();
        if($msg != ''){
        
        echo '<p class="error">'.$msg.'</p>';
        echo '<form action="index.php" method="post">
                <input type="hidden" name="install_step" value="3" />';
                echo '<input type="hidden" name="host" value="'.$_POST['host'].'" />
                <input type="hidden" name="user" value="'.$_POST['user'].'" />
                <input type="hidden" name="database" value="'.$_POST['database'].'" />
                <input type="submit" value="'._INSTALLERDBSETUP.'" />
                </form>';
                die();
        }
        
        else
                echo _INSTALLERDBLOADED;

?>
<form action="index.php" method="post">
<div>
	<input type="hidden" name="install_step" value="4" />
	<div class="submit">
		<input type="submit" value="<?php echo _NEXT;?>" />
	</div>
</div>
</form>
