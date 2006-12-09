<?php
/**
 * settings.php
 *
 * This file contains functions that manage configuration settings
 *
 * @package Utilities
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Load Settings
 *
 * Load the application settings from the database
 *
 * @param array $conf Configuration data
 */
function load_settings( &$conf )
{
  $DB = DBConnection::getDBConnection();

  // Build Query
  $sql = $DB->build_select_sql( "settings", "*" );

  // Run Query
  if( !( $result = @mysql_query( $sql, $DB->handle() ) ) )
    {
      fatal_error( "load_settings", 
		   "Could not load configuration settings from database!" );
    }

  while( $setting = mysql_fetch_array( $result ) )
    {
      $key = $setting['setting'];
      $val = $setting['value'];
      switch( $key )
	{
	case "company_name": $conf['company']['name'] = $val; break;
	case "company_email": $conf['company']['email'] = $val; break;
	case "company_notification_email": 
	  $conf['company']['notification_email'] = $val; break;

	case "order_confirmation_email": 
	  $conf['order']['confirmation_email'] = $val; break;
	case "order_confirmation_subject":
	  $conf['order']['confirmation_subject'] = $val; break;

	case "order_notification_email":
	  $conf['order']['notification_email'] = $val; break;
	case "order_notification_subject":
	  $conf['order']['notification_subject'] = $val; break;

	case "welcome_email": $conf['welcome_email'] = $val; break;
	case "welcome_subject": $conf['welcome_subject'] = $val; break;

	case "nameservers_ns1": $conf['dns']['nameservers'][0] = $val; break;
	case "nameservers_ns2": $conf['dns']['nameservers'][1] = $val; break;
	case "nameservers_ns3": $conf['dns']['nameservers'][2] = $val; break;
	case "nameservers_ns4": $conf['dns']['nameservers'][3] = $val; break;

	case "invoice_text": $conf['invoice_text'] = $val; break;
	case "invoice_subject": $conf['invoice_subject'] = $val; break;

	case "locale_language": 
	  Translator::getTranslator()->setActiveLanguage( $val ); 
	  break;
	case "locale_currency_symbol": $conf['locale']['currency_symbol'] = $val; break;

	case "payment_gateway_default_module": 
	  $conf['payment_gateway']['default_module'] = $val; break;
	case "payment_gateway_order_method":
	  $conf['payment_gateway']['order_method'] = $val; break;

	case "order_accept_checks": $conf['order']['accept_checks'] = $val; break;
	}
    }
}

/**
 * Save Settings
 *
 * Save the application settings to the database
 *
 * @param array $conf Configuration data
 */
function save_settings( &$conf )
{
  update_setting( "company_name", $conf['company']['name'] );
  update_setting( "company_email", $conf['company']['email'] );
  update_setting( "company_notification_email", 
		  $conf['company']['notification_email'] );

  update_setting( "order_confirmation_subject", $conf['order']['confirmation_subject'] );
  update_setting( "order_confirmation_email", $conf['order']['confirmation_email'] );

  update_setting( "order_notification_subject", $conf['order']['notification_subject'] );
  update_setting( "order_notification_email", $conf['order']['notification_email'] );

  update_setting( "welcome_email", $conf['welcome_email'] );
  update_setting( "welcome_subject", $conf['welcome_subject'] );

  update_setting( "nameservers_ns1", $conf['dns']['nameservers'][0] );
  update_setting( "nameservers_ns2", $conf['dns']['nameservers'][1] );
  update_setting( "nameservers_ns3", $conf['dns']['nameservers'][2] );
  update_setting( "nameservers_ns4", $conf['dns']['nameservers'][3] );

  update_setting( "invoice_text", $conf['invoice_text'] );
  update_setting( "invoice_subject", $conf['invoice_subject'] );

  update_setting( "locale_currency_symbol", $conf['locale']['currency_symbol'] );
  update_setting( "locale_language", $conf['locale']['language'] );

  update_setting( "payment_gateway_default_module", 
		  $conf['payment_gateway']['default_module'] );
  update_setting( "payment_gateway_order_method",
		  $conf['payment_gateway']['order_method'] );

  update_setting( "order_accept_checks", $conf['order']['accept_checks'] ? "1" : "0" );

  // Reload
  load_settings( $conf );
}

/**
 * Update Setting
 *
 * Updates a single setting record
 *
 * @param string $key Key
 * @param string $value New value
 */
function update_setting( $key, $value )
{
  $DB = DBConnection::getDBConnection();

  // Build SQL
  $sql = $DB->build_update_sql( "settings",
				"setting = " . $DB->quote_smart( $key ),
				array( "value" => $value ) );

  // Run query
  if( !mysql_query( $sql, $DB->handle() ) )
    {
      fatal_error( "update_setting", "Failed to update setting: " . mysql_error() );
    }
}
?>