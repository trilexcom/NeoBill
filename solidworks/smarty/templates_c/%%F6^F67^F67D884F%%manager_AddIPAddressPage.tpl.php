<?php /* Smarty version 2.6.14, created on 2007-08-27 11:45:45
         compiled from manager_AddIPAddressPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_AddIPAddressPage.tpl', 1, false),array('function', 'dbo_echo', 'manager_AddIPAddressPage.tpl', 1, false),array('function', 'form_description', 'manager_AddIPAddressPage.tpl', 6, false),array('function', 'form_element', 'manager_AddIPAddressPage.tpl', 7, false),array('block', 'form', 'manager_AddIPAddressPage.tpl', 3, false),)), $this); ?>
<h2><?php echo smarty_echo(array('phrase' => 'ADD_IPS'), $this);?>
 <?php echo smarty_dbo_echo(array('dbo' => 'server_dbo','field' => 'hostname'), $this);?>
</h2>
<div class="form">
  <?php $this->_tag_stack[] = array('form', array('name' => 'add_ip_address')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'begin_address'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'begin_address'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'end_address'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'end_address'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

          <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

        </th>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>