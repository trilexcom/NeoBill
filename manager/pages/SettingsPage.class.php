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

require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * SettingsPage
 *
 * View SolidState Settings page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SettingsPage extends SolidStateAdminPage
{
  /**
   * Initialize Settings Page
   */
  public function init()
  {
    parent::init();

    $this->smarty->assign( "company_name", $this->conf['company']['name'] );
    $this->smarty->assign( "company_email", $this->conf['company']['email'] );
    $this->smarty->assign( "company_notification_email",
			   $this->conf['company']['notification_email'] );

    $this->smarty->assign( "confirmation_subject", 
			   $this->conf['order']['confirmation_subject'] );
    $this->smarty->assign( "confirmation_email", 
			   $this->conf['order']['confirmation_email'] );

    $this->smarty->assign( "notification_subject", 
			   $this->conf['order']['notification_subject'] );
    $this->smarty->assign( "notification_email", 
			   $this->conf['order']['notification_email'] );

    $this->smarty->assign( "welcome_subject", $this->conf['welcome_subject'] );
    $this->smarty->assign( "welcome_email", $this->conf['welcome_email'] );

    $this->smarty->assign( "nameservers_ns1", $this->conf['dns']['nameservers'][0] );
    $this->smarty->assign( "nameservers_ns2", $this->conf['dns']['nameservers'][1] );
    $this->smarty->assign( "nameservers_ns3", $this->conf['dns']['nameservers'][2] );
    $this->smarty->assign( "nameservers_ns4", $this->conf['dns']['nameservers'][3] );

    $this->smarty->assign( "invoice_text", $this->conf['invoice_text'] );
    $this->smarty->assign( "invoice_subject", $this->conf['invoice_subject'] );

    $this->smarty->assign( "currency", $this->conf['locale']['currency_symbol'] );

    $this->smarty->assign( "default_gateway", $this->conf['payment_gateway']['default_module'] );

    $this->smarty->assign( "order_accept_checks", $this->conf['order']['accept_checks'] );

    $this->smarty->assign( "managerTheme", $this->conf['themes']['manager'] );
    $this->smarty->assign( "orderTheme", $this->conf['themes']['order'] );

    // This flag indicates if any payment_gateway modules are enabled
    $modules = $this->forms['settings_payment_gateway']->getField( "default_module" )->getWidget()->getData();
    $this->smarty->assign( "gatewaysAreEnabled", !empty( $modules ) );

    // Setup the theme select boxes
    $mtField = $this->forms['settings_themes']->getField( "managertheme" );
    $otField = $this->forms['settings_themes']->getField( "ordertheme" );
    $mtField->getWidget()->setType( "manager" );
    $otField->getWidget()->setType( "order" );
    $mtField->getValidator()->setType( "manager" );
    $otField->getValidator()->setType( "order" );
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
      case "settings_company":
	$this->update_company();
	break;

      case "settings_welcome":
	$this->update_welcome();
	break;

      case "settings_confirmation":
	$this->updateOrderConfirmation();
	break;

      case "settings_notification":
	$this->updateOrderNotification();
	break;

      case "settings_themes":
	$this->updateThemes();
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

      case "settings_payment_gateway":
	$this->update_payment_gateway();
	break;

      case "settings_order_interface":
	$this->updateOrderInterfacePayments();
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
    $this->conf['company']['name'] = $this->post['name'];
    $this->conf['company']['email'] = $this->post['email'];
    $this->conf['company']['notification_email'] = $this->post['notification_email'];
    $this->save();
    $this->smarty->assign( "tab", "general" );
  }

  /**
   * Update Welcome Email Settings
   */
  function update_welcome()
  {
    $this->conf['welcome_subject'] = $this->post['subject'];
    $this->conf['welcome_email'] = $this->post['email'];
    $this->save();
    $this->smarty->assign( "tab", "general" );
  }

  /**
   * Update Order Confirmation Email Settings
   */
  function updateOrderConfirmation()
  {
    $this->conf['order']['confirmation_subject'] = $this->post['subject'];
    $this->conf['order']['confirmation_email'] = $this->post['email'];
    $this->save();
    $this->smarty->assign( "tab", "general" );
  }

  /**
   * Update Theme Settings
   */
  function updateThemes()
  {
    $this->conf['themes']['manager'] = $this->post['managertheme'];
    $this->conf['themes']['order'] = $this->post['ordertheme'];
    $this->save();
    $this->smarty->assign( "tab", "themes" );
    $this->reload();
  }

  function updateOrderInterfacePayments()
  {
    $this->conf['order']['accept_checks'] = $this->post['accept_checks'];
    $this->save();
    $this->smarty->assign( "tab", "payment_gateway" );
  }

  /**
   * Update Order Notification Email Settings
   */
  function updateOrderNotification()
  {
    $this->conf['order']['notification_subject'] = $this->post['subject'];
    $this->conf['order']['notification_email'] = $this->post['email'];
    $this->save();
    $this->smarty->assign( "tab", "general" );
  }

  /**
   * Update Nameserver Settings
   */
  function update_nameservers()
  {
    $this->conf['dns']['nameservers'] =
      array( $this->post['nameservers_ns1'],
	     $this->post['nameservers_ns2'],
	     $this->post['nameservers_ns3'],
	     $this->post['nameservers_ns4'] );
    $this->save();
    $this->smarty->assign( "tab", "dns" );
  }

  /**
   * Update Invoice
   */
  function update_invoice()
  {
    $this->conf['invoice_text'] = $this->post['text'];
    $this->conf['invoice_subject'] = $this->post['subject'];
    $this->save();
    $this->smarty->assign( "tab", "billing" );
  }

  /**
   * Update Locale
   */
  function update_locale()
  {
    $this->conf['locale']['currency_symbol'] = $this->post['currency'];
    $this->conf['locale']['language'] = $this->post['language'];
    $this->save();
    $_SESSION['jsFunction'] = "reloadMenu()";
    $this->smarty->assign( "tab", "locale" );
  }

  /**
   * Update Payment Gateway
   */
  function update_payment_gateway()
  {
    $this->conf['payment_gateway']['default_module'] = 
      $this->post['default_module']->getName();
    $this->conf['payment_gateway']['order_method'] = $this->post['order_method'];
    $this->save();
    $this->smarty->assign( "tab", "payment_gateway" );
  }

  /**
   * Save changes
   */
  function save()
  {
    save_settings( $this->conf );
    $this->setMessage( array( "type" => "[SETTINGS_UPDATED]" ) );
  }
}
?>