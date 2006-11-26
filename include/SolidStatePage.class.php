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

// SolidState DBO's
require BASE_PATH . "DBO/ContactDBO.class.php";
require BASE_PATH . "DBO/PriceDBO.class.php";
require BASE_PATH . "DBO/PurchasableDBO.class.php";
require BASE_PATH . "DBO/SaleDBO.class.php";
require BASE_PATH . "DBO/DomainServiceDBO.class.php";
require BASE_PATH . "DBO/DomainServicePriceDBO.class.php";
require BASE_PATH . "DBO/HostingServiceDBO.class.php";
require BASE_PATH . "DBO/HostingServicePriceDBO.class.php";
require BASE_PATH . "DBO/AccountDBO.class.php";
require BASE_PATH . "DBO/PurchaseDBO.class.php";
require BASE_PATH . "DBO/HostingServicePurchaseDBO.class.php";
require BASE_PATH . "DBO/DomainServicePurchaseDBO.class.php";
require BASE_PATH . "DBO/InvoiceDBO.class.php";
require BASE_PATH . "DBO/InvoiceItemDBO.class.php";
require BASE_PATH . "DBO/IPAddressDBO.class.php";
// require BASE_PATH . "DBO/LogDBO.class.php";
// require BASE_PATH . "DBO/ModuleDBO.class.php";
require BASE_PATH . "DBO/NoteDBO.class.php";
require BASE_PATH . "DBO/OrderItemDBO.class.php";
require BASE_PATH . "DBO/OrderDomainDBO.class.php";
require BASE_PATH . "DBO/OrderHostingDBO.class.php";
require BASE_PATH . "DBO/OrderDBO.class.php";
require BASE_PATH . "DBO/PaymentDBO.class.php";
require BASE_PATH . "DBO/ProductDBO.class.php";
require BASE_PATH . "DBO/ProductPriceDBO.class.php";
require BASE_PATH . "DBO/ProductPurchaseDBO.class.php";
require BASE_PATH . "DBO/ServerDBO.class.php";
require BASE_PATH . "DBO/TaxRuleDBO.class.php";
// require BASE_PATH . "DBO/UserDBO.class.php";

// SolidState Widgets
require BASE_PATH . "widgets/AccountSelectWidget.class.php";
require BASE_PATH . "widgets/HostingSelectWidget.class.php";
require BASE_PATH . "widgets/ServerSelectWidget.class.php";
require BASE_PATH . "widgets/IPSelectWidget.class.php";
require BASE_PATH . "widgets/TLDSelectWidget.class.php";
require BASE_PATH . "widgets/ProductSelectWidget.class.php";
require BASE_PATH . "widgets/InvoiceSelectWidget.class.php";
require BASE_PATH . "widgets/RegistrarModuleSelectWidget.class.php";
require BASE_PATH . "widgets/LanguageSelectWidget.class.php";
require BASE_PATH . "widgets/PaymentModuleSelectWidget.class.php";
require BASE_PATH . "widgets/CartWidget.class.php";
require BASE_PATH . "widgets/CartDomainTableWidget.class.php";
require BASE_PATH . "widgets/PaymentMethodSelectWidget.class.php";
require BASE_PATH . "widgets/AccountTableWidget.class.php";
require BASE_PATH . "widgets/OrderTableWidget.class.php";
require BASE_PATH . "widgets/InvoiceTableWidget.class.php";
require BASE_PATH . "widgets/TaxRuleTableWidget.class.php";
require BASE_PATH . "widgets/HostingServiceTableWidget.class.php";
require BASE_PATH . "widgets/DomainServiceTableWidget.class.php";
require BASE_PATH . "widgets/ProductTableWidget.class.php";
require BASE_PATH . "widgets/ServerTableWidget.class.php";
require BASE_PATH . "widgets/DomainTableWidget.class.php";
require BASE_PATH . "widgets/ModuleTableWidget.class.php";
require BASE_PATH . "widgets/UserTableWidget.class.php";
require BASE_PATH . "widgets/LogTableWidget.class.php";
require BASE_PATH . "widgets/NoteTableWidget.class.php";
require BASE_PATH . "widgets/HostingPurchaseTableWidget.class.php";
require BASE_PATH . "widgets/DomainPurchaseTableWidget.class.php";
require BASE_PATH . "widgets/ProductPurchaseTableWidget.class.php";
require BASE_PATH . "widgets/InvoiceItemTableWidget.class.php";
require BASE_PATH . "widgets/PaymentTableWidget.class.php";
require BASE_PATH . "widgets/OrderItemTableWidget.class.php";
require BASE_PATH . "widgets/IPPoolTableWidget.class.php";
require BASE_PATH . "widgets/DomainContactTableWidget.class.php";
require BASE_PATH . "widgets/PriceTableWidget.class.php";
require BASE_PATH . "widgets/PurchasableTermSelectWidget.class.php";

// SolidState Validators
require BASE_PATH . "validators/AccountValidator.class.php";
require BASE_PATH . "validators/InvoiceValidator.class.php";
require BASE_PATH . "validators/InvoiceItemValidator.class.php";
require BASE_PATH . "validators/PaymentValidator.class.php";
require BASE_PATH . "validators/NoteValidator.class.php";
require BASE_PATH . "validators/HostingValidator.class.php";
require BASE_PATH . "validators/HostingPurchaseValidator.class.php";
require BASE_PATH . "validators/DomainServiceValidator.class.php";
require BASE_PATH . "validators/DomainPurchaseValidator.class.php";
require BASE_PATH . "validators/ProductValidator.class.php";
require BASE_PATH . "validators/ProductPurchaseValidator.class.php";
require BASE_PATH . "validators/OrderValidator.class.php";
require BASE_PATH . "validators/OrderItemValidator.class.php";
require BASE_PATH . "validators/OrderExistingDomainValidator.class.php";
require BASE_PATH . "validators/TaxRuleValidator.class.php";
require BASE_PATH . "validators/ModuleValidator.class.php";
require BASE_PATH . "validators/RegistrarModuleValidator.class.php";
require BASE_PATH . "validators/ServerValidator.class.php";
require BASE_PATH . "validators/IPAddressDBValidator.class.php";
require BASE_PATH . "validators/LanguageValidator.class.php";
require BASE_PATH . "validators/PaymentModuleValidator.class.php";
require BASE_PATH . "validators/PaymentGatewayModuleValidator.class.php";
require BASE_PATH . "validators/UserValidator.class.php";
require BASE_PATH . "validators/PaymentMethodValidator.class.php";
require BASE_PATH . "validators/LogValidator.class.php";
require BASE_PATH . "validators/HostingServicePriceValidator.class.php";
require BASE_PATH . "validators/DomainServicePriceValidator.class.php";
require BASE_PATH . "validators/ProductPriceValidator.class.php";

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
    $wf->registerWidget( "ippooltable", "IPPoolTableWidget" );
    $wf->registerWidget( "domaincontacttable", "DomainContactTableWidget" );
    $wf->registerWidget( "pricetable", "PriceTableWidget" );
    $wf->registerWidget( "purchasabletermselect", "PurchasableTermSelectWidget" );

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
    $vf->registerFieldValidator( "hostingserviceprice", "HostingServicePriceValidator" );
    $vf->registerFieldValidator( "domainserviceprice", "DomainServicePriceValidator" );
    $vf->registerFieldValidator( "productprice", "ProductPriceValidator" );
  }
}