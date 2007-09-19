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

  // Modify config.inc.php to show that Solid State has already been installed
  function modify_install_status()
  {
      $config_php = join('', file('../config/config.inc.php'));

	//	$installed = $_POST['installed'];

      $config_php = preg_replace('/\[\'installed\'\]\s*=\s*\'0\'\s*;/', "['installed'] = '1';", $config_php);
      //$config_php = preg_replace('#\[\'installed\'\]( *)=(*)(\'|\")(.*)$3;#', "['installed'] = '$installed';", $config_php);  
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
  
  function verify_email ($email)
  {     
        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i",$email))
                return false;

        return true;
  }

  function load_db()
  {
      require_once '../config/config.inc.php';
      
      // Connecting, selecting database
      $link = mysql_connect($db['host'], base64_decode($db['user']), base64_decode($db['pass']));

      if (!$link){
         return mysql_error();

        }

      if(!mysql_select_db($db['database'])) {
                

                if ($_POST['createdb'] == 'on')
                {
                        if(!mysql_query('create database '.$db['database']))
                                 return mysql_error();                       

                        if(!mysql_select_db($db['database']))
                                 return mysql_error();
                }
                else
                        return _INSTALLERDBSELECTFAILED;
        
                
       }
      
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
		      return _INSTALLERDBQUERYFAILED . ': ' . mysql_error();
                      
		    }
		}
	      //echo _INSTALLERDBQUERYCOMPLETE . " $i <br />";
	    }
	}
      
      mysql_close($link);
      
      return '';

  }

function create_admin_user($username, $password, $type, $firstname, $lastname, $email) {

		$username = $_POST['username'];
		$password = md5($_POST['user_password']);
                $verifypass = md5($_POST['passverify']);
		$type = $_POST['type'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
                $msg = '';
        
        if (!verify_email($email))
        {       
                global $page, $percent, $msg;                
        	$page = "create_admin";
        	$percent = "60%";                
                $msg = _INSTALLERINVALIDEMAIL;
                
        }
        
        if ($password != $verifypass)
        {       
       
        	global $page, $percent, $msg;                
        	$page = "create_admin";
        	$percent = "60%";                
                $msg = _INSTALLERPASSWORDCOMPAREFAILED;
                
        }

        if ($username == '' || $password == md5(''))
        {       
                
        	global $page, $percent, $msg;
        	$page = "create_admin";
        	$percent = "60%";                
                $msg = _INSTALLERADMINFILLDETAILS;
        }


 
        if ($msg == '')
        {      
                require_once "../config/config.inc.php";
                // Connecting, selecting database
        	mysql_connect($db['host'], base64_decode($db['user']), base64_decode($db['pass'])) or die('Could not connect: '.mysql_error());
        	
        	mysql_select_db($db['database']) or die('Could not select database');
        	
        	$sqlquery = "INSERT INTO `user` (`username`, `password`, `type`, `firstname`, `lastname`, `email`) VALUES ('$username', '$password', '$type', '$firstname', '$lastname', '$email')";
        	mysql_query( $sqlquery ) or die ('Query failed: ' . mysql_error() );

        	mysql_close();

        	global $page, $percent;
        	$page = "companyinfo";
        	$percent = "80%";
        }

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

   if (!verify_email($companyEmail))
   {       
        global $page, $percent, $msg;                
	$page = "companyinfo";
	$percent = "80%";                
        $msg = _INSTALLERINVALIDEMAIL;
                
    }

  else
     
  if ($companyName == '' || $companyEmail == '' || $currency == '' || $ns1 =='' || $ns2 = '')
  {       

  	global $page, $percent, $msg;
	$page = "companyinfo";
	$percent = "80%";                
        $msg = _INSTALLERFILLCOMPANYDETAILS;
        
  }
  else
  {      

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

}

function get_installer_languages()
{
        $files = scandir('lang');
        $i = 0;
        foreach ($files as $key=>$value){

                if(file_exists('lang/'.$value.'/global.php'))
                {
                
                        $languages[$i] = $value;
                        $i++;
                
                }        
        }
        return $languages;
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
	//	modify_install_status('1');
	//	header("Location:index.php?page=complete");
		break;
        case "insert_company_info":
	  insert_company_info();
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
