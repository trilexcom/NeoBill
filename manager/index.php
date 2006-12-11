<?php
/**
 * index.php
 *
 * To access the Solid-State Manager, a client points his web browser
 * at this file, which basically loads two frames: the left menu frame and
 * the right content frame.  Nothing much happens here - the real magic 
 * happens in manager_content.php.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Load Smarty
require "../solidworks/smarty/Smarty.class.php";

// Create a Smarty object
$smarty = new Smarty();

// Set Smarty directories
$smarty->template_dir = "/templates";
$smarty->compile_dir  = "../solidworks/smarty/templates_c";
$smarty->cache_dir    = "../solidworks/smarty/cache";
$smarty->config_dir   = "../solidworks/smarty/configs";

// Display menu
$smarty->display( "manager_frames.tpl" );

?>