<?php /* Smarty version 2.6.14, created on 2012-03-19 19:06:02
         compiled from ../../modules/authorizeaim/templates/aaim_ConfigPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', '../../modules/authorizeaim/templates/aaim_ConfigPage.tpl', 2, false),array('function', 'form_description', '../../modules/authorizeaim/templates/aaim_ConfigPage.tpl', 8, false),array('function', 'form_element', '../../modules/authorizeaim/templates/aaim_ConfigPage.tpl', 9, false),array('block', 'form', '../../modules/authorizeaim/templates/aaim_ConfigPage.tpl', 4, false),)), $this); ?>
<div class="manager_content"</div>
<h2> <?php echo smarty_echo(array('phrase' => 'AUTHORIZENET_AIM_MODULE'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'aaim_config')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'loginid'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'loginid','value' => ($this->_tpl_vars['loginid']),'size' => '10'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'transactionkey'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'transactionkey','value' => ($this->_tpl_vars['transactionkey']),'size' => '50'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'transactionurl'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'transactionurl','value' => ($this->_tpl_vars['transactionurl']),'size' => '50'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'delimiter'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'delimiter','value' => ($this->_tpl_vars['delimiter']),'size' => '1'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          <?php echo smarty_form_element(array('field' => 'save'), $this);?>

        </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>