<?php /* Smarty version 2.6.14, created on 2012-03-15 15:27:24
         compiled from ../../modules/paypalwps/templates/pso_CheckoutPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', '../../modules/paypalwps/templates/pso_CheckoutPage.tpl', 19, false),array('function', 'form_element', '../../modules/paypalwps/templates/pso_CheckoutPage.tpl', 34, false),array('block', 'form', '../../modules/paypalwps/templates/pso_CheckoutPage.tpl', 33, false),)), $this); ?>
<div class="manager_content"></div>
<form action="<?php echo $this->_tpl_vars['cartURL']; ?>
" method="POST">
  <input type="hidden" name="cmd" value="_cart"/>
  <input type="hidden" name="upload" value="1"/>
  <input type="hidden" name="custom" value="<?php echo $this->_tpl_vars['orderid']; ?>
"/>
  <input type="hidden" name="business" value="<?php echo $this->_tpl_vars['account']; ?>
"/>
  <input type="hidden" name="currency_code" value="<?php echo $this->_tpl_vars['currencyCode']; ?>
"/>

    <?php $_from = $this->_tpl_vars['paypalCart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cartloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cartloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['itemnum'] => $this->_tpl_vars['cartitem']):
        $this->_foreach['cartloop']['iteration']++;
?>
    <input type="hidden" name="item_name_<?php echo $this->_tpl_vars['itemnum']+1; ?>
" value="<?php echo $this->_tpl_vars['cartitem']['name']; ?>
"/>
    <input type="hidden" name="quantity_<?php echo $this->_tpl_vars['itemnum']+1; ?>
" value="<?php echo $this->_tpl_vars['cartitem']['quantity']; ?>
"/>
    <input type="hidden" name="amount_<?php echo $this->_tpl_vars['itemnum']+1; ?>
" value="<?php echo $this->_tpl_vars['cartitem']['amount']; ?>
"/>
    <input type="hidden" name="tax_<?php echo $this->_tpl_vars['itemnum']+1; ?>
" value="<?php echo $this->_tpl_vars['cartitem']['tax']; ?>
"/>
  <?php endforeach; endif; unset($_from); ?>

  <div class="domainoption">
    <table>
      <tr class="reverse"> <td colspan="2"> <?php echo smarty_echo(array('phrase' => 'PAY_WITH_PAYPAL'), $this);?>
 </td> </tr>
      <tr> 
        <td colspan="2"> 
          <?php echo smarty_echo(array('phrase' => 'PAY_WITH_PAYPAL_TEXT'), $this);?>

          <p align="center"> <input type="submit" value="Pay with Paypal"/> </p>
        </td>
      </tr>
    </table>
  </div>
</form>
<div class="buttoncontainer">
  <table>
    <tr class="buttoncontainer">
      <td class="left">
        <?php $this->_tag_stack[] = array('form', array('name' => 'pso_checkout')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
          <?php echo smarty_form_element(array('field' => 'startover'), $this);?>

        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </td>
      <td class="right">
        <?php $this->_tag_stack[] = array('form', array('name' => 'pso_checkout')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
          <?php echo smarty_form_element(array('field' => 'back'), $this);?>

        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </td>
  </table>
</div>