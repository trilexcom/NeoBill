<?php /* Smarty version 2.6.14, created on 2007-08-24 11:58:36
         compiled from manager_OutstandingInvoicesPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_OutstandingInvoicesPage.tpl', 2, false),array('function', 'form_element', 'manager_OutstandingInvoicesPage.tpl', 4, false),array('function', 'form_description', 'manager_OutstandingInvoicesPage.tpl', 16, false),array('function', 'dbo_echo', 'manager_OutstandingInvoicesPage.tpl', 39, false),array('block', 'form', 'manager_OutstandingInvoicesPage.tpl', 3, false),array('block', 'dbo_table', 'manager_OutstandingInvoicesPage.tpl', 32, false),array('block', 'dbo_table_column', 'manager_OutstandingInvoicesPage.tpl', 38, false),array('modifier', 'datetime', 'manager_OutstandingInvoicesPage.tpl', 47, false),array('modifier', 'currency', 'manager_OutstandingInvoicesPage.tpl', 56, false),)), $this); ?>
<div class="action">
  <p class="header"><?php echo smarty_echo(array('phrase' => 'ACTIONS'), $this);?>
</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'browse_invoices_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('phrase' => 'OUTSTANDING_INVOICES'), $this);?>
 </h2>

<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_outstanding_invoicedbo_table')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SEARCH'), $this);?>
 </th>
        <td>
          <?php echo smarty_form_description(array('field' => 'id'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'id','size' => '4'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'accountid'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'accountid','size' => '4'), $this);?>

        </td>
        <td class="submit"> 
          <?php echo smarty_form_element(array('field' => 'search'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'InvoiceDBO','name' => 'invoicedbo_table','title' => "[OUTSTANDING_INVOICES]",'size' => '10','filter' => "outstanding = 'yes'")); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  
    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ID]",'sort_field' => 'id')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="./manager_content.php?page=billing_view_invoice&id=<?php echo smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'id'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'id'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ACCOUNT]",'sort_field' => 'accountid')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="./manager_content.php?page=accounts_view_account&id=<?php echo smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'accountid'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'accountname'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[INVOICE_DATE]",'sort_field' => 'date')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'date'), $this))) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date'));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[BILLING_PERIOD]",'sort_field' => 'periodbegin')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'periodbegin'), $this))) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date'));?>
 -
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'periodend'), $this))) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date'));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[INVOICE_TOTAL]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'total'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[AMOUNT_PAID]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'totalpayments'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[AMOUNT_DUE]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'invoicedbo_table','field' => 'balance'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>