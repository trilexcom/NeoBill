<?php
/**
 * PaypalWPS.class.php
 *
 * This file contains the definition of the PaypalWPS class.
 *
 * @package paypalwps
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once $base_path . "modules/PaymentProcessorModule.class.php";

/**
 * PaypalWPS
 *
 * Provides a module for the Paypal Website Payments Standard service
 *
 * @package paypal
 * @author John Diamond <jdiamond@solid-state.org>
 */
class PaypalWPS extends PaymentProcessorModule
{
  /**
   * @var string Paypal account
   */
  var $account = "account@paypal.com";

  /**
   * @var string Paypal cart upload URL
   */
  var $cartURL = "https://www.paypal.com/cgi-bin/webscr";

  /**
   * @var string Configuration page
   */
  var $configPage = "psm_config";

  /**
   * @var string Paypal Currency Setting
   */
  var $currencyCode = "USD";

  /**
   * @var string Long description
   */
  var $description = "Paypal WPS Payment Processor Module";

  /**
   * @var string PDT Identity Token
   */
  var $idToken = "See Paypal.com > My Account > Profile > Website Payment Preferences > PDT";

  /**
   * @var string Module name
   */
  var $name = "paypalwps";

  /**
   * @var string Order Checkout page
   */
  var $orderCheckoutPage = "pso_checkout";

  /**
   * @var string Short Description
   */
  var $sDescription = "Paypal";

  /**
   * @var integer Version
   */
  var $version = 1;

  /**
   * Initialize Paypal Module
   *
   * Invoked when the module is loaded.  Call the parent method first, then
   * load settings.
   *
   * @return boolean True for success
   */
  function init()
  {
    global $base_path;

    if( !parent::init() )
      {
	return false;
      }

    // Load settings
    $this->setAccount( $this->moduleDBO->loadSetting( "account" ) );
    $this->setCartURL( $this->moduleDBO->loadSetting( "carturl" ) );
    $this->setIdToken( $this->moduleDBO->loadSetting( "idtoken" ) );
    $this->setCurrencyCode( $this->moduleDBO->loadSetting( "paypalcurrencycode" ) );

    return true;
  }

  /**
   * Install Paypal Module
   *
   * Invoked when the module is installed.  Calls the parent first, which does
   * most of the work, then saves the default settings to the DB.
   */
  function install()
  {
    if( !parent::install() )
      {
	return false;
      }
    
    $this->saveSettings();

    return true;
  }

  /**
   * Get Paypal Account
   *
   * @return string Paypal account
   */
  function getAccount() { return $this->account; }

  /**
   * Get Cart URL
   *
   * @return string Paypal cart upload URL
   */
  function getCartURL() { return $this->cartURL; }

  /**
   * Get Currency Code
   *
   * @return string Paypal Currency Code
   */
  function getCurrencyCode() { return $this->currencyCode; }

  /**
   * Get PDT Identity Token
   *
   * @return string PDT Identity Token
   */
  function getIdToken() { return $this->idToken; }

  /**
   * Load a Paypal Payment DBO
   *
   * Searches the database for a Paypal transaction by TX id (transaction1 field)
   *
   * @param string $tx Paypal's TX ID
   */
  function loadPaypalPaymentDBO( $tx )
  {
    global $DB;

    $paymentDBOArray = 
      load_array_PaymentDBO( sprintf( "transaction1=%s AND module=%s",
				      $DB->quote_smart( $tx ),
				      $DB->quote_smart( $this->getName() ) ) );

    if( count( $paymentDBOArray ) > 1 )
      {
	fatal_error( "PaypalWPS::loadPaypalPaymentDBO",
		     "Found duplicate Paypal transactions in the database.  TX = " . $tx );
      }

    return $paymentDBOArray[0];
  }

