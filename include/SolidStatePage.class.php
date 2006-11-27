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
    $wf->registerWidget( "accountselect", "AccountSelectWidget", BASE_PATH . "widgets/AccountSelectWidget.class.php" );
    $wf->registerWidget( "hostingselect", "HostingSelectWidget", BASE_PATH . "widgets/HostingSelectWidget.class.php"  );
    $wf->registerWidget( "serverselect", "ServerSelectWidget", BASE_PATH . "widgets/ServerSelectWidget" );
    $wf->registerWidget( "ipselect", "IPSelectWidget", BASE_PATH . "widgets/IPSelectWidget.class.php" );
    $wf->registerWidget( "tldselect", "TLDSelectWidget", BASE_PATH . "widgets/TLDSelectWidget.class.php" );
    $wf->registerWidget( "productselect", "ProductSelectWidget", BASE_PATH . "widgets/ProductSelectWidget.class.php" );
    $wf->registerWidget( "invoiceselect", "InvoiceSelectWidget", BASE_PATH . "widgets/InvoiceSelectWidget.class.php" );
    $wf->registerWidget( "registrarmoduleselect", "RegistrarModuleSelectWidget", BASE_PATH . "widgets/RegistrarModuleSelectWidget.class.php" );
    $wf->registerWidget( "languageselect", "LanguageSelectWidget", BASE_PATH . "widgets/LanguageSelectWidget.class.php" );
    $wf->registerWidget( "paymentmoduleselect", "PaymentModuleSelectWidget", BASE_PATH . "widgets/PaymentModuleSelectWidget.class.php" );
    $wf->registerWidget( "cart", "CartWidget", BASE_PATH . "widgets/CartWidget.class.php" );
    $wf->registerWidget( "cartdomaintable", "CartDomainTableWidget", BASE_PATH . "widgets/CartDomainTableWidget.class.php" );
    $wf->registerWidget( "paymentmethodselect", "PaymentMethodSelectWidget", BASE_PATH . "widgets/PaymentMethodSelectWidget.class.php" );
    $wf->registerWidget( "accounttable", "AccountTableWidget", BASE_PATH . "widgets/AccountTableWidget.class.php" );
    $wf->registerWidget( "ordertable", "OrderTableWidget", BASE_PATH . "widgets/OrderTableWidget.class.php" );
    $wf->registerWidget( "invoicetable", "InvoiceTableWidget", BASE_PATH . "widgets/InvoiceTableWidget.class.php" );
    $wf->registerWidget( "taxruletable", "TaxRuleTableWidget", BASE_PATH . "widgets/TaxRuleTableWidget.class.php" );
    $wf->registerWidget( "hostingservicetable", "HostingServiceTableWidget", BASE_PATH . "widgets/HostingServiceTableWidget.class.php" );
    $wf->registerWidget( "domainservicetable", "DomainServiceTableWidget", BASE_PATH . "widgets/DomainServiceTableWidget.class.php" );
    $wf->registerWidget( "producttable", "ProductTableWidget", BASE_PATH . "widgets/ProductTableWidget.class.php" );
    $wf->registerWidget( "servertable", "ServerTableWidget", BASE_PATH . "widgets/ServerTableWidget.class.php" );
    $wf->registerWidget( "domaintable", "DomainTableWidget", BASE_PATH . "widgets/DomainTableWidget.class.php" );
    $wf->registerWidget( "moduletable", "ModuleTableWidget", BASE_PATH . "widgets/ModuleTableWidget.class.php" );
    $wf->registerWidget( "usertable", "UserTableWidget", BASE_PATH . "widgets/UserTableWidget.class.php" );
    $wf->registerWidget( "logtable", "LogTableWidget", BASE_PATH . "widgets/LogTableWidget.class.php" );
    $wf->registerWidget( "notetable", "NoteTableWidget", BASE_PATH . "widgets/NoteTableWidget.class.php" );
    $wf->registerWidget( "hostingpurchasetable", "HostingPurchaseTableWidget", BASE_PATH . "widgets/HostingPurchaseTableWidget.class.php" );
    $wf->registerWidget( "domainpurchasetable", "DomainPurchaseTableWidget", BASE_PATH . "widgets/DomainPurchaseTableWidget.class.php" );
    $wf->registerWidget( "productpurchasetable", "ProductPurchaseTableWidget", BASE_PATH . "widgets/ProductPurchaseTableWidget.class.php" );
    $wf->registerWidget( "invoiceitemtable", "InvoiceItemTableWidget", BASE_PATH . "widgets/InvoiceItemTableWidget.class.php" );
    $wf->registerWidget( "paymenttable", "PaymentTableWidget", BASE_PATH . "widgets/PaymentTableWidget.class.php" );
    $wf->registerWidget( "orderitemtable", "OrderItemTableWidget", BASE_PATH . "widgets/OrderItemTableWidget.class.php" );
    $wf->registerWidget( "ippooltable", "IPPoolTableWidget", BASE_PATH . "widgets/IPPoolTableWidget.class.php" );
    $wf->registerWidget( "domaincontacttable", "DomainContactTableWidget", BASE_PATH . "widgets/DomainContactTableWidget.class.php" );
    $wf->registerWidget( "pricetable", "PriceTableWidget", BASE_PATH . "widgets/PriceTableWidget.class.php" );
    $wf->registerWidget( "purchasabletermselect", "PurchasableTermSelectWidget", BASE_PATH . "widgets/PurchasableTermSelectWidget.class.php" );

    // Register SolidState Field Validators
    $vf = FieldValidatorFactory::getFieldValidatorFactory();
    $vf->registerFieldValidator( "account", "AccountValidator", BASE_PATH . "validators/AccountValidator.class.php" );
    $vf->registerFieldValidator( "invoice", "InvoiceValidator", BASE_PATH . "validators/InvoiceValidator.class.php" );
    $vf->registerFieldValidator( "invoiceitem", "InvoiceItemValidator", BASE_PATH . "validators/InvoiceItemValidator.class.php" );
    $vf->registerFieldValidator( "note", "NoteValidator", BASE_PATH . "validators/NoteValidator.class.php" );
    $vf->registerFieldValidator( "payment", "PaymentValidator", BASE_PATH . "validators/PaymentValidator.class.php" );
    $vf->registerFieldValidator( "hosting", "HostingValidator", BASE_PATH . "validators/HostingValidator.class.php" );
    $vf->registerFieldValidator( "server", "ServerValidator", BASE_PATH . "validators/ServerValidator.class.php" );
    $vf->registerFieldValidator( "hostingpurchase", "HostingPurchaseValidator", BASE_PATH . "validators/HostingPurchaseValidator.class.php" );
    $vf->registerFieldValidator( "domainservice", "DomainServiceValidator", BASE_PATH . "validators/DomainServiceValidator.class.php" );
    $vf->registerFieldValidator( "domainpurchase", "DomainPurchaseValidator", BASE_PATH . "validators/DomainPurchaseValidator.class.php" );
    $vf->registerFieldValidator( "product", "ProductValidator", BASE_PATH . "validators/ProductValidator.class.php" );
    $vf->registerFieldValidator( "productpurchase", "ProductPurchaseValidator", BASE_PATH . "validators/ProductPurchaseValidator.class.php" );
    $vf->registerFieldValidator( "order", "OrderValidator", BASE_PATH . "validators/OrderValidator.class.php" );
    $vf->registerFieldValidator( "orderitem", "OrderItemValidator", BASE_PATH . "validators/OrderItemValidator.class.php" );
    $vf->registerFieldValidator( "taxrule", "TaxRuleValidator", BASE_PATH . "validators/TaxRuleValidator.class.php" );
    $vf->registerFieldValidator( "registrarmodule", "RegistrarModuleValidator", BASE_PATH . "validators/RegistrarModuleValidator.class.php" );
    $vf->registerFieldValidator( "server", "ServerValidator", BASE_PATH . "validators/ServerValidator.class.php" );
    $vf->registerFieldValidator( "ipaddressdb", "IPAddressDBValidator", BASE_PATH . "validators/IPAddressDBValidator.class.php" );
    $vf->registerFieldValidator( "language", "LanguageValidator", BASE_PATH . "validators/LanguageValidator.class.php" );
    $vf->registerFieldValidator( "paymentmodule", "PaymentModuleValidator", BASE_PATH . "validators/PaymentModuleValidator.class.php" );
    $vf->registerFieldValidator( "paymentgatewaymodule", "PaymentGatewayModuleValidator", BASE_PATH . "validators/PaymentGatewayModuleValidator.class.php" );
    $vf->registerFieldValidator( "module", "ModuleValidator", BASE_PATH . "validators/ModuleValidator.class.php" );
    $vf->registerFieldValidator( "user", "UserValidator", BASE_PATH . "validators/UserValidator.class.php" );
    $vf->registerFieldValidator( "orderexistingdomain", "OrderExistingDomainValidator", BASE_PATH . "validators/OrderExistingDomainValidator.class.php" );
    $vf->registerFieldValidator( "paymentmethod", "PaymentMethodValidator", BASE_PATH . "validators/PaymentMethodValidator.class.php" );
    $vf->registerFieldValidator( "log", "LogValidator", BASE_PATH . "validators/LogValidator.class.php" );
    $vf->registerFieldValidator( "hostingserviceprice", "HostingServicePriceValidator", BASE_PATH . "validators/HostingServicePriceValidator.class.php" );
    $vf->registerFieldValidator( "domainserviceprice", "DomainServicePriceValidator", BASE_PATH . "validators/DomainServicePriceValidator.class.php" );
    $vf->registerFieldValidator( "productprice", "ProductPriceValidator", BASE_PATH . "validators/ProductPriceValidator.class.php" );
  }
}