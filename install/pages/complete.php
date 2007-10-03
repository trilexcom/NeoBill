<?php
unset($_COOKIE['lang']);
modify_install_status();
?>
<h2><?php echo _INSTALLCOMPLETE;?></h2>
<div>
        <?php echo _INSTALLERCONGRATS;?>!<br /><br />
	<a href="../manager/" title=""><?php echo _INSTALLERLOGINTOMANAGER;?></a>
</div>
