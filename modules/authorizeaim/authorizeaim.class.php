<?php
/**
 * AuthorizeAIM.class.php
 *
 * This file contains the definition of the AuthorizeAIM class.
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
  * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 * @author #2 Xiao Zhao/Mat <john316rocks@gmail.com>
 */

// Base class
require_once BASE_PATH . "modules/PaymentGatewayModule.class.php";

// New Authorize.net SDK code
define("AUTHORIZENET_SANDBOX", TRUE); // TRUE for TEST, FALSE for real dough
require_once BASE_PATH . "modules/authorizeaim/sdk/AuthorizeNet.php";

// Positions in the AIM response record
define( AIM_RESP_CODE, 0 );
define( AIM_RESP_REASON_TEXT, 3 );
define( AIM_RESP_APPROVAL_CODE, 5 );
define( AIM_RESP_TRANSACTION_ID, 6 );

// AIM Response codes
define( AIM_APPROVED, "1" );
define( AIM_DECLINED, "2" );
define( AIM_ERROR,    "3" );

/**
 * AuthorizeAIM
 *
 * Provides an implementation of a PaymentGateway module for Authorize.net's
 * Advanced Integration Method (AIM).
 *
 * @package modules
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AuthorizeAIM extends PaymentGatewayModule {
	/**
	 * @var string Authorize.net API version
	 */
	var $APIVersion = "3.1";

	/**
	 * @var string Configuration page
	 */
	var $configPage = "aaim_config";

	/**
	 * @var string Delimiter character
	 */
	var $delimiter = "|";

	/**
	 * @var string Long description
	 */
	var $description = "Authorize.net Advanced Integration Method (AIM) Payment Gateway Module";

	/**
	 * @var string Authorize.net Login ID
	 */
	var $loginID = "login id";

	/**
	 * @var string Module name
	 */
	var $name = "authorizeaim";

	/**
	 * @var string Short description
	 */
	var $sDescription = "Credit Card";

	/**
	 * @var string Authorize.net transaction key
	 */
	var $transactionKey = "transaction key";

	/**
	 * @var string Authorize.net URL
	 */
	var $url = "https://secure.authorize.net/gateway/transact.dll";

	/**
	 * @var integer Version
	 */
	var $version = 1;

	/**
	 * Authorize a Credit Card Transaction
	 *
	 * @param ContactDBO $contactDBO Billing contact
	 * @param string $cardNumber Credit card number (XXXXXXXXXXXXXXXXXXXX)
	 * @param string $expireDate CC expiration date (MMYY)
	 * @param string $cardCode CVV2/CVC2/CID code
	 * @param PaymentDBO $paymentDBO Payment DBO for this transaction
	 * @return boolean False when there is an error processing the transaction
	 */
	function authorize( $contactDBO, $cardNumber, $expireDate, $cardCode, &$paymentDBO ) {
		// The charge method does the actual work (notice the auth only flag)
		return $this->charge( $contactDBO,
				$cardNumber,
				$expireDate,
				$cardCode,
				$paymentDBO,
				true );
	}

	/**
	 * Authorize and Capture a Credit Card Transaction
	 *
	 * @param ContactDBO $contactDBO Billing contact
	 * @param string $cardNumber Credit card number (XXXXXXXXXXXXXXXXXXXX)
	 * @param string $expireDate CC expiration date (MMYY)
	 * @param string $cardCode CVV2/CVC2/CID code
	 * @param PaymentDBO $paymentDBO Payment DBO for this transaction
	 * @return boolean False when there is an error processing the transaction
	 */
	function authorizeAndCapture( $contactDBO, $cardNumber, $expireDate, $cardCode, &$paymentDBO ) {
		// The charge method does the actual work (notice the auth only flag)
		return $this->charge( $contactDBO,
				$cardNumber,
				$expireDate,
				$cardCode,
				$paymentDBO,
				false );
	}

	/**
	 * Build POST Fields
	 *
	 * Convert an array of key => values into a POST string
	 *
	 * @param array $params Key => Value array
	 * @return string POST data
	 */
	function buildPOSTFields( $params ) {
		$fields = "";
		foreach( $params as $key => $value ) {
			$fields .= sprintf( "%s=%s&", $key, urlencode( $value ) );
		}
		return $fields;
	}

	/**
	 * Capture a Previously Authorized Transaction
	 *
	 * @param PaymentDBO $paymentDBO Previously authorized payment DBO
	 * @return boolean False on a processing error
	 */
	function capture( &$paymentDBO ) {
		$message =
				$this->buildPOSTFields( array( "x_login"  => $this->getLoginID(),
				"x_version" => $this->getAPIVersion(),
				"x_delim_char" => $this->getDelimiter(),
				"x_delim_data" => "TRUE",
				"x_type" => "PRIOR_AUTH_CAPTURE",
				"x_method" => "CC",
				"x_tran_key" => $this->getTransactionKey(),
				"x_trans_id" => $paymentDBO->getTransaction1(),
				"x_amount" => $paymentDBO->getAmount() ) );

		// Carry out the transaction
		$resp = $this->executeTransaction( $message );

		// Parse the transaction response
		switch ( $resp[AIM_RESP_CODE] ) {
			case AIM_APPROVED:
				$paymentDBO->setStatus( "Completed" );
				$paymentDBO->setTransaction1( $resp[AIM_RESP_TRANSACTION_ID] );
				$paymentDBO->setTransaction2( $resp[AIM_RESP_APPROVAL_CODE] );
				break;

			case AIM_DECLINED:
				$paymentDBO->setStatus( "Declined" );
				$paymentDBO->setStatusMessage( substr( $resp[AIM_RESP_REASON_TEXT], 0, 255 ) );
				break;

			case AIM_ERROR:
			default:
				log_error( "AuthorizeAIM::capture()",
						"An error occured while processing an Authorize.net transaction: " .
						$resp[AIM_RESP_REASON_TEXT] );
				return false;
				break;
		}

		return true;
	}

	/**
	 * Authorize, or Authorize and Capture a Credit Card Transaction
	 *
	 * @param ContactDBO $contactDBO Billing contact
	 * @param string $cardNumber Credit card number (XXXXXXXXXXXXXXXXXXXX)
	 * @param string $expireDate CC expiration date (MMYY)
	 * @param string $cardCode CVV2/CVC2/CID code
	 * @param PaymentDBO $paymentDBO Payment DBO for this transaction
	 * $param boolean $authOnly When true, the transaction will be authorized only
	 * @return boolean False when there is an error processing the transaction
	 */
	function charge( $contactDBO, $cardNumber, $expireDate, $cardCode, &$paymentDBO, $authOnly ) {
		// Build PaymentDBO
		$paymentDBO->setDate( DBConnection::format_datetime( time() ) );
		$paymentDBO->setType( "Module" );
		$paymentDBO->setModule( $this->getName() );
		
		/* old busted method
		// Construct a list of parameters to be passed to Authorize.net
		$message =
				$this->buildPOSTFields( array( "x_login"  => $this->getLoginID(),
				"x_version" => $this->getAPIVersion(),
				"x_delim_char" => $this->getDelimiter(),
				"x_delim_data" => "TRUE",
				"x_type" => $authOnly ? "AUTH_ONLY" : "AUTH_CAPTURE",
				"x_method" => "CC",
				"x_tran_key" => $this->getTransactionKey(),
				"x_card_num" => $cardNumber,
				"x_exp_date" => $expireDate,
				"x_amount" => $paymentDBO->getAmount(),
				"x_card_code" => $cardCode,
				"x_first_name" => substr( $contactDBO->getName(), 0, 50 ),
				"x_address" => substr( sprintf( "%s %s",
				$contactDBO->getAddress1(),
				$contactDBO->getAddress2() ),
				0,
				60 ),
				"x_city" => substr( $contactDBO->getCity(), 0, 40 ),
				"x_state" => substr( $contactDBO->getState(), 0, 40 ),
				"x_zip" => substr( $contactDBO->getPostalCode(), 0, 20 ),
				"x_country" => substr( $contactDBO->getCountry(), 0, 60 ),
				"x_phone" => substr( $contactDBO->getPhone(), 0, 25 ),
				"x_fax" => substr( $contactDBO->getFax(), 0, 25 ) ) );
		
		// Carry out the transaction
		$resp = $this->executeTransaction( $message );
		*/
				
		// New SDK method
		//$transaction = new AuthorizeNetAIM($this->getLoginID(), $this->getTransactionKey());
		
		/*
		$transaction->amount = $paymentDBO->getAmount();
		$transaction->card_num = $cardNumber;
		$transaction->exp_date = $expireDate;
		 
		$customerData = (object) array();
		$customerData->first_name = substr( $contactDBO->getName(), 0, 50 );
		$customerData->address = substr( sprintf( "%s %s",
				$contactDBO->getAddress1(),
				$contactDBO->getAddress2() ),
				0,
				60 );
		$customerData->city = substr( $contactDBO->getCity(), 0, 40 );
		$customerData->state = substr( $contactDBO->getState(), 0, 40 );
		$customerData->zip = substr( $contactDBO->getPostalCode(), 0, 20 );
 
		$transaction->setFields($customerData);
		*/

		$transaction = new AuthorizeNetAIM('95n98SqG5', '4gc88U7xV5g78TYU');
		$transaction->amount = '9.99';
		$transaction->card_num = '4007000000027';
		$transaction->exp_date = '10/16';
		
		$response = $transaction->authorizeAndCapture();
		
		if ($response->approved) {
			echo "<h1>Success! The test credit card has been charged!</h1>";
			echo "Transaction ID: " . $response->transaction_id;
		} else {
			echo $response->error_message;
		}
		// Parse the transaction response
		switch ( $response ) {
			case AIM_APPROVED:
				$paymentDBO->setStatus( $authOnly ? "Authorized" : "Completed" );
				$paymentDBO->setTransaction1( $resp[AIM_RESP_TRANSACTION_ID] );
				$paymentDBO->setTransaction2( $resp[AIM_RESP_APPROVAL_CODE] );
				if ( !$this->saveTransaction( $resp[AIM_RESP_TRANSACTION_ID],
				substr( $cardNumber, -1, 4 ) ) ) {
					fatal_error( "AuthorizeAIM::authorize",
							"Failed to save transaction data: " );
				}

				break;

			case AIM_DECLINED:
				$paymentDBO->setStatus( "Declined" );
				$paymentDBO->setStatusMessage( $resp[AIM_RESP_REASON_TEXT] );
				break;

			case AIM_ERROR:
				log_error( "AuthorizeAIM::authorize()",
						"An error occured while processing an Authorize.net transaction: " .
						$resp[AIM_RESP_REASON_TEXT] );
				return false;
				break;
		}

		return true;
	}

	/**
	 * Create Module's Database Tables
	 *
	 * @return boolean True for success
	 */
	function createTables() {
		$DB = DBConnection::getDBConnection();

		// Wipe out old tables
		$sql = "DROP TABLE IF EXISTS `authorizeaim`";
		if ( !mysql_query( $sql, $DB->handle() ) ) {
			return false;
		}

		// Create new ones
		$sql = "CREATE TABLE IF NOT EXISTS `authorizeaim` ( " .
				"`transid` varchar(10) NOT NULL, " .
				"`lastdigits` varchar(4) NOT NULL, " .
				"PRIMARY KEY  (`transid`)" .
				") ENGINE=MyISAM DEFAULT CHARSET=latin1";
		return mysql_query( $sql, $DB->handle() );
	}

	/**
	 * Execute Transaction
	 *
	 * Post transaction to Authorize.net using the PHP Curl extensions
	 *
	 * @param string $postData POST data (use buildPOSTFields)
	 * @return array Response record, broken into an associative array
	 */
	function executeTransaction( $postData ) {

		$ch = curl_init( $this->getURL() );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, rtrim( $postData, "& " ) );
		$resp = curl_exec( $ch );
		curl_close( $ch );

		return explode( $this->getDelimiter(), $resp );
	}

	/**
	 * Get API Version
	 *
	 * @return string The version of the AIM API that is being used
	 */
	function getAPIVersion() {
		return $this->APIVersion;
	}

	/**
	 * Get Config Page
	 *
	 * @return string Configuration page name
	 */
	function getConfigPage() {
		return $this->configPage;
	}

	/**
	 * Get Delimiter Character
	 *
	 * @return string Delimiter Character
	 */
	function getDelimiter() {
		return $this->delimiter;
	}

	/**
	 * Get Authorize.net Login ID
	 *
	 * @return string Authorize.net Login ID
	 */
	function getLoginID() {
		return $this->loginID;
	}

	/**
	 * Get Transaction Key
	 *
	 * @return string Transaction key
	 */
	function getTransactionKey() {
		return $this->transactionKey;
	}

	/**
	 * Get Authorize.net Transaction URL
	 *
	 * @return string Authorize.net transaction URL
	 */
	function getURL() {
		return $this->url;
	}

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

		// Load settings
		$this->setDelimiter( $this->moduleDBO->loadSetting( "delimiter" ) );
		$this->setLoginID( $this->moduleDBO->loadSetting( "loginid" ) );
		$this->setTransactionKey( $this->moduleDBO->loadSetting( "transactionkey" ) );
		$this->setURL( $this->moduleDBO->loadSetting( "url" ) );
	}

	/**
	 * Install Module
	 *
	 * Invoked when the module is installed.  Calls the parent first, which does
	 * most of the work, then saves the default settings to the DB.
	 */
	function install() {
		parent::install();

		if ( !$this->createTables() ) {
			throw new ModuleInstallFailedException( "authorizeaim",
			"Failed to create database tables for AuthorizeAIM module:" .
					mysql_error() );
		}

		$this->saveSettings();
	}

	/**
	 * Load Transaction Record
	 *
	 * @param string $transactionID The transaction to load
	 * @return array Transaction record from database
	 */
	function loadTransaction( $transactionID ) {
		$DB = DBConnection::getDBConnection();

		$sql = $DB->build_select_sql( "authorizeaim",
				"*",
				"transid=" . $transactionID,
				null,
				null,
				null,
				null );

		// Run query
		if ( !($result = @mysql_query( $sql, $DB->handle() ) ) ) {
			// Query error
			fatal_error( "AuthorizeAIM::loadTransaction()",
					"Attempt to load transaction failed on SELECT" );
		}

		return mysql_fetch_array( $result );
	}

	/**
	 * Refund the Customer
	 *
	 * @param PaymentDBO $paymentDBO Previously authorized & captured payment DBO
	 * @return boolean False on a processing error
	 */
	function refund( &$paymentDBO ) {
		// Load transaction data
		if ( null ==
				($transactionData = $this->loadTransaction( $paymentDBO->getTransaction1() ) ) ) {
			return false;
		}

		// Build Authorize.net transaction record
		$message =
				$this->buildPOSTFields( array( "x_login"  => $this->getLoginID(),
				"x_version" => $this->getAPIVersion(),
				"x_delim_char" => $this->getDelimiter(),
				"x_delim_data" => "TRUE",
				"x_type" => "CREDIT",
				"x_method" => "CC",
				"x_tran_key" => $this->getTransactionKey(),
				"x_trans_id" => $paymentDBO->getTransaction1(),
				"x_card_num" => $transactionData['lastdigits'],
				"x_amount" => $paymentDBO->getAmount() ) );

		// Carry out the transaction
		$resp = $this->executeTransaction( $message );

		// Parse the transaction response
		switch ( $resp[AIM_RESP_CODE] ) {
			case AIM_APPROVED:
				$paymentDBO->setStatus( "Refunded" );
				$paymentDBO->setTransaction1( $resp[AIM_RESP_TRANSACTION_ID] );
				$paymentDBO->setTransaction2( $resp[AIM_RESP_APPROVAL_CODE] );
				break;

			case AIM_DECLINED:
				$paymentDBO->setStatus( "Declined" );
				$paymentDBO->setStatusMessage( substr( $resp[AIM_RESP_REASON_TEXT], 0, 255 ) );
				break;

			case AIM_ERROR:
			default:
				log_error( "AuthorizeAIM::refund()",
						"An error occured while processing an Authorize.net transaction: " .
						$resp[AIM_RESP_REASON_TEXT] );
				return false;
				break;
		}

		return true;
	}

	/**
	 * Save Reseller Club Settings
	 */
	function saveSettings() {
		// Save default settings
		$this->moduleDBO->saveSetting( "delimiter", $this->getDelimiter() );
		$this->moduleDBO->saveSetting( "loginid", $this->getLoginID() );
		$this->moduleDBO->saveSetting( "transactionkey", $this->getTransactionKey() );
		$this->moduleDBO->saveSetting( "url", $this->getURL() );
	}

	/**
	 * Save Transaction
	 *
	 * @param string $transactionID Authorize.net transaction ID
	 * @param string $lastDigits Last 4 digits of the card
	 * @return boolean True for success
	 */
	function saveTransaction( $transactionID, $lastDigits ) {
		$DB = DBConnection::getDBConnection();

		if ( $this->loadTransaction( $transactionID ) ) {
			// Update
			$sql = $DB->build_update_sql( "authorizeaim",
					"transid = " . $transactionID,
					array( "lastdigits" => $lastDigits ) );
		}
		else {
			// Insert
			$sql = $DB->build_insert_sql( "authorizeaim",
					array( "transid" => $transactionID,
					"lastdigits" => $lastDigits ) );
		}

		return mysql_query( $sql, $DB->handle() );
	}

	/**
	 * Set Delimiter Character
	 *
	 * @param string $char Delimiter character
	 */
	function setDelimiter( $char ) {
		$this->delimiter = $char;
	}

	/**
	 * Set Authorize.net Login ID
	 *
	 * @param string $loginID Authorize.net Login ID
	 */
	function setLoginID( $loginID ) {
		$this->loginID = $loginID;
	}

	/**
	 * Set Transaction Key
	 *
	 * @param string $key Authorize.net transaction key
	 */
	function setTransactionKey( $key ) {
		$this->transactionKey = $key;
	}

	/**
	 * Set Authorize.net Transaction URL
	 *
	 * @param string $url Authorize.net transaction URL
	 */
	function setURL( $url ) {
		$this->url = $url;
	}

	/**
	 * Void an Authorized Transaction
	 *
	 * @param PaymentDBO $paymentDBO Previously authorized payment DBO
	 * @return boolean False on a processing error
	 */
	function void( &$paymentDBO ) {
		$message =
				$this->buildPOSTFields( array( "x_login"  => $this->getLoginID(),
				"x_version" => $this->getAPIVersion(),
				"x_delim_char" => $this->getDelimiter(),
				"x_delim_data" => "TRUE",
				"x_type" => "VOID",
				"x_method" => "CC",
				"x_tran_key" => $this->getTransactionKey(),
				"x_trans_id" => $paymentDBO->getTransaction1() ) );

		// Carry out the transaction
		$resp = $this->executeTransaction( $message );

		// Parse the transaction response
		switch ( $resp[AIM_RESP_CODE] ) {
			case AIM_APPROVED:
				$paymentDBO->setStatus( "Voided" );
				$paymentDBO->setTransaction1( $resp[AIM_RESP_TRANSACTION_ID] );
				$paymentDBO->setTransaction2( $resp[AIM_RESP_APPROVAL_CODE] );
				break;

			case AIM_DECLINED:
				$paymentDBO->setStatus( "Declined" );
				$paymentDBO->setStatusMessage( substr( $resp[AIM_RESP_REASON_TEXT], 0, 255 ) );
				break;

			case AIM_ERROR:
			default:
				log_error( "AuthorizeAIM::void()",
						"An error occured while processing an Authorize.net transaction: " .
						$resp[AIM_RESP_REASON_TEXT] );
				return false;
				break;
		}

		return true;
	}
}
?>