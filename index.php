<?php 
require_once 'config/config.inc.php';
if ($config['installed'] == 0)
        header( "Location: install/index.php" ); 
else
        header( "Location: order/index.php");
?>
