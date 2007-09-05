<?php /* Smarty version 2.6.14, created on 2007-08-24 11:58:49
         compiled from manager_IPManagerPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_IPManagerPage.tpl', 1, false),array('function', 'dbo_echo', 'manager_IPManagerPage.tpl', 9, false),array('function', 'dbo_assign', 'manager_IPManagerPage.tpl', 17, false),array('block', 'dbo_table', 'manager_IPManagerPage.tpl', 3, false),array('block', 'dbo_table_column', 'manager_IPManagerPage.tpl', 8, false),)), $this); ?>
<h2><?php echo smarty_echo(array('phrase' => 'IP_ADDRESS_POOL'), $this);?>
</h2>
<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'IPAddressDBO','name' => 'ipaddressdbo_table','title' => "[IP_ADDRESS_POOL]",'size' => '25')); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[IP_ADDRESS]",'sort_field' => 'ip')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'ipstring'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[SERVER]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="manager_content.php?page=services_view_server&id=<?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'serverid'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'hostname'), $this);?>
</a>
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
      <a href="manager_content.php?page=services_ip_manager&action=remove_ip&ip=<?php echo smarty_dbo_echo(array('dbo' => 'ipaddressdbo_table','field' => 'ipstring'), $this);?>
">remove</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>