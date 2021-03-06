<?php
/*
 * @(#)include/menu.class.php
 *
 *    Version: 0.50.20090330
 * Written by: John Diamond <mailto:jdiamond@solid-state.org>
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
 * Copyright (C) 2006-2008 by John Diamond
 * Copyright (C) 2009 by Yves Kreis
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the 
 * Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
*/

require_once BASE_PATH . "include/menu_item.class.php";

class Menu {
    /*
     *
    */
    function instance($instance = null) {
        static $u;
        if (!is_null($instance)) {
            $u = $instance;
        }
        return $u;
    }

    /*
     *
    */
    function test1() {
        return Menu::instance();
    }
    function test2() {
        return Menu::instance('test2');
    }
    function test3() {
//      return Menu::$instance;
    }
    function test4() {
//      Menu::$instance = 'test4';
//      return Menu::$instance;
    }

    /**
     * @var SolidStateMenu The singleton instance
     */
    //static $instance = null;

    /**
     * Initialize SolidStateMenu Singleton
     *
     * @return SolidStateMenu The SolidStateMenu instance
     */
    /*
  public static function getSolidStateMenu()
  {
    global $conf;

    if( self::$instance == null )
      {
	$menu = new SolidStateMenu();

	$menu->addItem( new SolidStateMenuItem( "home", 
						$conf['company']['name'], 
						"house.png", 
						"manager_content.php?page=home" ) );
	$menu->addItem( new SolidStateMenuItem( "accounts", 
						"[ACCOUNTS]", 
						"group.png", 
						"manager_content.php?page=accounts" ),
			"home" );
	$menu->addItem( new SolidStateMenuItem( "activeAccounts", 
						"[ACTIVE_ACCOUNTS]", 
						"user_green.png", 
						"manager_content.php?page=accounts_browse" ),
			"accounts" );
	$menu->addItem( new SolidStateMenuItem( "pendingAccounts", 
						"[PENDING_ACCOUNTS]", 
						"user_orange.png", 
						"manager_content.php?page=accounts_browse_pending" ),
			"accounts" );
	$menu->addItem( new SolidStateMenuItem( "inactiveAccounts",
						"[INACTIVE_ACCOUNTS]",
						"user_red.png",
						"manager_content.php?page=accounts_browse_inactive" ),
			"accounts" );
	$menu->addItem( new SolidStateMenuItem( "pendingOrders",
						"[PENDING_ORDERS]",
						"status_away.png",
						"manager_content.php?page=pending_orders" ),
			"accounts" );
	$menu->addItem( new SolidStateMenuItem( "fulfilledOrders",
						"[FULFILLED_ORDERS]",
						"status_online.png",
						"manager_content.php?page=fulfilled_orders" ),
			"accounts" );
	$menu->addItem( new SolidStateMenuItem( "billing", 
						"[BILLING_INVOICES]", 
						"money.png", 
						"manager_content.php?page=billing" ),
			"home" );
	$menu->addItem( new SolidStateMenuItem( "outstandingInvoices", 
						"[OUTSTANDING_INVOICES]", 
						"page_error.png", 
						"manager_content.php?page=billing_invoices_outstanding" ),
			"billing" );
	$menu->addItem( new SolidStateMenuItem( "allInvoices", 
						"[ALL_INVOICES]", 
						"page.png", 
						"manager_content.php?page=billing_invoices" ),
			"billing" );
	$menu->addItem( new SolidStateMenuItem( "generateInvoices", 
						"[GENERATE_INVOICES]", 
						"page_edit.png", 
						"manager_content.php?page=billing_generate" ),
			"billing" );
	$menu->addItem( new SolidStateMenuItem( "enterPayment", 
						"[ENTER_PAYMENT]", 
						"money_add.png", 
						"manager_content.php?page=billing_add_payment" ),
			"billing" );
	$menu->addItem( new SolidStateMenuItem( "taxes", 
						"[TAXES]", 
						"coins.png", 
						"manager_content.php?page=taxes" ),
			"billing" );
	$menu->addItem( new SolidStateMenuItem( "services", 
						"[PRODUCTS_SERVICES]", 
						"cart.png", 
						"manager_content.php?page=services" ),
			"home" );
	$menu->addItem( new SolidStateMenuItem( "servicesHosting", 
						"[WEB_HOSTING_SERVICES]", 
						"page_world.png", 
						"manager_content.php?page=services_web_hosting" ),
			"services" );
	$menu->addItem( new SolidStateMenuItem( "servicesDomain", 
						"[DOMAIN_SERVICES]", 
						"world_link.png", 
						"manager_content.php?page=services_domain_services" ),
			"services" );
	$menu->addItem( new SolidStateMenuItem( "products", 
						"[OTHER_PRODUCTS]", 
						"lightbulb.png", 
						"manager_content.php?page=services_products" ),
			"services" );
	$menu->addItem( new SolidStateMenuItem( "addon", 
						"[ADD_ONS]", 
						"bricks.png", 
						"manager_content.php?page=addon" ),
			"services" );
	$menu->addItem( new SolidStateMenuItem( "servers", 
						"[SERVERS]", 
						"server_database.png", 
						"manager_content.php?page=services_servers" ),
			"services" );
	$menu->addItem( new SolidStateMenuItem( "ipaddresses", 
						"[IP_ADDRESSES]", 
						"server_lightning.png", 
						"manager_content.php?page=services_ip_manager" ),
			"services" );
	$menu->addItem( new SolidStateMenuItem( "domains", 
						"[DOMAINS]", 
						"world_link.png", 
						"manager_content.php?page=domains" ),
			"home" );
	$menu->addItem( new SolidStateMenuItem( "registeredDomains", 
						"[REGISTERED_DOMAINS]", 
						"world_link.png", 
						"manager_content.php?page=domains_browse" ),
			"domains" );
	$menu->addItem( new SolidStateMenuItem( "expiredDomains", 
						"[EXPIRED_DOMAINS]", 
						"cancel.png", 
						"manager_content.php?page=domains_expired" ),
			"domains" );
	$menu->addItem( new SolidStateMenuItem( "registerDomain", 
						"[REGISTER_NEW_DOMAIN]", 
						"world_add.png", 
						"manager_content.php?page=domains_register" ),
			"domains" );
	$menu->addItem( new SolidStateMenuItem( "transferDomain", 
						"[TRANSFER_DOMAIN]", 
						"world_go.png", 
						"manager_content.php?page=transfer_domain" ),
			"domains" );
	$menu->addItem( new SolidStateMenuItem( "administration", 
						"[ADMINISTRATION]", 
						"monitor.png" ),
			"home" );
	$menu->addItem( new SolidStateMenuItem( "log", 
						"[LOG]", 
						"error.png", 
						"manager_content.php?page=log&action=swtablesort&swtablename=log&swtableform=log&swtablesortcol=date&swtablesortdir=DESC" ),
			"administration" );
	$menu->addItem( new SolidStateMenuItem( "settings", 
						"[SETTINGS]", 
						"table_edit.png", 
						"manager_content.php?page=settings" ),
			"administration" );
	$menu->addItem( new SolidStateMenuItem( "modules", 
						"[MODULES]", 
						"sitemap.png", 
						"manager_content.php?page=modules" ),
			"administration" );
	$menu->addItem( new SolidStateMenuItem( "users", 
						"[USERS]", 
						"vcard.png", 
						"manager_content.php?page=config_users" ),
			"administration" );
	$menu->addItem( new SolidStateMenuItem( "about", 
						"[WEBSITE]", 
						"bell.png",
						"http://www.neobill.net/" ),
			"home" );
	$menu->addItem( new SolidStateMenuItem( "logout", 
						"[LOGOUT]", 
						"door_out.png",
						"manager_content.php?page=home&action=logout" ),
			"home" );

	self::$instance = $menu;
      }

    return self::$instance;
  }

  /**
   * @var integer The next item id
    */
    /*
  protected $nextItemID = 1;

  /**
   *
   * @var SolidStateMenuItem Root menu item
    */
    /*
  protected $rootItem = null;

  /**
   * Constructor
    */
    /*
  protected function __construct()
  {
    $this->rootItem = new SolidStateMenuItem( "root", "root" );
  }
    */

    /**
     * Add Item
     *
     * @param SolidStateMenuItem Menu item to add
     * @param string $parentName The name of the parent item or null
     */
    /*
  public function addItem( SolidStateMenuItem $item, $parentName = null )
  {
    if( null != ($result = $this->getItem( $item->getName() )) )
      {
	throw new SWException( "A menu item by that name already exists: " . $item->getName() );
      }

    $item->setID( $this->nextItemID++ );
    $parentItem = isset( $parentName ) ? $this->getItem( $parentName ) : $this->rootItem;
    if( !isset( $parentItem ) )
      {
	throw new SWException( "Parent item not found: " . $parentName );
      }
    
    $parentItem->addItem( $item );
  }

  /**
   * Get Item
   *
   * @param string $name The name of the item to find
   * @return SolidStateMenuItem The item if found, null otherwise
    */
    /*
  public function getItem( $name )
  {
    if( $name == "root" )
      {
	return $rootItem;
      }

    return $this->rootItem->getItem( $name );
  }

  /**
   * Get Item Array
   *
   * Flatten the menu into an array
   *
   * @return array A flattened array of menu item data
    */
    /*
  public function getItemArray()
  {
    return $this->rootItem->toArray();
  }
    */
}
?>
