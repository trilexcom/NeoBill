<?php /* Smarty version 2.6.14, created on 2007-08-27 11:45:43
         compiled from manager_ViewServerPage_ips.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'dbo_assign', 'manager_ViewServerPage_ips.tpl', 1, false),array('function', 'echo', 'manager_ViewServerPage_ips.tpl', 5, false),array('function', 'form_element', 'manager_ViewServerPage_ips.tpl', 13, false),array('function', 'dbo_echo', 'manager_ViewServerPage_ips.tpl', 17, false),array('block', 'form', 'manager_ViewServerPage_ips.tpl', 12, false),array('block', 'dbo_table', 'manager_ViewServerPage_ips.tpl', 20, false),array('block', 'dbo_table_column', 'manager_ViewServerPage_ips.tpl', 26, false),)), $this); ?>
<?php echo smarty_dbo_assign(array('dbo' => 'server_dbo','var' => 'serverid','field' => 'id'), $this);?>


<ul id="tabnav">
  <?php echo smarty_dbo_assign(array('dbo' => 'server_dbo','field' => 'id','var' => 'id'), $this);?>

  <li> <a href="manager_content.php?page=services_view_server&id=<?php echo $this->_tpl_vars['id']; ?>
&action=info"> <?php echo smarty_echo(array('phrase' => 'SERVER_INFO'), $this);?>
 </a> </li>
  <li class="selected"> <a href="manager_content.php?page=services_view_server&id=<?php echo $this->_tpl_vars['id']; ?>
&action=ips"> <?php echo smarty_echo(array('phrase' => 'IP_ADDRESSES'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&id=<?php echo $this->_tpl_vars['id']; ?>
&action=services"> <?php echo smarty_echo(array('phrase' => 'HOSTING_SERVICES'), $this);?>
 </a> </li>
</ul>

<div class="action">
  <p class="header"><?php echo smarty_echo(array('phrase' => 'ACTIONS'), $this);?>
</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'view_server_add_ip')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('phrase' => 'IP_ADDRESSES_FOR'), $this);?>
 <?php echo smarty_dbo_echo(array('dbo' => 'server_dbo','field' => 'hostname'), $this);?>
 </h2>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'IPAddressDBO','name' => 'ipaddressdbo_table','title' => "[IP_ADDRESSES]",'filter' => "serverid=".($this->_tpl_vars['serverid']),'size' => '25')); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[IP_ADDRESS]",'sort_field' => 'ip')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'ipstring'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ASSIGNED_TO]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_assign(array('dbo' => 'ipaddressdbo_table','var' => 'accountid','field' => 'accountid'), $this);?>

      <?php if ($this->_tpl_vars['accountid'] < 1): ?>
        Available
      <?php else: ?>
        <a href="manager_content.php?page=accounts_view_account&id=<?php echo $this->_tpl_vars['accountid']; ?>
"><?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'accountname'), $this);?>
</a>
      <?php endif; ?>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[SERVICE]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'servicetitle'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ACTION]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="manager_content.php?page=services_view_server&action=delete_ip&ip=<?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'ipstring'), $this);?>
">remove</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

</div>