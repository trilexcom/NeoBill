<?php /* Smarty version 2.6.14, created on 2012-03-10 19:07:46
         compiled from manager_Modules.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_Modules.tpl', 2, false),array('function', 'form_table_checkbox', 'manager_Modules.tpl', 9, false),array('function', 'form_element', 'manager_Modules.tpl', 29, false),array('block', 'form', 'manager_Modules.tpl', 5, false),array('block', 'form_table', 'manager_Modules.tpl', 6, false),array('block', 'form_table_column', 'manager_Modules.tpl', 8, false),array('block', 'form_table_footer', 'manager_Modules.tpl', 28, false),)), $this); ?>
<div class="manager_content"</div>
<h2> <?php echo smarty_echo(array('phrase' => 'MODULES'), $this);?>
 </h2>

<div class="table">
  <?php $this->_tag_stack[] = array('form', array('name' => 'modules')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('form_table', array('field' => 'modules')); $_block_repeat=true;smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => "",'header' => "[ENABLED]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <center> <?php echo smarty_form_table_checkbox(array('option' => $this->_tpl_vars['modules']['name']), $this);?>
 </center>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'name','header' => "[MODULE_NAME]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php if ($this->_tpl_vars['modules']['configpage'] == null): ?>
          <?php echo $this->_tpl_vars['modules']['name']; ?>

        <?php else: ?>
          <a href="manager_content.php?page=<?php echo $this->_tpl_vars['modules']['configpage']; ?>
"><?php echo $this->_tpl_vars['modules']['name']; ?>
</a>
        <?php endif; ?>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'type','header' => "[TYPE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['modules']['type']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'description','header' => "[DESCRIPTION]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['modules']['description']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_footer', array()); $_block_repeat=true;smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_form_element(array('field' => 'update'), $this);?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>