<?php
/**
 * functions.php
 *
 * This file contains all the functions called by the install program templates.
 *
 * @package Installer
 * @author Mark Chaney (MACscr) <mchaney@maximstudios.com>
 * @copyright Mark Chaney (MACscr) <mchaney@maximstudios.com>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

  function check_installed()
  {
      // See if installed flag is set.
      $in = @fopen('../config/config.inc.php', "r");
      if (!$in) {
          return false;
      }
      
      $i = 0;
      $isinstalled = false;
      $buf = array();
      while (!feof($in)) {
          $buf = eregi_replace(' ', '', strtolower(fgets($in, 4096)));
          if (!stristr($buf, '$config[\'installed\']=1;') === false) {
              $isinstalled = true;
          }
      }
      fclose($in);
      return $isinstalled;
  }

  function modify_install_status($installed)
  {
      $config_php = join('', file('../config/config.inc.php'));

		$installed = $_POST['installed'];
      
      $config_php = preg_replace('/\[\'installed\'\]\s*=\s*(\'|\")(.*)\\1;/', "['installed'] = '$installed';", $config_php);
     
      $fp = fopen('../config/config.inc.php', 'w+');
      fwrite($fp, $config_php);
      fclose($fp);
  }

  function modify_system_config($cache, $compiled)
  {
      $config_php = join('', file('../config/config.inc.php'));

		$cache = $_POST['cache'];
		$compiled = $_POST['compiled'];
      
      $config_php = preg_replace('/\[\'cache\'\]\s*=\s*(\'|\")(.*)\\1;/', "['cache'] = '$cache';", $config_php);
      $config_php = preg_replace('/\[\'compiled\'\]\s*=\s*(\'|\")(.*)\\1;/', "['compiled'] = '$compiled';", $config_php);
      
      $fp = fopen('../config/config.inc.php', 'w+');
      fwrite($fp, $config_php);
      fclose($fp);
  }
  
  function modify_db_config($host, $user, $pass, $database)
  {
      $config_php = join('', file('../config/config.inc.php'));

		$host = $_POST['host'];
		$user = base64_encode($_POST['user']);
		$pass = base64_encode($_POST['pass']);
		$database = $_POST['database'];

      $config_php = preg_replace('/\[\'host\'\]\s*=\s*(\'|\")(.*)\\1;/', "['host'] = '$host';", $config_php);
      $config_php = preg_replace('/\[\'user\'\]\s*=\s*(\'|\")(.*)\\1;/', "['user'] = '$user';", $config_php);
      $config_php = preg_replace('/\[\'pass\'\]\s*=\s*(\'|\")(.*)\\1;/', "['pass'] = '$pass';", $config_php);
      $config_php = preg_replace('/\[\'database\'\]\s*=\s*(\'|\")(.*)\\1;/', "['database'] = '$database';", $config_php);
      
      $fp = fopen('../config/config.inc.php', 'w+');
      fwrite($fp, $config_php);
      fclose($fp);
  }
  
  function load_db()
  {
      require_once '../config/config.inc.php';
      
      // Connecting, selecting database
      $link = mysql_connect($db['host'], base64_decode($db['user']), base64_decode($db['pass'])) or die('Could not connect: ' . mysql_error());
      echo _INSTALLERDBCONNECTED . ':<br /><br />';
      mysql_select_db($db['database']) or die( _INSTALLERDBSELECTFAILED );
      
      // Performing SQL query
      $sql_file = implode('', file('db/solid-state.mysql.sql'));
      
      // replace newlines with linux versions
      $sql_file = str_replace("\r", "\n", $sql_file);
      
      $sql_queries = explode(";\n", $sql_file);
      
      for ($i = 0; $i < count($sql_queries); $i++) 
	{
	  if( $sql_queries[$i] )
	    {
	      if( !($result = mysql_query($sql_queries[$i])) )
		{
		  // Ignore "empty query" messages
		  if( mysql_errno() != 1065 )
		    {
		      die( _INSTALLERDBQUERYFAILED . ': ' . mysql_error());
		    }
		}
	      echo _INSTALLERDBQUERYCOMPLETE . " $i <br />";
	    }
	}
      
      mysql_close($link);
      
      echo '<br /><br />' . _INSTALLERDBLOADED . '!<br /><br />';

  }

function create_admin_user($username, $password, $type, $firstname, $lastname, $email) {

		$username = $_POST['username'];
		$password = md5($_POST['user_password']);
		$type = $_POST['type'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$contactname = sprintf( "%s %s", $firstname, $lastname );

	require_once '../config/config.inc.php';
      
    // Connecting, selecting database
	mysql_connect($db['host'], base64_decode($db['user']), base64_decode($db['pass'])) or die('Could not connect: '.mysql_error());
	
	mysql_select_db($db['database']) or die('Could not select database');
	
	$sqlquery = "INSERT INTO `user` (`username`, `password`, `type`, `contactname`, `email`) VALUES ('$username', '$password', '$type', '$contactname', '$email')";
	mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );

	mysql_close();

	global $page, $percent;
	$page = "companyinfo";
	$percent = "80%";

}

function insert_company_info()
{
  $companyName = $_POST['name'];
  $companyEmail = $_POST['email'];
  $language = $_POST['language'];
  $currency = $_POST['currency'];
  $ns1 = $_POST['ns1'];
  $ns2 = $_POST['ns2'];
  $ns3 = $_POST['ns3'];
  $ns4 = $_POST['ns4'];

  require_once '../config/config.inc.php';

  mysql_connect($db['host'], base64_decode($db['user']), base64_decode($db['pass'])) or die('Could not connect: '.mysql_error());
  
  mysql_select_db($db['database']) or die('Could not select database');
  
  $sqlquery = "INSERT INTO `settings` VALUES ('company_name', '$companyName')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );

  $sqlquery = "INSERT INTO `settings` VALUES ('company_email', '$companyEmail')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  $sqlquery = "INSERT INTO `settings` VALUES ('company_notification_email', '$companyEmail')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  $sqlquery = "INSERT INTO `settings` VALUES ('locale_language', '$language')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  $sqlquery = "INSERT INTO `settings` VALUES ('locale_currency_symbol', '$currency')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  $sqlquery = "INSERT INTO `settings` VALUES ('nameservers_ns1', '$ns1')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  $sqlquery = "INSERT INTO `settings` VALUES ('nameservers_ns2', '$ns2')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  $sqlquery = "INSERT INTO `settings` VALUES ('nameservers_ns3', '$ns3')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  $sqlquery = "INSERT INTO `settings` VALUES ('nameservers_ns4', '$ns4')";
  mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );
  
  mysql_close();
  
  global $page, $percent;
  $page = "complete";
  $percent = "100%";
}

switch ($_POST['function']){
	case "system_config":
		modify_system_config($cache, $compiled);
	//	header("Location:index.php?page=db_setup");
		break;	
	case "db_config":
		modify_db_config($host, $user, $pass, $database);
		break;	
	case "create_admin":
		create_admin_user($username, $password, $type, $firstname, $lastname, $email);
		modify_install_status('1');
	//	header("Location:index.php?page=complete");
		break;
        case "insert_company_info":
	  insert_company_info( $name, $email );
	  break;
}

if ($_POST['loader'] == "db_import"){

		$install_step = "4";
		$page = "db_import";
		$percent = "40%";
}


switch ($_POST['install_step']){
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
		$page = "create_admin";
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
}

  
?>
