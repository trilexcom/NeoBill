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

// Load config file
require_once "../config/config.inc.php";

// Load SolidWorks
require_once $base_path . "solidworks/solidworks.php";

// Load settings from database
require_once $base_path . "util/settings.php";
load_settings( $conf );

// Remove any uninstalled modules from the database
require_once $base_path . "modules/SolidStateModule.class.php";
removeMissingModules();

// Hand off to SolidWorks
solidworks( $conf, $smarty );

?>