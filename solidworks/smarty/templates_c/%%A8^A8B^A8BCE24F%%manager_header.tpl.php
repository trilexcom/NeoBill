<?php /* Smarty version 2.6.14, created on 2012-03-10 19:03:36
         compiled from manager_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'manager_header.tpl', 69, false),array('function', 'echo', 'manager_header.tpl', 80, false),)), $this); ?>
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
            <li><a href="manager_content.php?page=config_edit_user&user=admin">Users Setting</a></li>
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
         <div class="loggedin"><?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['location_stack']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
$this->_sections['page']['step'] = 1;
$this->_sections['page']['start'] = $this->_sections['page']['step'] > 0 ? 0 : $this->_sections['page']['loop']-1;
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = $this->_sections['page']['loop'];
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
				$this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
				$this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>

              <?php if ($this->_sections['page']['last']): ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['location_stack'][$this->_sections['page']['index']]['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

              <?php else: ?>
                <a href="<?php echo $this->_tpl_vars['location_stack'][$this->_sections['page']['index']]['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['location_stack'][$this->_sections['page']['index']]['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a> >
              <?php endif; ?>

            <?php endfor; else: ?>

              

            <?php endif; ?>

            <?php echo smarty_echo(array('phrase' => 'LOGGED_IN_AS'), $this);?>
: <?php echo $this->_tpl_vars['username']; ?>

            (<a href="manager_content.php?page=home&action=logout"><?php echo smarty_echo(array('phrase' => 'LOGOUT'), $this);?>
</a>)

            <?php echo $this->_tpl_vars['version']; ?>
 <?php echo smarty_echo(array('phrase' => 'ON'), $this);?>
 <?php echo $this->_tpl_vars['machine']; ?>
</div>