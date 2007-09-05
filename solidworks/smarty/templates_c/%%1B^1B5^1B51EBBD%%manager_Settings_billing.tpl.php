<?php /* Smarty version 2.6.14, created on 2007-08-21 13:09:45
         compiled from manager_Settings_billing.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_Settings_billing.tpl', 2, false),array('function', 'form_description', 'manager_Settings_billing.tpl', 14, false),array('function', 'form_element', 'manager_Settings_billing.tpl', 17, false),array('block', 'form', 'manager_Settings_billing.tpl', 11, false),)), $this); ?>
<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> <?php echo smarty_echo(array('phrase' => 'GENERAL'), $this);?>
 </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=billing"> <?php echo smarty_echo(array('phrase' => 'BILLING'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> <?php echo smarty_echo(array('phrase' => 'DNS'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> <?php echo smarty_echo(array('phrase' => 'LOCALE'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> <?php echo smarty_echo(array('phrase' => 'PAYMENTS'), $this);?>
 </a> </li>
</ul>

<h2> <?php echo smarty_echo(array('phrase' => 'INVOICE'), $this);?>
 </h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'settings_invoice')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table style="width: 95%">
      <tr>
        <th colspan="2"> <?php echo smarty_form_description(array('field' => 'subject'), $this);?>
 </th>
      </tr>
      <tr>
        <td colspan="2"> <?php echo smarty_form_element(array('field' => 'subject','value' => ($this->_tpl_vars['invoice_subject']),'size' => '80'), $this);?>
 </td>
      </tr>
      <tr>
        <th colspan="2"> <?php echo smarty_form_description(array('field' => 'text'), $this);?>
 </th>
      </tr>
      <tr>
        <td colspan="2"> <?php echo smarty_form_element(array('field' => 'text','value' => ($this->_tpl_vars['invoice_text']),'cols' => '80','rows' => '20'), $this);?>
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