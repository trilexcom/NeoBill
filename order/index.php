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

// Load config file
require_once "../config/config.inc.php";

// Load SolidWorks
require_once BASE_PATH . "solidworks/solidworks.php";

// Load settings from database
require_once BASE_PATH . "util/settings.php";
load_settings( $conf );

// Hand off to SolidWorks
solidworks( $conf, $smarty );
?>