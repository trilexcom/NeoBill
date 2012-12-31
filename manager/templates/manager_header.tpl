<p class="logo"><img src="images/logo.gif" width="275" height="100" /></p>

<div class="menubr"><ul id="bar1">
	<li>
		<a href="#">Accounts</a>
		<ul>
			<li><a href="manager_content.php?page=accounts_browse">Active Accounts</a></li>
			<li><a href="manager_content.php?page=accounts_browse_pending">Pending Accounts</a></li>
			<li><a href="manager_content.php?page=accounts_browse_inactive">Inactive Accounts</a></li>
			<li><a href="manager_content.php?page=pending_orders">Pending Orders</a></li>
			<li><a href="manager_content.php?page=fulfilled_orders">Fulfilled Orders</a></li>
		</ul>
	</li>
	<li>

		<a href="#">Billing & Invoices</a>
		<ul>
			<li><a href="manager_content.php?page=billing_invoices_outstanding">Outstanding Invoices</a></li>
			<li><a href="manager_content.php?page=billing_invoices">All Invoices</a></li>
            <li><a href="manager_content.php?page=billing_generate">Generate Invoices</a></li>
            <li><a href="manager_content.php?page=billing_add_payment">Enter Payment</a></li>
            <li><a href="manager_content.php?page=taxes">Taxes</a></li>
		</ul>
	</li>
	<li>
		<a href="#">Products & Services</a>
		<ul>
			<li><a href="manager_content.php?page=services_web_hosting">Web Hosting Services</a></li>
			<li><a href="manager_content.php?page=services_domain_services">Domain Services</a></li>
            <li><a href="manager_content.php?page=services_products">Other Products</a></li>
            <li><a href="manager_content.php?page=addon">Add-Ons</a></li>
            <li><a href="manager_content.php?page=services_servers">Servers</a></li>
            <li><a href="manager_content.php?page=services_ip_manager">IP Addresses</a></li>
		</ul>
	</li>
	<li>
		<a href="#">Domains</a>
		<ul>
			<li><a href="manager_content.php?page=domains_browse">Registered Domains</a></li>
			<li><a href="manager_content.php?page=domains_expired">Expired Domains</a></li>
            <li><a href="manager_content.php?page=domains_register">Register New Domain</a></li>
            <li><a href="manager_content.php?page=transfer_domain">Transfer Domain</a></li>
		</ul>
	</li>
    	<li>
		<a href="#">Administration</a>
		<ul>
			<li><a href="manager_content.php?page=log&action=swtablesort&swtablename=log&swtableform=log&swtablesortcol=date&swtablesortdir=DESC">Log Info</a></li>
			<li><a href="manager_content.php?page=settings">Settings</a></li>
            <li><a href="manager_content.php?page=modules">Modules</a></li>
            <li><a href="manager_content.php?page=config_users">Users</a></li>
            <!-- <li><a href="manager_content.php?page=config_edit_user&user=admin">Users Setting</a></li> -->
		</ul>
	</li>
        	<li>
		<a href="#">About NeoBill</a>
		<ul>
			<li><a href="http://www.neobill.net">NeoBill Website</a></li>
			<li><a href="http://www.neobill.net/wiki/">Help</a></li>
            <li><a href="#Coming Soon!">Version Check</a></li>
            <li><a href="http://www.neobill.net/wiki/doku.php/about:team">NeoBill Credit</a></li>
            <li><a href="manager_content.php?page=home&action=logout">Logout</a></li>
		</ul>
	</li>
</ul></div>		
         <div class="loggedin">{section name="page" loop=$location_stack}

              {if $smarty.section.page.last}
                {$location_stack[page].name|capitalize}
              {else}
                <a href="{$location_stack[page].url}">{$location_stack[page].name|capitalize}</a> >
              {/if}

            {sectionelse}

              

            {/section}

            {echo phrase="LOGGED_IN_AS"}: {$username}
            (<a href="manager_content.php?page=home&action=logout">{echo phrase="LOGOUT"}</a>)

            {$version} {echo phrase="ON"} {$machine}</div>
