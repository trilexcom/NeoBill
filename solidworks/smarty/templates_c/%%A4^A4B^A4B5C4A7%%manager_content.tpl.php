<?php /* Smarty version 2.6.14, created on 2007-08-21 12:10:47
         compiled from manager_content.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'manager_content.tpl', 6, false),array('function', 'page_errors', 'manager_content.tpl', 23, false),array('function', 'page_messages', 'manager_content.tpl', 26, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <title>SolidState Manager - <?php echo ((is_array($_tmp=$this->_tpl_vars['location'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
    <script type="text/javascript" src="../solidworks/include.js"></script>
  </head>

  <?php if (isset ( $this->_tpl_vars['jsFunction'] )): ?>
    <body onLoad="<?php echo $this->_tpl_vars['jsFunction']; ?>
">
  <?php else: ?>
    <body>
  <?php endif; ?>
 
    <div class="content">

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "manager_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

            <?php echo smarty_page_errors(array(), $this);?>


            <?php echo smarty_page_messages(array(), $this);?>


            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['content_template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    </div>

  </body>

</html>