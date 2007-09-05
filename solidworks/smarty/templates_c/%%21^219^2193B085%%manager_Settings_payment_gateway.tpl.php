<?php /* Smarty version 2.6.14, created on 2007-08-21 13:09:52
         compiled from manager_Settings_payment_gateway.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_Settings_payment_gateway.tpl', 2, false),array('function', 'form_description', 'manager_Settings_payment_gateway.tpl', 15, false),array('function', 'form_element', 'manager_Settings_payment_gateway.tpl', 16, false),array('block', 'form', 'manager_Settings_payment_gateway.tpl', 12, false),)), $this); ?>
<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> <?php echo smarty_echo(array('phrase' => 'GENERAL'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> <?php echo smarty_echo(array('phrase' => 'BILLING'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> <?php echo smarty_echo(array('phrase' => 'DNS'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> <?php echo smarty_echo(array('phrase' => 'LOCALE'), $this);?>
 </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=payment_gateway"> <?php echo smarty_echo(array('phrase' => 'PAYMENTS'), $this);?>
 </a> </li>
</ul>

<h2> <?php echo smarty_echo(array('phrase' => 'PAYMENT_GATEWAY'), $this);?>
 </h2>
<?php if ($this->_tpl_vars['gatewaysAreEnabled']): ?>
  <div class="form">
    <?php $this->_tag_stack[] = array('form', array('name' => 'settings_payment_gateway')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <table style="width: 95%">
        <tr>
          <th> <?php echo smarty_form_description(array('field' => 'default_module'), $this);?>
 </th>
          <td> <?php echo smarty_form_element(array('field' => 'default_module'), $this);?>
 </td>
        </tr>
        <tr>
          <th> <?php echo smarty_form_description(array('field' => 'order_method'), $this);?>
 </th>
          <td> <?php echo smarty_form_element(array('field' => 'order_method'), $this);?>
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
<?php else: ?>
  <p> <?php echo smarty_echo(array('phrase' => 'THERE_ARE_NO_GATEWAY_MODULES'), $this);?>
 </p>
<?php endif; ?>

<h2> <?php echo smarty_echo(array('phrase' => 'ORDER_INTERFACE'), $this);?>
 </h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'settings_order_interface')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table style="width: 95%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'accept_checks'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'accept_checks','value' => ($this->_tpl_vars['order_accept_checks'])), $this);?>
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