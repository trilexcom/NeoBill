<?php /* Smarty version 2.6.14, created on 2007-08-27 11:40:57
         compiled from manager_LoginPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'manager_LoginPage.tpl', 6, false),array('function', 'page_errors', 'manager_LoginPage.tpl', 12, false),array('function', 'echo', 'manager_LoginPage.tpl', 17, false),array('function', 'form_element', 'manager_LoginPage.tpl', 20, false),array('block', 'form', 'manager_LoginPage.tpl', 16, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <title>Solid-State Manager - <?php echo ((is_array($_tmp=$this->_tpl_vars['location'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
  </head>

  <body>

    <?php echo smarty_page_errors(array(), $this);?>


    <div class="login">

      <?php $this->_tag_stack[] = array('form', array('name' => 'login')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>  
        <h1>Solid-State <?php echo smarty_echo(array('phrase' => 'LOGIN'), $this);?>
</h1>

        <p><?php echo smarty_echo(array('phrase' => 'USERNAME'), $this);?>
:</p>
        <?php echo smarty_form_element(array('field' => 'username','size' => '30'), $this);?>


        <p><?php echo smarty_echo(array('phrase' => 'PASSWORD'), $this);?>
:</p>
        <?php echo smarty_form_element(array('field' => 'password','size' => '30'), $this);?>
<br/>

        <br/><?php echo smarty_form_element(array('field' => 'continue'), $this);?>


      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>
  </body>
</html>