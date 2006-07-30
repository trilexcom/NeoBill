<?php

echo '<h2>'._INSTALLERTASK3.'</h2>';

// PHP Version
echo '<h3>'._INSTALLERPHPVERSION.'</h3>';
echo '<ul class="systemrequirements">';
  
$phpversion = phpversion();
if ($phpversion > '4.3.0') 
  {
    echo '<li class="passed">'._INSTALLERYOURPHPVER.' ' . $phpversion . ' '._INSTALLERPHPVEROK.'</li>';
  }
 else
  {
    echo '<li class="failed">'._INSTALLERYOURPHPVER.' ' . $phpversion . ' '._INSTALLERPHPVERNOTOK.' </li>';
    $checkfailed = true;
  }
echo '</ul>';

// Config File Permissions  
echo '<h3>'._INSTALLERWPPERMISSIONLINKTEXT.'</h3>';
if ($checkfailed != true)
  {
    echo '<form style="display:inline" action="index.php" method="post">';
  } 
 else
  {
    echo '<form style="display:inline" action="index.php" method="post">';
  }
echo '<ul class="systemrequirements">';

echo '<li class="descrip">'._INSTALLERREQDESCRIP.'</li>';
$file = $file_path."config/config.inc.php";
if (is_writable($file)) 
  {
    echo '<li class="passed">'.$file.' '._INSTALLERFILEWRITABLE.'</li>';
  } 
 else 
  {
    echo '<li class="failed">'.$file.' '._INSTALLERFILENOTWRITABLE.'</li>';
    $checkfailed = true;
  }
echo '</ul>';

// Smarty templates_c Permissions
echo '<ul class="systemrequirements">';
$compiled = $_GET['compiled'];
if (empty($compiled)) {
  $compiled = $file_path."solidworks/smarty/templates_c";
}

      echo '<li class="descrip">'._INSTALLERREQDESCRIP.'</li>';

  if (is_writable($compiled)) {
      echo '<li class="passed"><input type="text" name="compiled" value="'.$compiled.'" size="75" /> <span style="color:green;font-weight:700;">&radic;</span></li>';
  } else {
      echo '<li class="failed"><input type="text" name="compiled" value="'.$compiled.'" size="75" /> <span style="color:red;font-weight:700;">&empty;</span></li>';
      echo '<li class="failed">'._INSTALLERDIRNOTWRITABLE.'</li>';
      $checkfailed = true;
  }
echo '</ul>';

echo '<ul class="systemrequirements">';
$cache = $_GET['cache'];
if (empty($cache)) {
  $cache= $file_path."solidworks/smarty/cache";
}
      echo '<li class="descrip">'._INSTALLERREQDESCRIP.'</li>';
  if (is_writable($cache)) {
      echo '<li class="passed"><input type="text" name="cache" value="'.$cache.'" size="75" /> <span style="color:green;font-weight:700;">&radic;</span></li>';
  } else {
      echo '<li class="failed"><input type="text" name="cache" value="'.$cache.'" size="75" /> <span style="color:red;font-weight:700;">&empty;</span></li>';
      echo '<li class="failed">'._INSTALLERDIRNOTWRITABLE.'</li>';
      $checkfailed = true;
  }
echo '</ul>';

if ($checkfailed != true)
  {

      echo '<div class="submit">';
      echo '  <input type="hidden" name="function" value="system_config" />';
      echo '  <input type="hidden" name="install_step" value="3" />';
      echo '  <input type="submit" value="'._NEXT.'" />';
      echo '</div>';
      echo '</form>';
  } else {
      
      echo '<div class="submit">';
      echo '  <input type="hidden" name="install_step" value="2" />';
      echo '  <input type="submit" value="'._RECHECK.'" />';
      echo '</div>';
      echo '</form>';
  }
?>