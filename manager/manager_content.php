<?php
/**
 * manager_content.php
 *
 * This file handles the content (right) pane of the Solid-State Manager application
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Uncomment to enabled profiling with APD
// If your PHP install is reporting an error with the line below, just comment it
// out.  If you're interested in profiling SS, then you need to install the APD
// package (find it on PECL)
//apd_set_pprof_trace();

// Load config file
require "../config/config.inc.php";

// Load SolidWorks
require BASE_PATH . "solidworks/solidworks.php";

// Load settings from database
require BASE_PATH . "util/settings.php";
load_settings( $conf );

// Remove any uninstalled modules from the database
require_once BASE_PATH . "modules/SolidStateModule.class.php";
removeMissingModules();

// Hand off to SolidWorks
solidworks( $conf, $smarty );
?>