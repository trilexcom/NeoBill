<?php
/**
 * SettingsPage.class.php
 *
 * This file contains the definition for the SettingsPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once $base_path . "solidworks/AdminPage.class.php";

/**
 * SettingsPage
 *
 * View SolidState Settings page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SettingsPage extends AdminPage
{
  /**
   * Initialize Settings Page
   */
  function init()
  {
    global $translations;

    $this->smarty->assign( "company_name", $this->conf['company']['name'] );
    $this->smarty->assign( "company_email", $this->conf['company']['email'] );

    $this->smarty->assign( "welcome_subject", $this->conf['welcome_subject'] );
    $this->smarty->assign( "welcome_email", $this->conf['welcome_email'] );

    $this->smarty->assign( "nameservers_ns1", $this->conf['dns']['nameservers'][0] );
    $this->smarty->assign( "nameservers_ns2", $this->conf['dns']['nameservers'][1] );
    $this->smarty->assign( "nameservers_ns3", $this->conf['dns']['nameservers'][2] );
    $this->smarty->assign( "nameservers_ns4", $this->conf['dns']['nameservers'][3] );

    $this->smarty->assign( "invoice_text", $this->conf['invoice_text'] );

    $this->smarty->assign( "currency", $this->conf['locale']['currency_symbol'] );

    $this->smarty->assign( "order_username", $this->conf['order']['remote_username'] );

    // Place the supported languages into a drop-down select
    $this->session['languages'] = array();
    foreach( array_keys( $translations ) as $language )
      {
	if( $language != "default_language" )
	  {
	    $this->session['languages'][$language] = $language;
	  }
      }
  }

  /**
   * Action
   *
   * Actions handled by this page:
   *   general
   *   dns
   *   billing
   *   locale
   *   order
   *   settings_company (form)
   *   settings_welcome (form)
   *   settings_nameservers (form)
   *
   * @param string $action_name Action
   */
  function action( $action_name )
  {
    switch( $action_name )
      {
      case "general":
	$this->setTemplate( "default" );
	break;

      case "dns":
	$this->setTemplate( "dns" );
	break;

      case "billing":
	$this->setTemplate( "billing" );
	break;

      case "locale":
	$this->setTemplate( "locale" );
	break;

      case "order":
	$this->setTemplate( "order" );
	break;

      case "settings_company":
	$this->update_company();
	break;

      case "settings_welcome":
	$this->update_welcome();
	break;

      case "settings_nameservers":
	$this->update_nameservers();
	break;

      case "settings_invoice":
	$this->update_invoice();
	break;

      case "settings_locale":
	$this->update_locale();
	break;

      case "settings_order_password":
	$this->update_order_password();
	break;

      default:
	// No matching action, refer to base class
	parent::action( $action_name );
      }
  }

  /**
   * Update Company Settings
   */
  function update_company()
  {
    $this->conf['company']['name'] = $this->session['settings_company']['name'];
    $this->conf['company']['email'] = $this->session['settings_company']['email'];
    $this->save();
  }

  /**
   * Update Welcome Email Settings
   */
  function update_welcome()
  {
    $this->conf['welcome_subject'] = $this->session['settings_welcome']['subject'];
    $this->conf['welcome_email'] = $this->session['settings_welcome']['email'];
    $this->save();
  }

  /**
   * Update Nameserver Settings
   */
  function update_nameservers()
  {
    $this->conf['dns']['nameservers'] =
      array( $this->session['settings_nameservers']['nameservers_ns1'],
	     $this->session['settings_nameservers']['nameservers_ns2'],
	     $this->session['settings_nameservers']['nameservers_ns3'],
	     $this->session['settings_nameservers']['nameservers_ns4'] );
    $this->save();
    $this->setTemplate( "dns" );
  }

  /**
   * Update Invoice
   */
  function update_invoice()
  {
    $this->conf['invoice_text'] = $this->session['settings_invoice']['text'];
    $this->save();
    $this->setTemplate( "billing" );
  }

  /**
   * Update Locale
   */
  function update_locale()
  {
    $this->conf['locale']['currency_symbol'] = $this->session['settings_locale']['currency'];
    $this->conf['locale']['language'] = $this->session['settings_locale']['language'];
    $this->save();
    $this->setTemplate( "locale" );
  }

  /**
   * Update Order Interface Password
   */
  function update_order_password()
  {
    if( $this->session['settings_order_password']['password'] !=
	$this->session['settings_order_password']['repassword'] )
      {
	// Passwords do not match
	$this->setError( array( "type" => "PASSWORD_MISMATCH" ) );
	$this->setTemplate( "order" );
	$this->goback( 1 );
      }

    $this->conf['order']['remote_password'] = 
      $this->session['settings_order_password']['password'];
    $this->save();
    $this->setTemplate( "order" );
  }

  /**
   * Save changes
   */
  function save()
  {
    save_settings( $this->conf );
    $this->setMessage( array( "type" => "SETTINGS_UPDATED" ) );
  }
}
?>
