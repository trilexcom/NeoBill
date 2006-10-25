<html>
  <head>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
  </head>

  <body class="menu">
      <a href="manager_content.php?page=accounts" target="content"><h1 class="menu_head">{echo phrase="ACCOUNTS"}</h1></a>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=accounts_browse" target="content">{echo phrase="ACTIVE_ACCOUNTS"}</a> </li>
          <li> <a href="manager_content.php?page=accounts_browse_pending" target="content">{echo phrase="PENDING_ACCOUNTS"}</a> </li>
          <li> <a href="manager_content.php?page=accounts_browse_inactive" target="content">{echo phrase="INACTIVE_ACCOUNTS"}</a> </li>
          <li> <a href="manager_content.php?page=pending_orders" target="content">{echo phrase="PENDING_ORDERS"}</a> </li>
          <li> <a href="manager_content.php?page=fulfilled_orders" target="content">{echo phrase="FULFILLED_ORDERS"}</a> </li>
        </ul>

      </div>


      <a href="manager_content.php?page=billing" target="content"><h1 class="menu_head">{echo phrase="BILLING_INVOICES"}</h1></a>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=billing_invoices_outstanding" target="content">{echo phrase="OUTSTANDING_INVOICES"}</a> </li>
          <li> <a href="manager_content.php?page=billing_invoices" target="content">{echo phrase="ALL_INVOICES"}</a> </li>
          <li> <a href="manager_content.php?page=billing_generate" target="content">{echo phrase="GENERATE_INVOICES"}</a> </li>
          <li> <a href="manager_content.php?page=billing_add_payment" target="content">{echo phrase="ENTER_PAYMENT"}</a> </li>
          <li> <a href="manager_content.php?page=taxes" target="content">{echo phrase="TAXES"}</a> </li>
        </ul>

      </div>

      <a href="manager_content.php?page=services" target="content"><h1 class="menu_head">{echo phrase="PRODUCTS_SERVICES"}</h1></a>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=services_web_hosting" target="content">{echo phrase="WEB_HOSTING_SERVICES"}</a> </li>
          <li> <a href="manager_content.php?page=services_domain_services" target="content">{echo phrase="DOMAIN_SERVICES"}</a> </li>
          <li> <a href="manager_content.php?page=services_products" target="content">{echo phrase="OTHER_PRODUCTS"}</a> </li>
          <li> <a href="manager_content.php?page=services_servers" target="content">{echo phrase="SERVERS"}</a> </li>
          <li> <a href="manager_content.php?page=services_ip_manager" target="content">{echo phrase="IP_ADDRESSES"}</a> </li>
        </ul>

      </div>

      <a href="manager_content.php?page=domains" target="content"><h1 class="menu_head">{echo phrase="DOMAINS"}</h1></a>
      <div class="menu">
 
        <ul>
          <li> <a href="manager_content.php?page=domains_browse" target="content">{echo phrase="REGISTERED_DOMAINS"}</a> </li>
          <li> <a href="manager_content.php?page=domains_expired" target="content">{echo phrase="EXPIRED_DOMAINS"}</a> </li>
          <li> <a href="manager_content.php?page=domains_register" target="content">{echo phrase="REGISTER_NEW_DOMAIN"}</a> </li>
          <li> <a href="manager_content.php?page=transfer_domain" target="content">{echo phrase="TRANSFER_DOMAIN"}</a> </li>
        </ul>

      </div>

      <h1 class="menu_head">{echo phrase="ADMINISTRATION"}</h1>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=settings" target="content">{echo phrase="SETTINGS"}</a> </li>
          <li> <a href="manager_content.php?page=modules" target="content">{echo phrase="MODULES"}</a> </li>
          <li> <a href="manager_content.php?page=config_edit_user&user={$username}" target="content">{echo phrase="MY_INFO"}</a> </li>
          <li> <a href="manager_content.php?page=config_users" target="content">{echo phrase="USERS"}</a> </li>
          <li> <a href="manager_content.php?page=log&table=logdbo_table&sortby=date&sortdir=DESC" target="content">{echo phrase="LOG"}</a> </li>
        </ul>

      </div>
  <body>
</html>
