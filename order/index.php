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
require_once "../config.inc.php";

// Load SolidWorks
require_once $base_path . "solidworks/solidworks.php";

// Hand off to SolidWorks
solidworks( $conf, $smarty );
?>