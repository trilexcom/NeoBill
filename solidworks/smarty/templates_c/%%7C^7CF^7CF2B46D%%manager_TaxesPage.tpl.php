<?php /* Smarty version 2.6.14, created on 2007-08-21 13:08:59
         compiled from manager_TaxesPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_TaxesPage.tpl', 2, false),array('function', 'form_element', 'manager_TaxesPage.tpl', 4, false),array('function', 'dbo_echo', 'manager_TaxesPage.tpl', 16, false),array('function', 'dbo_assign', 'manager_TaxesPage.tpl', 24, false),array('block', 'form', 'manager_TaxesPage.tpl', 3, false),array('block', 'dbo_table', 'manager_TaxesPage.tpl', 11, false),array('block', 'dbo_table_column', 'manager_TaxesPage.tpl', 15, false),array('modifier', 'country', 'manager_TaxesPage.tpl', 20, false),)), $this); ?>
<div class="action">
  <p class="header"><?php echo smarty_echo(array('phrase' => 'ACTIONS'), $this);?>
</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'taxes_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('phrase' => 'TAXES'), $this);?>
 </h2>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'TaxRuleDBO','name' => 'taxruledbo_table','title' => "[TAX_RULES]")); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ID]",'sort_field' => 'id')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'taxruledbo_table','field' => 'id'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[COUNTRY]",'sort_field' => 'country')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'taxruledbo_table','field' => 'country'), $this))) ? $this->_run_mod_handler('country', true, $_tmp) : smarty_modifier_country($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[STATE]",'sort_field' => 'state')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_assign(array('dbo' => 'taxruledbo_table','field' => 'allstates','var' => 'allstates'), $this);?>

      <?php if ($this->_tpl_vars['allstates'] == 'Yes'): ?>
        <?php echo smarty_echo(array('phrase' => 'ALL'), $this);?>

      <?php else: ?>
        <?php echo smarty_dbo_echo(array('dbo' => 'taxruledbo_table','field' => 'state'), $this);?>

      <?php endif; ?>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[DESCRIPTION]",'sort_field' => 'description')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'taxruledbo_table','field' => 'description'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[TAX_RATE]",'sort_field' => 'rate')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'taxruledbo_table','field' => 'rate'), $this);?>
%
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ACTION]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="manager_content.php?page=taxes&action=remove&id=<?php echo smarty_dbo_echo(array('dbo' => 'taxruledbo_table','field' => 'id'), $this);?>
"><?php echo smarty_echo(array('phrase' => 'REMOVE'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>