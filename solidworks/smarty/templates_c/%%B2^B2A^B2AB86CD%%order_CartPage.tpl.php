<?php /* Smarty version 2.6.14, created on 2012-03-10 19:10:27
         compiled from order_CartPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'order_CartPage.tpl', 1, false),array('function', 'form_table_checkbox', 'order_CartPage.tpl', 7, false),array('function', 'form_element', 'order_CartPage.tpl', 27, false),array('block', 'form', 'order_CartPage.tpl', 2, false),array('block', 'form_table', 'order_CartPage.tpl', 4, false),array('block', 'form_table_column', 'order_CartPage.tpl', 6, false),array('block', 'form_table_footer', 'order_CartPage.tpl', 26, false),array('modifier', 'currency', 'order_CartPage.tpl', 19, false),)), $this); ?>
<b> <?php echo smarty_echo(array('phrase' => 'YOUR_ORDER'), $this);?>
: </b>
<?php $this->_tag_stack[] = array('form', array('name' => 'cart_mod')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="cart">
    <?php $this->_tag_stack[] = array('form_table', array('field' => 'cart')); $_block_repeat=true;smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => "")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <center> <?php echo smarty_form_table_checkbox(array('option' => $this->_tpl_vars['cart']['orderitemid']), $this);?>
 </center>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'description','header' => "[ITEM]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['cart']['description']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'term','header' => "[TERM]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['cart']['term']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'setupfee','header' => "[SETUP_FEE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['cart']['setupfee'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'price','header' => "[PRICE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['cart']['price'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_footer', array()); $_block_repeat=true;smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_form_element(array('field' => 'addhosting'), $this);?>

        <?php echo smarty_form_element(array('field' => 'adddomain'), $this);?>

        <?php echo smarty_form_element(array('field' => 'remove'), $this);?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  </div>

  <div class="cart_total">
      <table>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'RECURRING_TOTAL'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['recurring_total'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
</td>
        </tr>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'NONRECURRING_TOTAL'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['nonrecurring_total'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
</td>
        </tr>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'CART_TOTAL'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['cart_total'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
</td>
        </tr>
      </table>
      <p>(<?php echo smarty_echo(array('phrase' => 'DOES_NOT_INCLUDE_TAXES'), $this);?>
)</p>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('form', array('name' => 'cart_nav')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left"><?php echo smarty_form_element(array('field' => 'startover'), $this);?>
</td>
        <td class="right">
          <?php echo smarty_form_element(array('field' => 'checkout'), $this);?>

        </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>