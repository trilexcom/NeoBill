<?php /* Smarty version 2.6.14, created on 2007-08-21 12:10:44
         compiled from manager_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_menu.tpl', 7, false),)), $this); ?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
  </head>

  <body class="menu">
      <a href="manager_content.php?page=accounts" target="content"><h1 class="menu_head"><?php echo smarty_echo(array('phrase' => 'ACCOUNTS'), $this);?>
</h1></a>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=accounts_browse" target="content"><?php echo smarty_echo(array('phrase' => 'ACTIVE_ACCOUNTS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=accounts_browse_pending" target="content"><?php echo smarty_echo(array('phrase' => 'PENDING_ACCOUNTS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=accounts_browse_inactive" target="content"><?php echo smarty_echo(array('phrase' => 'INACTIVE_ACCOUNTS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=pending_orders" target="content"><?php echo smarty_echo(array('phrase' => 'PENDING_ORDERS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=fulfilled_orders" target="content"><?php echo smarty_echo(array('phrase' => 'FULFILLED_ORDERS'), $this);?>
</a> </li>
        </ul>

      </div>


      <a href="manager_content.php?page=billing" target="content"><h1 class="menu_head"><?php echo smarty_echo(array('phrase' => 'BILLING_INVOICES'), $this);?>
</h1></a>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=billing_invoices_outstanding" target="content"><?php echo smarty_echo(array('phrase' => 'OUTSTANDING_INVOICES'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=billing_invoices" target="content"><?php echo smarty_echo(array('phrase' => 'ALL_INVOICES'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=billing_generate" target="content"><?php echo smarty_echo(array('phrase' => 'GENERATE_INVOICES'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=billing_add_payment" target="content"><?php echo smarty_echo(array('phrase' => 'ENTER_PAYMENT'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=taxes" target="content"><?php echo smarty_echo(array('phrase' => 'TAXES'), $this);?>
</a> </li>
        </ul>

      </div>

      <a href="manager_content.php?page=services" target="content"><h1 class="menu_head"><?php echo smarty_echo(array('phrase' => 'PRODUCTS_SERVICES'), $this);?>
</h1></a>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=services_web_hosting" target="content"><?php echo smarty_echo(array('phrase' => 'WEB_HOSTING_SERVICES'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=services_domain_services" target="content"><?php echo smarty_echo(array('phrase' => 'DOMAIN_SERVICES'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=services_products" target="content"><?php echo smarty_echo(array('phrase' => 'OTHER_PRODUCTS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=services_servers" target="content"><?php echo smarty_echo(array('phrase' => 'SERVERS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=services_ip_manager" target="content"><?php echo smarty_echo(array('phrase' => 'IP_ADDRESSES'), $this);?>
</a> </li>
        </ul>

      </div>

      <a href="manager_content.php?page=domains" target="content"><h1 class="menu_head"><?php echo smarty_echo(array('phrase' => 'DOMAINS'), $this);?>
</h1></a>
      <div class="menu">
 
        <ul>
          <li> <a href="manager_content.php?page=domains_browse" target="content"><?php echo smarty_echo(array('phrase' => 'REGISTERED_DOMAINS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=domains_expired" target="content"><?php echo smarty_echo(array('phrase' => 'EXPIRED_DOMAINS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=domains_register" target="content"><?php echo smarty_echo(array('phrase' => 'REGISTER_NEW_DOMAIN'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=transfer_domain" target="content"><?php echo smarty_echo(array('phrase' => 'TRANSFER_DOMAIN'), $this);?>
</a> </li>
        </ul>

      </div>

      <h1 class="menu_head"><?php echo smarty_echo(array('phrase' => 'ADMINISTRATION'), $this);?>
</h1>
      <div class="menu">

        <ul>
          <li> <a href="manager_content.php?page=settings" target="content"><?php echo smarty_echo(array('phrase' => 'SETTINGS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=modules" target="content"><?php echo smarty_echo(array('phrase' => 'MODULES'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=config_edit_user&my_info=1" target="content"><?php echo smarty_echo(array('phrase' => 'MY_INFO'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=config_users" target="content"><?php echo smarty_echo(array('phrase' => 'USERS'), $this);?>
</a> </li>
          <li> <a href="manager_content.php?page=log&table=logdbo_table&sortby=date&sortdir=DESC" target="content"><?php echo smarty_echo(array('phrase' => 'LOG'), $this);?>
</a> </li>
        </ul>

      </div>
  <body>
</html>