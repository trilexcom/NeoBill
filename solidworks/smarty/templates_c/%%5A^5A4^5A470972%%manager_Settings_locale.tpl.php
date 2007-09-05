<?php /* Smarty version 2.6.14, created on 2007-08-21 13:09:49
         compiled from manager_Settings_locale.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_Settings_locale.tpl', 2, false),array('function', 'form_description', 'manager_Settings_locale.tpl', 14, false),array('function', 'form_element', 'manager_Settings_locale.tpl', 15, false),array('block', 'form', 'manager_Settings_locale.tpl', 11, false),)), $this); ?>
<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> <?php echo smarty_echo(array('phrase' => 'GENERAL'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> <?php echo smarty_echo(array('phrase' => 'BILLING'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> <?php echo smarty_echo(array('phrase' => 'DNS'), $this);?>
 </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=locale"> <?php echo smarty_echo(array('phrase' => 'LOCALE'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> <?php echo smarty_echo(array('phrase' => 'PAYMENTS'), $this);?>
 </a> </li> </li>
</ul>

<h2> <?php echo smarty_echo(array('phrase' => 'LOCALE'), $this);?>
 </h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'settings_locale')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table style="width: 95%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'language'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'language'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'currency'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'currency','value' => ($this->_tpl_vars['currency']),'size' => '5'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          <?php echo smarty_form_element(array('field' => 'save'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>