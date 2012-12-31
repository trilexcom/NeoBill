<?php /* Smarty version 2.6.14, created on 2012-03-10 19:04:03
         compiled from manager_content.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'page_errors', 'manager_content.tpl', 31, false),array('function', 'page_messages', 'manager_content.tpl', 35, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo $this->_tpl_vars['company_name']; ?>
 - Manager Interface</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
    <script src="js/jquery-1.7.js"></script>
	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.ui.position.js"></script>
	<script src="js/jquery.ui.button.js"></script>
	<script src="js/jquery.ui.menu.js"></script>
	<script src="js/jquery.ui.menubar.js"></script>
    <script src="js/jquery.ui.menuitem.js"></script>
    <link rel="stylesheet" href="css/demos.css" type="text/css" />
	<link rel="stylesheet" href="css/jquery.ui.all.css" />
	
  </head>

  <?php if (isset ( $this->_tpl_vars['jsFunction'] )): ?>
    <body onLoad="<?php echo $this->_tpl_vars['jsFunction']; ?>
">
  <?php else: ?>
    <body>
  <?php endif; ?>
 
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['header_template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

            <div class="manager_error"><?php echo smarty_page_errors(array(), $this);?>

      </div>

            <div class="manager_error"><?php echo smarty_page_messages(array(), $this);?>

      </div>

           <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['content_template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



  </body>

</html>