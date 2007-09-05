<?php /* Smarty version 2.6.14, created on 2007-08-27 12:27:20
         compiled from manager_ServicesNewHostingPage_confirm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_ServicesNewHostingPage_confirm.tpl', 2, false),array('function', 'dbo_echo', 'manager_ServicesNewHostingPage_confirm.tpl', 10, false),array('function', 'form_element', 'manager_ServicesNewHostingPage_confirm.tpl', 56, false),array('block', 'form', 'manager_ServicesNewHostingPage_confirm.tpl', 4, false),array('modifier', 'currency', 'manager_ServicesNewHostingPage_confirm.tpl', 20, false),)), $this); ?>
<p class="message"> 
  <?php echo smarty_echo(array('phrase' => 'CONFIRM_HOSTING'), $this);?>

</p>
<?php $this->_tag_stack[] = array('form', array('name' => 'new_hosting_confirm')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <h2> <?php echo smarty_echo(array('phrase' => 'ADD_HOSTING'), $this);?>
  </h2>
  <div class="properties">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'TITLE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'title'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'DESCRIPTION'), $this);?>
: </th>
        <td>
          <textarea cols="40" rows="3" readonly="readonly"><?php echo smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'description'), $this);?>
</textarea>
        </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SETUP_PRICE'), $this);?>
 (1 <?php echo smarty_echo(array('phrase' => 'MONTH'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'setupprice1mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SETUP_PRICE'), $this);?>
 (3 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'setupprice3mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SETUP_PRICE'), $this);?>
 (6 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'setupprice6mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SETUP_PRICE'), $this);?>
 (12 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'setupprice12mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'RECURRING_PRICE'), $this);?>
 (1 <?php echo smarty_echo(array('phrase' => 'MONTH'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'price1mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'RECURRING_PRICE'), $this);?>
 (3 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'price3mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'RECURRING_PRICE'), $this);?>
 (6 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'price6mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'RECURRING_PRICE'), $this);?>
 (12 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
): </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'price12mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'TAXABLE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_hosting_dbo','field' => 'taxable'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th class="footer"> 
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

          <?php echo smarty_form_element(array('field' => 'goback'), $this);?>

        </th>
        <td/>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>