  /**
   * Process Paypal Instant Payment Notification
   *
   * @param array $postData POST data received from Paypal IPN
   * @return boolean True if the IPN is verfied by Paypal
   */
  function processIPN( $postData )
  {
    // Build request
    $req = "cmd=_notify-validate";
    foreach( $postData as $key => $value )
      {
	$value = urlencode( stripslashes( $value ) );
	$req .= "&$key=$value";
      }

    // Build the POST
    $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen( $req ) . "\r\n\r\n";

    // POST to Paypal
    $urlComp = parse_url( $this->getCartURL() );
    if( !($fp = fsockopen( sprintf( "%s%s",
				    $urlComp['scheme'] == "https" ? "ssl://" : "",
				    $urlComp['host'] ),
			   $urlComp['scheme'] == "https" ? 443 : 80,
			   $errno,
			   $errstr,
			   30 ) ) )
      {
	fatal_error( "PaypalWPS::processPDT()", 
		     "Could not establish a connection with Paypal!" );
      }
    fputs( $fp, $header . $req );

    // Read the response 
    $res = "";
    while( !feof( $fp ) )
      {
	$res = fgets( $fp, 1024 );
	if( strcmp( $res, "VERIFIED" ) == 0 )
	  {
	    fclose( $fp );
	    return true;
	  }
	elseif( strcmp( $res, "INVALID" ) == 0 )
	  {
	    fclose( $fp );
	    return false;
	  }
      }

    fclose( $fp );
    return false;
  }

  /**
   * Process Payment Data Transfer
   *
   * @param string $tx Paypal transaction token
   */
  function processPDT( $tx )
  {
    // Build the request
    $req = sprintf( "cmd=_notify-synch&tx=%s&at=%s", $tx, $this->getIdToken() );

    // Build the POST
    $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen( $req ) . "\r\n\r\n";

    // POST to Paypal
    $urlComp = parse_url( $this->getCartURL() );
    if( !($fp = fsockopen( sprintf( "%s%s",
				    $urlComp['scheme'] == "https" ? "ssl://" : "",
				    $urlComp['host'] ),
			   $urlComp['scheme'] == "https" ? 443 : 80,
			   $errno,
			   $errstr,
			   30 ) ) )
      {
	fatal_error( "PaypalWPS::processPDT()", 
		     "Could not establish a connection with Paypal!" );
      }
    fputs( $fp, $header . $req );

    // Read the response 
   $res = "";
    $headerdone = false;
    while( !feof( $fp ) )
      {
	$line = fgets( $fp, 1024 );
	if( strcmp( $line, "\r\n" ) == 0 )
	  {
	    // Read the header
	    $headerdone = true;
	  }
	elseif( $headerdone )
	  {
	    // Header has been read.  Now read the contents
	    $res .= $line;
	  }
      }

    // Parse the response
    $lines = explode( "\n", $res );
    $keyarray = array();

    if( strcmp( $lines[0], "SUCCESS" ) != 0 )
      {
	fatal_error( "PaypalWPS::processPDT()", "Failed to verify PDT with Paypal!" );
      }

    for( $i = 1; $i < count( $lines ); $i++ )
      {
	list( $key, $val ) = explode( "=", $lines[$i] );
	$keyarray[urldecode( $key )] = urldecode( $val );
      }
    
    // Check that payment_status is completed
    if( $keyarray['payment_status'] != "Completed" &&
	$keyarray['payment_status'] != "Pending" &&
	$keyarray['payment_status'] != "Processed" )
      {
	fatal_error( "PaypalWPS::processPDT()",
		     "Invalid value for payment_status: " . $keyarray['payment_status'] );
      }

    // Check that receiver_email is the primary Paypal email
    if( $keyarray['business'] != $this->getAccount() )
      {
	fatal_error( "PaypalWPS::processPDT()", "Invalid Business!" );
      }

    return $keyarray;
  }

  /**
   * Save Paypal Settings
   */
  function saveSettings()
  {
    // Save settings
    $this->moduleDBO->saveSetting( "account", $this->getAccount() );
    $this->moduleDBO->saveSetting( "carturl", $this->getCartURL() );
    $this->moduleDBO->saveSetting( "idtoken", $this->getIdToken() );
    $this->moduleDBO->saveSetting( "paypalcurrencycode", $this->getCurrencyCode() );
  }

  /**
   * Set Paypal Account
   *
   * @param string $account Paypal account
   */
  function setAccount( $account ) { $this->account = $account; }

  /**
   * Set Cart URL
   *
   * @param string $cartURL Paypal cart upload url
   */
  function setCartURL( $cartURL ) { $this->cartURL = $cartURL; }

  /**
   * Set Currency Code
   *
   * @param string $currencyCode Paypal Currency Code
   */
  function setCurrencyCode( $currencyCode ) { $this->currencyCode = $currencyCode; }

  /**
   * Set PDT Identity Token
   *
   * @param string $idToken PDT Identity Token
   */
  function setIdToken( $idToken ) { $this->idToken = $idToken; }
}
?>