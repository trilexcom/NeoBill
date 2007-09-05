<?php /* Smarty version 2.6.14, created on 2007-08-24 11:55:57
         compiled from manager_Modules.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_Modules.tpl', 1, false),array('function', 'dbo_assign', 'manager_Modules.tpl', 10, false),array('function', 'form_element', 'manager_Modules.tpl', 14, false),array('function', 'dbo_echo', 'manager_Modules.tpl', 31, false),array('block', 'form', 'manager_Modules.tpl', 3, false),array('block', 'dbo_table', 'manager_Modules.tpl', 5, false),array('block', 'dbo_table_column', 'manager_Modules.tpl', 9, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'MODULES'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'modules')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="table">
    <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'ModuleDBO','name' => 'moduledbo_table','title' => "[INSTALLED_MODULES]")); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

      <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ENABLED]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_dbo_assign(array('dbo' => 'moduledbo_table','field' => 'name','var' => 'module_name'), $this);?>

        <?php echo smarty_dbo_assign(array('dbo' => 'moduledbo_table','field' => 'enabled','var' => 'enabled'), $this);?>

        <center>
          <?php if ($this->_tpl_vars['enabled'] == 'Yes'): ?>
            <?php echo smarty_form_element(array('field' => 'enabled','value' => ($this->_tpl_vars['module_name']),'checked' => 'true'), $this);?>

          <?php else: ?>
            <?php echo smarty_form_element(array('field' => 'enabled','value' => ($this->_tpl_vars['module_name'])), $this);?>

          <?php endif; ?>
        </center>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[MODULE_NAME]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_dbo_assign(array('dbo' => 'moduledbo_table','field' => 'configpage','var' => 'configpage'), $this);?>

        <?php if ($this->_tpl_vars['configpage'] == null): ?>
          <?php echo $this->_tpl_vars['module_name']; ?>

        <?php else: ?>
          <a href="manager_content.php?page=<?php echo $this->_tpl_vars['configpage']; ?>
"><?php echo $this->_tpl_vars['module_name']; ?>
</a>
        <?php endif; ?>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[TYPE]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_dbo_echo(array('dbo' => 'moduledbo_table','field' => 'type'), $this);?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[DESCRIPTION]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_dbo_echo(array('dbo' => 'moduledbo_table','field' => 'description'), $this);?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php echo smarty_form_element(array('field' => 'update'), $this);?>


  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>