<?php /* Smarty version 2.6.14, created on 2007-08-21 13:09:29
         compiled from manager_Settings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_Settings.tpl', 2, false),array('function', 'form_description', 'manager_Settings.tpl', 14, false),array('function', 'form_element', 'manager_Settings.tpl', 15, false),array('block', 'form', 'manager_Settings.tpl', 11, false),)), $this); ?>
<ul id="tabnav">
  <li class="selected"> <a href="manager_content.php?page=settings&action=general"> <?php echo smarty_echo(array('phrase' => 'GENERAL'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> <?php echo smarty_echo(array('phrase' => 'BILLING'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> <?php echo smarty_echo(array('phrase' => 'DNS'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> <?php echo smarty_echo(array('phrase' => 'LOCALE'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> <?php echo smarty_echo(array('phrase' => 'PAYMENTS'), $this);?>
 </a> </li>
</ul>

<h2> <?php echo smarty_echo(array('phrase' => 'COMPANY'), $this);?>
 </h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'settings_company')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table style="width: 95%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'name'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'name','value' => ($this->_tpl_vars['company_name']),'size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'email'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'email','value' => ($this->_tpl_vars['company_email']),'size' => '30'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'notification_email'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'notification_email','value' => ($this->_tpl_vars['company_notification_email']),'size' => '30'), $this);?>
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

<h2> <?php echo smarty_echo(array('phrase' => 'WELCOME_EMAIL'), $this);?>
 </h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'settings_welcome')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table style="width: 95%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'subject'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'subject','value' => ($this->_tpl_vars['welcome_subject']),'size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th colspan="2"> <?php echo smarty_form_description(array('field' => 'email'), $this);?>
 </th>
      </tr>
      <tr>
        <td colspan="2"> <?php echo smarty_form_element(array('field' => 'email','value' => ($this->_tpl_vars['welcome_email']),'cols' => '80','rows' => '10'), $this);?>
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

<h2> <?php echo smarty_echo(array('phrase' => 'ORDER_CONFIRMATION_EMAIL'), $this);?>
 </h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'settings_confirmation')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table style="width: 95%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'subject'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'subject','value' => ($this->_tpl_vars['confirmation_subject']),'size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th colspan="2"> <?php echo smarty_form_description(array('field' => 'email'), $this);?>
 </th>
      </tr>
      <tr>
        <td colspan="2"> <?php echo smarty_form_element(array('field' => 'email','value' => ($this->_tpl_vars['confirmation_email']),'cols' => '80','rows' => '10'), $this);?>
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

<h2> <?php echo smarty_echo(array('phrase' => 'ORDER_NOTIFICATION_EMAIL'), $this);?>
 </h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'settings_notification')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table style="width: 95%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'subject'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'subject','value' => ($this->_tpl_vars['notification_subject']),'size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th colspan="2"> <?php echo smarty_form_description(array('field' => 'email'), $this);?>
 </th>
      </tr>
      <tr>
        <td colspan="2"> <?php echo smarty_form_element(array('field' => 'email','value' => ($this->_tpl_vars['notification_email']),'cols' => '80','rows' => '10'), $this);?>
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