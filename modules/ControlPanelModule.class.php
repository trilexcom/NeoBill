<?php
/**
 * ControlPanelModule.class.php
 *
 * This file contains the definition of the ControlPanelModule class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ControlPanelModule
 *
 * Provides an abstract base-class for SolidState Control Panel modules.
 *
 * @pacakge modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
abstract class ControlPanelModule extends SolidStateModule {
	/**
	 * @var string Server config page
	 */
	protected $serverConfigPage = "undefined";

	/**
	 * @var string Module type is "controlpanel"
	 */
	protected $type = "controlpanel";

	/**
	 * Create an Account
	 *
	 * Create a new control panel account
	 *
	 * @param ServerDBO $server The server to create the account on
	 * @param HostingServiceDBO $serviceDBO The hosting package to provision
	 * @param string $domainName The primary domain name for the new account
	 * @param string $username The account's username
	 * @param string $password The account's password
	 */
	abstract public function createAccount( ServerDBO $server,
			HostingServiceDBO $serviceDBO,
			$domainName,
			$username,
			$password );

	/**
	 * Get Server Config Page
	 *
	 * @return string The name of the server configuration page
	 */
	public function getServerConfigPage() {
		return $this->serverConfigPage;
	}

	/**
	 * Generate Random Control Panel Username
	 *
	 * This method generates a random secure password for auto-account creation.  If
	 * the control panel's criteria for a password are differant than what this
	 * function generates then it should be overidden by the module's implementation.
	 *
	 * @return string Randomly generated password
	 */
	public function generatePassword() {
		// Define the chars that can make up a password
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*/-=+";
		$numChars = strlen( $chars );

		// Seed the random number generator
		srand((double)microtime()*1000000);

		// Build a password
		$password = "";
		for ( $i = 0; $i < 7; $i++ ) {
			$password .= substr( $chars, rand() % $numChars, 1 );
		}

		return $password;
	}

	/**
	 * Kill an Account
	 *
	 * Remove an account from the server
	 *
	 * @param ServerDBO $server The server the account is on
	 * @param string $username The account's username
	 */
	abstract public function killAccount( ServerDBO $server, $username );

	/**
	 * Suspend an Account
	 *
	 * Suspend a control panel account
	 *
	 * @param ServerDBO $server The server the account is on
	 * @param string $username The account's username
	 */
	abstract public function suspendAccount( ServerDBO $server, $username );

	/**
	 * Un-suspend an Account
	 *
	 * Un-suspend a control panel account
	 *
	 * @param ServerDBO $server The server the account is on
	 * @param string $username The account's username
	 */
	abstract public function unsuspendAccount( ServerDBO $server, $username );
}
?>