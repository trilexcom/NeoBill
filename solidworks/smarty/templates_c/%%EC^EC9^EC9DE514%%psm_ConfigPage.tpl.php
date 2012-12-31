<?php /* Smarty version 2.6.14, created on 2012-03-15 17:57:41
         compiled from ../../modules/paypalwps/templates/psm_ConfigPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', '../../modules/paypalwps/templates/psm_ConfigPage.tpl', 2, false),array('function', 'form_description', '../../modules/paypalwps/templates/psm_ConfigPage.tpl', 8, false),array('function', 'form_element', '../../modules/paypalwps/templates/psm_ConfigPage.tpl', 9, false),array('block', 'form', '../../modules/paypalwps/templates/psm_ConfigPage.tpl', 4, false),)), $this); ?>
<div class="manager_content"</div>
<h2> <?php echo smarty_echo(array('phrase' => 'PAYPAL_WPS_MODULE'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'psm_config')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'account'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'account','value' => ($this->_tpl_vars['account']),'size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'carturl'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'carturl','value' => ($this->_tpl_vars['cartURL']),'size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'idtoken'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'idtoken','value' => ($this->_tpl_vars['idToken']),'size' => '80'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'currency'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'currency','value' => ($this->_tpl_vars['currency'])), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <td colspan="2"> <?php echo smarty_form_element(array('field' => 'save'), $this);?>
 </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>