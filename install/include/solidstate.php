<?php
/*
 * @(#)install/include/solidstate.php
 *
 *    Version: 0.50.20090331
 * Written by: Mark Chaney (MACscr) <mailto:mchaney@maximstudios.com>
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
 * Copyright (C) 2001-2008 by Mark Chaney
 * Copyright (C) 2009 by Yves Kreis
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the 
 * Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */

  function check_installed() {
    $file = fopen('../config/config.inc.php', 'r');
    if (!$file) {
      return false;
    }
    
    $buffer = array();
    $installed = false;
    while (!feof($file)) {
      $buffer = eregi_replace(' ', '', strtolower(fgets($file, 4096)));
      if (!stristr($buffer, '$config[\'installed\']=1;') === false) {
        $installed = true;
      }
    }
    fclose($file);
    return $installed;
  }
  
  function modify_config_install() {
    $config_php = join('', file('../config/config.inc.php'));
    
    $config_php = preg_replace('/\[\'installed\'\]\s*=\s*(.*);/', "['installed'] = 1;", $config_php);
    
    $fp = fopen('../config/config.inc.php', 'w+');
    fwrite($fp, $config_php);
    fclose($fp);
  }
  
  function modify_config_db() {
    $config_php = join('', file('../config/config.inc.php'));
    
    if (get_magic_quotes_gpc()) {
      $hostname = stripslashes($_POST['hostname']);
      $username = stripslashes($_POST['username']);
      $password = base64_encode(stripslashes($_POST['password']));
      $database = stripslashes($_POST['database']);
    } else {
      $hostname = $_POST['hostname'];
      $username = $_POST['username'];
      $password = base64_encode($_POST['password']);
      $database = $_POST['database'];
    }
    
    $config_php = preg_replace('/\[\'hostname\'\]\s*=\s*(\'|\")(.*)(\'|\");/', "['hostname'] = '$hostname';", $config_php);
    $config_php = preg_replace('/\[\'username\'\]\s*=\s*(\'|\")(.*)(\'|\");/', "['username'] = '$username';", $config_php);
    $config_php = preg_replace('/\[\'password\'\]\s*=\s*(\'|\")(.*)(\'|\");/', "['password'] = '$password';", $config_php);
    $config_php = preg_replace('/\[\'database\'\]\s*=\s*(\'|\")(.*)(\'|\");/', "['database'] = '$database';", $config_php);
    
    $fp = fopen('../config/config.inc.php', 'w+');
    fwrite($fp, $config_php);
    fclose($fp);
  }
  
  function modify_config_system() {
    $config_php = join('', file('../config/config.inc.php'));
    
    if (get_magic_quotes_gpc()) {
      $cache    = stripslashes($_POST['cache']);
      $compiled = stripslashes($_POST['compiled']);
    } else {
      $cache    = $_POST['cache'];
      $compiled = $_POST['compiled'];
    }
    
    $config_php = preg_replace('/\[\'cache\'\]\s*=\s*(\'|\")(.*)(\'|\");/', "['cache']     = '$cache';", $config_php);
    $config_php = preg_replace('/\[\'compiled\'\]\s*=\s*(\'|\")(.*)(\'|\");/', "['compiled']  = '$compiled';", $config_php);
    
    $fp = fopen('../config/config.inc.php', 'w+');
    fwrite($fp, $config_php);
    fclose($fp);
  }
  
  function init_db() {
    require_once '../config/config.inc.php';
    
    if (!mysql_connect($db['hostname'], $db['username'], base64_decode($db['password']))) {
      return _INSTALLERDBCONNECTFAILED . ': ' . mysql_error();
    }
    
    if (!mysql_query("set names 'utf8' collate 'utf8_general_ci';")) {
      return _INSTALLERDBNAMESFAILED . ': ' . mysql_error();
    }
    
    if (!mysql_select_db($db['database'])) {
      if (isset($_POST['create']) && $_POST['create'] == 'on') {
        if (!mysql_query('create database ' . $db['database'] . ';')) {
          return _INSTALLERDBCREATEFAILED . ': ' . mysql_error();
        }
        if (!mysql_select_db($db['database'])) {
          return _INSTALLERDBSELECTFAILED . ': ' . mysql_error();
        }
      } else {
        return _INSTALLERDBSELECTFAILED . ': ' . mysql_error();
      }
    }
    
    $sql_file = implode('', file('database/solidstate.mysql'));
    $sql_queries = explode(";\n", $sql_file);
    for ($i = 0; $i < count($sql_queries); $i++) {
      if (!mysql_query($sql_queries[$i])) {
        if (mysql_errno() != 1065) {
          return _INSTALLERDBQUERYFAILED . ': ' . mysql_error();
        }
      }
    }
    
    mysql_close();
    
    return '';
  }
  
  function valid_email($_email) {
    return preg_match('/^[A-Za-z0-9\&\'\+\-\_]+(\.[A-Za-z0-9\&\'\+\-\_]+)*@[A-Za-z0-9\-]+\.([A-Za-z0-9\-]+\.)*?[A-Za-z]+$/', stripslashes($_email));
  }
  
  function create_admin() {
    global $message;
    
    if ('' == $_POST['username'] || '' == $_POST['password-1'] || '' == $_POST['email']) {
      $_POST['install_step'] = '4';
      $message = _INSTALLERREQUIREDFIELDSKO;
      return;
    }
    
    if ($_POST['password-1'] != $_POST['password-2']) {
      $_POST['install_step'] = '4';
      $message = _INSTALLERPASSWORDSMATCHKO;
      return;
    }
    
    if (!valid_email($_POST['email'])) {
      $_POST['install_step'] = '4';
      $message = _INSTALLERVALIDEMAILKO;
      return;
    }
    
    if (get_magic_quotes_gpc()) {
      $firstname = $_POST['firstname'];
      $lastname  = $_POST['lastname'];
      $username  = $_POST['username'];
      $password  = md5(stripslashes($_POST['password-1']));
      $email     = $_POST['email'];
    } else {
      $firstname = addslashes($_POST['firstname']);
      $lastname  = addslashes($_POST['lastname']);
      $username  = addslashes($_POST['username']);
      $password  = md5($_POST['password-1']);
      $email     = addslashes($_POST['email']);
    }
    $contactname = $firstname . ' ' . $lastname;
    
    require_once '../config/config.inc.php';
    mysql_connect($db['hostname'], $db['username'], base64_decode($db['password'])) or die(_INSTALLERDBCONNECTFAILED . ': ' . mysql_error());
    mysql_query("set names 'utf8' collate 'utf8_general_ci';") or die(_INSTALLERDBNAMESFAILED . ': ' . mysql_error());
    mysql_select_db($db['database']) or die(_INSTALLERDBSELECTFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `user` (`username`, `password`, `type`, `name`, `email`, `language`) VALUES ('$username', '$password', 'Administrator', '$contactname', '$email', '{$_COOKIE['language']}');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_close();
  }
  
  function create_company() {
    global $message;
    
    if ('' == $_POST['company'] || '' == $_POST['email'] || '' == $_POST['currency'] || '' == $_POST['nameserver-1'] || '' == $_POST['nameserver-2']) {
      $_POST['install_step'] = '5';
      $message = _INSTALLERREQUIREDFIELDSKO;
      return;
    }
    
    if (!valid_email($_POST['email'])) {
      $_POST['install_step'] = '5';
      $message = _INSTALLERVALIDEMAILKO;
      return;
    }
    
    if (get_magic_quotes_gpc()) {
      $company     = $_POST['company'];
      $email       = $_POST['email'];
      $currency    = $_POST['currency'];
      $nameserver_1 = $_POST['nameserver-1'];
      $nameserver_2 = $_POST['nameserver-2'];
      $nameserver_3 = $_POST['nameserver-3'];
      $nameserver_4 = $_POST['nameserver-4'];
    } else {
      $company     = addslashes($_POST['company']);
      $email       = addslashes($_POST['email']);
      $currency    = addslashes($_POST['currency']);
      $nameserver_1 = addslashes($_POST['nameserver-1']);
      $nameserver_2 = addslashes($_POST['nameserver-2']);
      $nameserver_3 = addslashes($_POST['nameserver-3']);
      $nameserver_4 = addslashes($_POST['nameserver-4']);
    }
    
    require_once '../config/config.inc.php';
    mysql_connect($db['hostname'], $db['username'], base64_decode($db['password'])) or die(_INSTALLERDBCONNECTFAILED . ': ' . mysql_error());
    mysql_query("set names 'utf8' collate 'utf8_general_ci';") or die(_INSTALLERDBNAMESFAILED . ': ' . mysql_error());
    mysql_select_db($db['database']) or die(_INSTALLERDBSELECTFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('company_name', '$company');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('email_contact', '$email');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('email_notification', '$email');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('locale_language', '{$_COOKIE['language']}');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('locale_currency', '$currency');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('nameserver_1', '$nameserver_1');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('nameserver_2', '$nameserver_2');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('nameserver_3', '$nameserver_3');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_query("INSERT INTO `settings` (`setting`, `value`) VALUES ('nameserver_4', '$nameserver_4');") or die(_INSTALLERDBQUERYFAILED . ': ' . mysql_error());
    mysql_close();
  }
  
  function get_languages_installer() {
    $languages = array();
    
    if ($dh = @opendir('./languages/')) {
      while (false != ($file = readdir($dh))) {
        if ('.' != $file && '..' != $file && 'index.php' != $file && 4 < strlen($file)) {
          $languages[count($languages)] = substr($file, 0, strlen($file) - 4);
        }
      }
      closedir($dh);
    }
    
    return $languages;
  }
  
  if (check_installed()) {
    unset($_POST['function']);
    $_POST['install_step'] = '6';
  }
  
  if (isset($_POST['function'])) {
    switch ($_POST['function']) {
      case 'config_system':
        modify_config_system();
        break;
      case 'config_db':
        modify_config_db();
        break;
      case 'create_admin':
        create_admin();
        break;
      case 'create_company':
        create_company();
        break;
    }
  }
  
  if (isset($_POST['install_step'])) {
    switch ($_POST['install_step']) {
      case '0':
        $page = 'welcome';
        $percent = '0%';
        break;
      case '1':
        $page = 'license';
        $percent = '0%';
        break;
      case '2':
        $page = 'requirements';
        $percent = '20%';
        break;
      case '3':
        if (isset($_POST['function']) && $_POST['function'] == 'config_db') {
          $page = 'database_init';
        } else {
          $page = 'database_config';
        }
        $percent = '40%';
        break;
      case '4':
        $page = 'create_admin';
        $percent = '60%';
        break;
      case '5':
        $page = 'create_company';
        $percent = '80%';
        break;
      case '6':
        $page = 'complete';
        $percent = '100%';
        break;
    }
  }
?>