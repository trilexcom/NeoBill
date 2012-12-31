<?php /* Smarty version 2.6.14, created on 2012-03-10 19:11:43
         compiled from order_ReviewPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'order_ReviewPage.tpl', 5, false),array('function', 'dbo_echo', 'order_ReviewPage.tpl', 12, false),array('function', 'dbo_assign', 'order_ReviewPage.tpl', 124, false),array('function', 'form_description', 'order_ReviewPage.tpl', 149, false),array('function', 'form_element', 'order_ReviewPage.tpl', 150, false),array('modifier', 'country', 'order_ReviewPage.tpl', 56, false),array('modifier', 'currency', 'order_ReviewPage.tpl', 114, false),array('block', 'form', 'order_ReviewPage.tpl', 101, false),array('block', 'form_table', 'order_ReviewPage.tpl', 103, false),array('block', 'form_table_column', 'order_ReviewPage.tpl', 105, false),)), $this); ?>
<h2>Please Review Your Order</h2>

<div class="domainoption">
  <table>
    <tr class="reverse"> <th> <?php echo smarty_echo(array('phrase' => 'CONTACT_EMAIL'), $this);?>
 </th> </tr>
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'EMAIL'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'contactemail'), $this);?>
 </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

  <table>
    <tr class="reverse"> <th> Account Information </th> </tr> <!-- hardcoded english -->
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'BUSINESS_NAME'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'businessname'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'CONTACT_NAME'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'contactname'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'ADDRESS'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'address1'), $this);?>
 </td>
            </tr>
            <tr>
              <td> </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'address2'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'CITY'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'city'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'STATE'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'state'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'ZIP_POSTAL_CODE'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'postalcode'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'COUNTRY'), $this);?>
: </td>
              <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'order','field' => 'country'), $this))) ? $this->_run_mod_handler('country', true, $_tmp) : smarty_modifier_country($_tmp));?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'PHONE'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'phone'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'MOBILE_PHONE'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'mobilephone'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'FAX'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'fax'), $this);?>
 </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>

  </table>
</div>

<div class="domainoption">
  <table>
    <tr class="reverse"> <th> <?php echo smarty_echo(array('phrase' => 'LOGIN_INFORMATION'), $this);?>
 </th> </tr>
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'USERNAME'), $this);?>
: </td>
              <td> <?php echo smarty_dbo_echo(array('dbo' => 'order','field' => 'username'), $this);?>
 </td>
            </tr>
            <tr>
              <td> <?php echo smarty_echo(array('phrase' => 'PASSWORD'), $this);?>
: </td>
              <td> <i><?php echo smarty_echo(array('phrase' => 'NOT_SHOWN'), $this);?>
</i> </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

</div>

<?php $this->_tag_stack[] = array('form', array('name' => 'review')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="cart">
    <?php $this->_tag_stack[] = array('form_table', array('field' => 'cart')); $_block_repeat=true;smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

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

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  </div>

  <?php echo smarty_dbo_assign(array('dbo' => 'order','field' => 'accounttype','var' => 'accounttype'), $this);?>

  <?php if ($this->_tpl_vars['accounttype'] == 'New Account'): ?>
    <div class="cart_total">
      <table>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'RECURRING_TOTAL'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'order','field' => 'recurringtotal'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
</td>
        </tr>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'NONRECURRING_TOTAL'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'order','field' => 'nonrecurringtotal'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
</td>
        </tr>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'SUB_TOTAL'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'order','field' => 'subtotal'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
</td>
        </tr>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'TAXES'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'order','field' => 'taxtotal'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
</td>
        </tr>
        <tr>
          <th><?php echo smarty_echo(array('phrase' => 'TOTAL'), $this);?>
:</th>
          <td><?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'order','field' => 'total'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
</td>
        </tr>
        <tr>
          <th><?php echo smarty_form_description(array('field' => 'module'), $this);?>
&nbsp;&nbsp;</th>
          <td><?php echo smarty_form_element(array('field' => 'module'), $this);?>
</td>
        </tr>
        <?php if ($this->_tpl_vars['tos_required']): ?>
          <tr>
            <td/>
            <td>
              <?php echo smarty_form_element(array('field' => 'accept_tos','option' => 'true'), $this);?>

              [I_HAVE_READ_AND_AGREE_TO_THE] 
              <a href="<?php echo $this->_tpl_vars['tos_url']; ?>
" target="_blank">[TERMS_OF_SERVICE]</a>
            </td>
          </tr>
        <?php endif; ?>
      </table>
    </div>
  <?php else: ?>
    <p> <b><?php echo smarty_echo(array('phrase' => 'YOUR_ACCOUNT_WILL_BE_BILLED'), $this);?>
</b> </p>
  <?php endif; ?>

  <p/>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left"> <?php echo smarty_form_element(array('field' => 'startover'), $this);?>
 </td>
        <td class="right">
          <?php echo smarty_form_element(array('field' => 'back'), $this);?>

          <?php echo smarty_form_element(array('field' => 'checkout'), $this);?>

        </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<p/>