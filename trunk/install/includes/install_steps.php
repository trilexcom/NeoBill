<?php
/**
 * install_steps.php
 *
 * This file makes the decision of which page to load based on the install_step
 * request parameter.
 *
 * @package Installer
 * @author Mark Chaney (MACscr) <mchaney@maximstudios.com>
 * @copyright Mark Chaney (MACscr) <mchaney@maximstudios.com>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

$install_step = $_REQUEST['install_step'];

//$install_step = "0";
//	$page = "welcome";
//	$percent = "0";	

switch ($install_step){
	case "0":
		$page = "welcome";
		$percent = "0%";
		break;	
	case "1":
		$page = "license";
		$percent = "0%";
		break;	
	case "2":
		$page = "requirements";
		$percent = "20%";
		break;	
	case "3":
		$page = "db_setup";
		$percent = "40%";
		break;	
	case "4":
		$page = "createadmin";
		$percent = "60%";
		break; 	
	case "5":
		$page = "companyinfo";
		$percent = "80%";
		break; 
	case "6":
		$page = "complete";
		$percent = "100%";
		break; 
	default:
		$page = "welcome";
		$percent = "0%";
		break; 	
}

?>