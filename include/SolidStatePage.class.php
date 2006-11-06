<?php
/**
 * SolidStatePage.class.php
 *
 * This file contains the definition of the SolidStatePage class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/Page.class.php";

// SolidState Widgets
require_once BASE_PATH . "solidworks/WidgetFactory.class.php";
require_once BASE_PATH . "widgets/AccountSelectWidget.class.php";
require_once BASE_PATH . "widgets/HostingSelectWidget.class.php";
require_once BASE_PATH . "widgets/ServerSelectWidget.class.php";
require_once BASE_PATH . "widgets/IPSelectWidget.class.php";
require_once BASE_PATH . "widgets/TLDSelectWidget.class.php";
require_once BASE_PATH . "widgets/ProductSelectWidget.class.php";
require_once BASE_PATH . "widgets/InvoiceSelectWidget.class.php";
require_once BASE_PATH . "widgets/RegistrarModuleSelectWidget.class.php";
require_once BASE_PATH . "widgets/DomainTermSelectWidget.class.php";
require_once BASE_PATH . "widgets/HostingTermSelectWidget.class.php";
require_once BASE_PATH . "widgets/LanguageSelectWidget.class.php";
require_once BASE_PATH . "widgets/PaymentModuleSelectWidget.class.php";
require_once BASE_PATH . "widgets/CartWidget.class.php";
require_once BASE_PATH . "widgets/CartDomainTableWidget.class.php";
require_once BASE_PATH . "widgets/PaymentMethodSelectWidget.class.php";
require_once BASE_PATH . "widgets/AccountTableWidget.class.php";
require_once BASE_PATH . "widgets/OrderTableWidget.class.php";
require_once BASE_PATH . "widgets/InvoiceTableWidget.class.php";
require_once BASE_PATH . "widgets/TaxRuleTableWidget.class.php";
require_once BASE_PATH . "widgets/HostingServiceTableWidget.class.php";
require_once BASE_PATH . "widgets/DomainServiceTableWidget.class.php";
require_once BASE_PATH . "widgets/ProductTableWidget.class.php";
require_once BASE_PATH . "widgets/ServerTableWidget.class.php";
require_once BASE_PATH . "widgets/DomainTableWidget.class.php";
require_once BASE_PATH . "widgets/ModuleTableWidget.class.php";
require_once BASE_PATH . "widgets/UserTableWidget.class.php";
require_once BASE_PATH . "widgets/LogTableWidget.class.php";
require_once BASE_PATH . "widgets/NoteTableWidget.class.php";
require_once BASE_PATH . "widgets/HostingPurchaseTableWidget.class.php";
require_once BASE_PATH . "widgets/DomainPurchaseTableWidget.class.php";
require_once BASE_PATH . "widgets/ProductPurchaseTableWidget.class.php";
require_once BASE_PATH . "widgets/InvoiceItemTableWidget.class.php";
require_once BASE_PATH . "widgets/PaymentTableWidget.class.php";
require_once BASE_PATH . "widgets/OrderItemTableWidget.class.php";

// SolidState Validators
require_once BASE_PATH . "solidworks/FieldValidatorFactory.class.php";
require_once BASE_PATH . "validators/AccountValidator.class.php";
require_once BASE_PATH . "validators/InvoiceValidator.class.php";
require_once BASE_PATH . "validators/InvoiceItemValidator.class.php";
require_once BASE_PATH . "validators/PaymentValidator.class.php";
require_once BASE_PATH . "validators/NoteValidator.class.php";
require_once BASE_PATH . "validators/HostingValidator.class.php";
require_once BASE_PATH . "validators/ServerValidator.class.php";
require_once BASE_PATH . "validators/HostingPurchaseValidator.class.php";
require_once BASE_PATH . "validators/DomainServiceValidator.class.php";
require_once BASE_PATH . "validators/DomainPurchaseValidator.class.php";
require_once BASE_PATH . "validators/ProductValidator.class.php";
require_once BASE_PATH . "validators/ProductPurchaseValidator.class.php";
require_once BASE_PATH . "validators/OrderValidator.class.php";
require_once BASE_PATH . "validators/OrderItemValidator.class.php";
require_once BASE_PATH . "validators/OrderExistingDomainValidator.class.php";
require_once BASE_PATH . "validators/TaxRuleValidator.class.php";
require_once BASE_PATH . "validators/RegistrarModuleValidator.class.php";
require_once BASE_PATH . "validators/ServerValidator.class.php";
require_once BASE_PATH . "validators/IPAddressDBValidator.class.php";
require_once BASE_PATH . "validators/LanguageValidator.class.php";
require_once BASE_PATH . "validators/PaymentModuleValidator.class.php";
require_once BASE_PATH . "validators/PaymentGatewayModuleValidator.class.php";
require_once BASE_PATH . "validators/ModuleValidator.class.php";
require_once BASE_PATH . "validators/UserValidator.class.php";
require_once BASE_PATH . "validators/PaymentMethodValidator.class.php";
require_once BASE_PATH . "validators/LogValidator.class.php";

/**
 * SolidStatePage
 *
 * Provides a base for all SolidStatePages in the application.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SolidStatePage extends Page
{
  /**
   * SolidStatePage Constructor
   */
  public function __construct()
  {
    parent::__construct();

    // Register SolidState Widgets
    $wf = WidgetFactory::getWidgetFactory();
    $wf->registerWidget( "accountselect", "AccountSelectWidget" );
    $wf->registerWidget( "hostingselect", "HostingSelectWidget" );
    $wf->registerWidget( "serverselect", "ServerSelectWidget" );
    $wf->registerWidget( "ipselect", "IPSelectWidget" );
    $wf->registerWidget( "tldselect", "TLDSelectWidget" );
    $wf->registerWidget( "productselect", "ProductSelectWidget" );
    $wf->registerWidget( "invoiceselect", "InvoiceSelectWidget" );
    $wf->registerWidget( "registrarmoduleselect", "RegistrarModuleSelectWidget" );
    $wf->registerWidget( "domaintermselect", "DomainTermSelectWidget" );
    $wf->registerWidget( "hostingtermselect", "HostingTermSelectWidget" );
    $wf->registerWidget( "languageselect", "LanguageSelectWidget" );
    $wf->registerWidget( "paymentmoduleselect", "PaymentModuleSelectWidget" );
    $wf->registerWidget( "cart", "CartWidget" );
    $wf->registerWidget( "cartdomaintable", "CartDomainTableWidget" );
    $wf->registerWidget( "paymentmethodselect", "PaymentMethodSelectWidget" );
    $wf->registerWidget( "accounttable", "AccountTableWidget" );
    $wf->registerWidget( "ordertable", "OrderTableWidget" );
    $wf->registerWidget( "invoicetable", "InvoiceTableWidget" );
    $wf->registerWidget( "taxruletable", "TaxRuleTableWidget" );
    $wf->registerWidget( "hostingservicetable", "HostingServiceTableWidget" );
    $wf->registerWidget( "domainservicetable", "DomainServiceTableWidget" );
    $wf->registerWidget( "producttable", "ProductTableWidget" );
    $wf->registerWidget( "servertable", "ServerTableWidget" );
    $wf->registerWidget( "domaintable", "DomainTableWidget" );
    $wf->registerWidget( "moduletable", "ModuleTableWidget" );
    $wf->registerWidget( "usertable", "UserTableWidget" );
    $wf->registerWidget( "logtable", "LogTableWidget" );
    $wf->registerWidget( "notetable", "NoteTableWidget" );
    $wf->registerWidget( "hostingpurchasetable", "HostingPurchaseTableWidget" );
    $wf->registerWidget( "domainpurchasetable", "DomainPurchaseTableWidget" );
    $wf->registerWidget( "productpurchasetable", "ProductPurchaseTableWidget" );
    $wf->registerWidget( "invoiceitemtable", "InvoiceItemTableWidget" );
    $wf->registerWidget( "paymenttable", "PaymentTableWidget" );
    $wf->registerWidget( "orderitemtable", "OrderItemTableWidget" );
    
    // Register SolidState Field Validators
    $vf = FieldValidatorFactory::getFieldValidatorFactory();
    $vf->registerFieldValidator( "account", "AccountValidator" );
    $vf->registerFieldValidator( "invoice", "InvoiceValidator" );
    $vf->registerFieldValidator( "invoiceitem", "InvoiceItemValidator" );
    $vf->registerFieldValidator( "note", "NoteValidator" );
    $vf->registerFieldValidator( "payment", "PaymentValidator" );
    $vf->registerFieldValidator( "hosting", "HostingValidator" );
    $vf->registerFieldValidator( "server", "ServerValidator" );
    $vf->registerFieldValidator( "hostingpurchase", "HostingPurchaseValidator" );
    $vf->registerFieldValidator( "domainservice", "DomainServiceValidator" );
    $vf->registerFieldValidator( "domainpurchase", "DomainPurchaseValidator" );
    $vf->registerFieldValidator( "product", "ProductValidator" );
    $vf->registerFieldValidator( "productpurchase", "ProductPurchaseValidator" );
    $vf->registerFieldValidator( "order", "OrderValidator" );
    $vf->registerFieldValidator( "orderitem", "OrderItemValidator" );
    $vf->registerFieldValidator( "taxrule", "TaxRuleValidator" );
    $vf->registerFieldValidator( "registrarmodule", "RegistrarModuleValidator" );
    $vf->registerFieldValidator( "server", "ServerValidator" );
    $vf->registerFieldValidator( "ipaddressdb", "IPAddressDBValidator" );
    $vf->registerFieldValidator( "language", "LanguageValidator" );
    $vf->registerFieldValidator( "paymentmodule", "PaymentModuleValidator" );
    $vf->registerFieldValidator( "paymentgatewaymodule", "PaymentGatewayModuleValidator" );
    $vf->registerFieldValidator( "module", "ModuleValidator" );
    $vf->registerFieldValidator( "user", "UserValidator" );
    $vf->registerFieldValidator( "orderexistingdomain", "OrderExistingDomainValidator" );
    $vf->registerFieldValidator( "paymentmethod", "PaymentMethodValidator" );
    $vf->registerFieldValidator( "log", "LogValidator" );
  }
}