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

require_once "includes/functions.php";
require_once "templates/header.php";

$this_pathinfo  = pathinfo( __FILE__ );
$file_path      = ereg_replace('install', '', $this_pathinfo['dirname']);

    // load the installer language files
    if (file_exists('install/lang/'.$lang.'/global.php')) {
      include 'lang/'.$lang.'/global.php';
    } else {
      include 'lang/eng/global.php';
    }

include "pages/".$page.".php";

require_once "templates/footer.php";

?>