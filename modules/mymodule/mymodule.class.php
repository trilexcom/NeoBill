<?php
require_once BASE_PATH . "modules/SolidStateModule.class.php";
class MyModule extends SolidStateModule {
	var $name = "Sample Module";
	var $sDescription = "This is the sample module";
	var $description = "This is the sample module";
	var $type = "sample type";
	
	/**
	 * Initialize Module
	 *
	 * Invoked when the module is loaded.  Call the parent method first, then
	 * load settings.
	 *
	 * @return boolean True for success
	 */
	function init() {
		parent::init();

	}

	/**
	 * Install Module
	 *
	 * Invoked when the module is installed.  Calls the parent first, which does
	 * most of the work, then saves the default settings to the DB.
	 */
	function install() {
		parent::install();

		$this->saveSettings();
	}

	
	function saveSettings() {
	}

}
?>