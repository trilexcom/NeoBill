<?php
/**
 * index.php
 *
 * This file controls the SolidState Order interface
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Uncomment to enabled profiling with APD.
// If your PHP install is reporting an error with the line below, just comment it
// out.  If you're interested in profiling SS, then you need to install the APD
// package (find it on PECL)
// apd_set_pprof_trace();

// Load config file
require_once "../config/config.inc.php";

// Load SolidWorks
require_once BASE_PATH . "solidworks/solidworks.php";

// Load settings from database
require_once BASE_PATH . "util/settings.php";
load_settings( $conf );

// Set the current theme
$conf['themes']['current'] = $conf['themes']['order'];

// Provide the Order Interface page title to the templates
$smarty->assign( "order_title", $conf['order']['title'] );

// Hand off to SolidWorks
solidworks( $conf, $smarty );
?>