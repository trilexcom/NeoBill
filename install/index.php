<?php
/**
 * index.php
 *
 * This file controls the entire install program.
 *
 * @package Installer
 * @author Mark Chaney (MACscr) <mchaney@maximstudios.com>
 * @copyright Mark Chaney (MACscr) <mchaney@maximstudios.com>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

error_reporting(E_ALL ^ E_NOTICE);

if( !isset( $page ) )
  {
    $page="welcome";
    $percent = "0%";
  }

if(!isset($_COOKIE['lang'] ))
{
        setcookie ('lang', 'english');
        echo 'Cookie Not Set<br />';
        
}

if( isset($_POST['lang'] )) {

        setcookie('lang', $_POST['lang']);
}


// load the installer language files
if(isset($_POST['lang']))
      require_once 'lang/'.$_POST['lang'].'/global.php';
else if (!isset($_COOKIE['lang']))
      require_once 'lang/english/global.php';
else
      require_once 'lang/'.$_COOKIE['lang'].'/global.php';

//echo '<h1 style="color: #FFFFFF;">Cookie Language is '.$_COOKIE['lang'].'</h1>';

require_once "includes/functions.php";
require_once "templates/header.php";

$this_pathinfo  = pathinfo( __FILE__ );
$file_path      = ereg_replace('install', '', $this_pathinfo['dirname']);

// Display Error message if any
if (isset($msg))
        echo '<p class="error">'.$msg.'</p>';
include "pages/".$page.".php";

require_once "templates/footer.php";

?>
