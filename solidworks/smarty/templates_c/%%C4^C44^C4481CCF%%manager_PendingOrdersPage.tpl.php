<?php /* Smarty version 2.6.14, created on 2007-08-24 11:58:32
         compiled from manager_PendingOrdersPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_PendingOrdersPage.tpl', 1, false),array('function', 'dbo_echo', 'manager_PendingOrdersPage.tpl', 11, false),array('block', 'dbo_table', 'manager_PendingOrdersPage.tpl', 4, false),array('block', 'dbo_table_column', 'manager_PendingOrdersPage.tpl', 10, false),array('modifier', 'datetime', 'manager_PendingOrdersPage.tpl', 19, false),array('modifier', 'currency', 'manager_PendingOrdersPage.tpl', 31, false),)), $this); ?>
<h2><?php echo smarty_echo(array('phrase' => 'PENDING_ORDERS'), $this);?>
</h2>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'OrderDBO','name' => 'orderdbo_table','filter' => "status='Pending'",'title' => "[PENDING_ORDERS]",'size' => '10')); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ID]",'sort_field' => 'id')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a target="content" href="manager_content.php?page=view_order&id=<?php echo smarty_dbo_echo(array('dbo' => 'orderdbo_table','field' => 'id'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'orderdbo_table','field' => 'id'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ACCOUNT]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'orderdbo_table','field' => 'accounttype'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ORDER_DATE]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'orderdbo_table','field' => 'datecompleted'), $this))) ? $this->_run_mod_handler('datetime', true, $_tmp) : smarty_modifier_datetime($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[CUSTOMER]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'orderdbo_table','field' => 'contactname'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ORDER_IP]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'orderdbo_table','field' => 'remoteipstring'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ORDER_TOTAL]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'orderdbo_table','field' => 'total'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>