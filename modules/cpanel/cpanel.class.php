<?php
/**
 * CpanelModule.class.php
 *
 * This file contains the definition of the CpanelModule class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "modules/ControlPanelModule.class.php";

// cPanel Module DBO's
require_once BASE_PATH . "modules/cpanel/CPanelServerDBO.class.php";

/**
 * CpanelModule
 *
 * Provides a ControlPanel module implementation for CPanel.
 *
 * @pacakge modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
class Cpanel extends ControlPanelModule
{
  /**
   * @var string Configuration page
   */
  protected $configPage = "cp_config";

  /**
   * @var string Long description
   */
  protected $description = "cPanel Control Panel Module";

  /**
   * @var string Path to the cPanel "Accounting.php.inc" library
   */
  protected $libPath = "/usr/local/cpanel/Cpanel/Accounting.php.inc";

  /**
   * @var string Module name
   */
  protected $name = "cpanel";

  /**
   * @var string Short description
   */
  protected $sDescription = "cPanel";

  /**
   * @var string Server Configuration page (Manager interface)
   */
  protected $serverConfigPage = "cp_server_config";

  /**
   * @var string Module type is "controlpanel"
   */
  protected $type = "controlpanel";

  /**
   * @var integer Version
   */
  protected $version = 1;

  /**
   * Create an Account
   */
  public function createAccount( ServerDBO $serverDBO,
				 HostingServiceDBO $serviceDBO,
                                 $domainName,
				 $username,
				 $password )
  {
    $CPServerDBO = $this->getCPanelServerDBO( $serverDBO );
    $result = createacct( $serverDBO->getHostName(),
			  $CPServerDBO->getUsername(),
			  $CPServerDBO->getAccessHash(),
			  false,
			  $domainName,
			  $username,
			  $password,
			  $serviceDBO->getTitle() );

    if( null == stristr( $result, "wwwacct creation finished" ) )
      {
	throw new SWUserException( "[CPANEL_FAILED_TO_CREATE_ACCOUNT]: " .
				   $result );
      }
  }

  /**
   * Install cPanel Module Database Tables
   */
  public function createTables()
  {
    $DB = DBConnection::getDBConnection();

    // Wipe out old tables
    $sql = "DROP TABLE IF EXISTS `cpanelserver`";
    if( !mysql_query( $sql, $DB->handle() ) )
      {
	return false;
      }

    // Create new ones
    $sql = "CREATE TABLE `cpanelserver` (" .
      "`serverid` int(10) unsigned NOT NULL default '0'," .
      "`username` varchar(255) NOT NULL default ''," .
      "`accesshash` text NOT NULL," .
      "PRIMARY KEY  (`serverid`)" .
      ") TYPE=MyISAM;";

    return mysql_query( $sql, $DB->handle() );
  }

  /**
   * Get CPanel Server DBO
   *
   * Given a server DBO, retrieves the associated CPanel Server DBO
   *
   * @param ServerDBO The server to query
   */
  protected function getCPanelServerDBO( ServerDBO $serverDBO )
  {
    return load_CPanelServerDBO( $serverDBO->getID() );
  }

  /**
   * Get Path to CPanel Library
   *
   * @return string Path to the CPanel Accounting.php.inc library
   */
  public function getLibPath() { return $this->libPath; }

  /**
   * Initialize cPanel Module
   *
   * Invoked when the module is loaded.  Call the parent method first, then
   * load settings.
   *
   * @return boolean True for success
   */
  public function init()
  {
    global $page;
    parent::init();

    // Load Settings
    $this->setLibPath( $this->moduleDBO->loadSetting( "cpanel_libpath" ) );

    // Include the Cpanel library
    if( $this->isEnabled() )
      {
	if( !@fopen( $this->libPath, "r" ) )
	  {
	    $this->disable();
	    printf( "Failed to open cPanel library: %s.  Module has been disabled.",
		    $this->libPath );
	  }
	else
	  {
	    require $this->libPath;
	  }
      }
  }

  /**
   * Install cPanel Module
   *
   * Invoked when the module is installed.  Calls the parent first, which does
   * most of the work, then saves the default settings to the DB.
   */
  public function install()
  {
    parent::install();

    if( !$this->createTables() )
      {
	throw new ModuleInstallFailedException( "cpanel", 
						"Failed to create database tables for cPanel module: " .
						mysql_error() );
      }

    $this->saveSettings();
  }

  /**
   * Kill an Account
   *
   * Remove an account from the server
   *
   * @param ServerDBO $server The server the account is on
   * @param string $username The account's username
   */
  public function killAccount( ServerDBO $server, $username )
  {
    $CPServerDBO = $this->getCPanelServerDBO( $server );
    $result = killacct( $server->getHostName(),
			$CPServerDBO->getUsername(),
			$CPServerDBO->getAccessHash(),
			false,
			$username );

    if( null == stristr( $result, "Ftp vhost passwords synced" ) )
      {
	if( stristr( $result, 
		     sprintf( "Warning!.. system user %s does not exist!",
			      $username ) ) )
	  {
	    throw new SWUserException( "[CPANEL_ACCOUNT_DOES_NOT_EXIST]" );
	  }
	else
	  {
	    throw new SWUserException( "[CPANEL_FAILED_TO_TERMINATE_ACCOUNT]: " .
				       $result );
	  }
      }
  }

  /**
   * Save cPanel Settings
   */
  public function saveSettings()
  {
    $this->moduleDBO->saveSetting( "cpanel_libpath", $this->getLibPath() );
  }

  /**
   * Set Library Path
   *
   * @param string Path to cPanel's Accounting.inc.php library
   */
  public function setLibPath( $libPath ) { $this->libPath = $libPath; }

  /**
   * Suspend an Account
   *
   * Suspend a control panel account
   *
   * @param ServerDBO $server The server the account is on
   * @param string $username The account's username
   */
  public function suspendAccount( ServerDBO $server, $username )
  {
    $CPServerDBO = $this->getCPanelServerDBO( $server );
    $result = suspend( $server->getHostName(),
		       $CPServerDBO->getUsername(),
		       $CPServerDBO->getAccessHash(),
		       false,
		       $username );

    if( null == stristr( $result, "account has been suspended" ) )
      {
	if( stristr( $result, "Account Already Suspended" ) )
	  {
	    throw new SWUserException( "[CPANEL_ACCOUNT_HAS_ALREADY_BEEN_SUSPENDED]" );
	  }
	else
	  {
	    throw new SWUserException( "[CPANEL_FAILED_TO_SUSPEND_ACCOUNT]: " .
				       $result );
	  }
      }
  }

  /**
   * Un-suspend an Account
   *
   * Un-suspend a control panel account
   *
   * @param ServerDBO $server The server the account is on
   * @param string $username The account's username
   */
  public function unsuspendAccount( ServerDBO $server, $username )
  {
    $CPServerDBO = $this->getCPanelServerDBO( $server );
    $result = unsuspend( $server->getHostName(),
			 $CPServerDBO->getUsername(),
			 $CPServerDBO->getAccessHash(),
			 false,
			 $username );

    if( null == stristr( $result, "account is now active" ) )
      {
	throw new SWUserException( "[CPANEL_FAILED_TO_UNSUSPEND_ACCOUNT]: " .
				   $result );
      }
  }
}
?>