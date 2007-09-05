<?php /* Smarty version 2.6.14, created on 2007-08-24 11:58:40
         compiled from manager_BillingPaymentPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_BillingPaymentPage.tpl', 1, false),array('function', 'form_description', 'manager_BillingPaymentPage.tpl', 7, false),array('function', 'form_element', 'manager_BillingPaymentPage.tpl', 8, false),array('block', 'form', 'manager_BillingPaymentPage.tpl', 3, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'ENTER_PAYMENT'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'billing_payment')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table stlye="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'invoiceid_select'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'invoiceid_select'), $this);?>
 </td>
      </tr>
      <tr>
        <th> &nbsp;&nbsp; or <?php echo smarty_form_description(array('field' => 'invoiceid_int'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'invoiceid_int','size' => '5'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'date'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'date'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'type'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'type'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'amount'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'amount','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'status'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'status','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'transaction1'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'transaction1','size' => '20'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'transaction2'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'transaction2','size' => '20'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>
 
        </th>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>