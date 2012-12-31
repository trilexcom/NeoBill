<?php /* Smarty version 2.6.14, created on 2012-03-19 19:01:59
         compiled from manager_BrowseInvoicesPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_BrowseInvoicesPage.tpl', 4, false),array('block', 'form_table', 'manager_BrowseInvoicesPage.tpl', 30, false),array('block', 'form_table_column', 'manager_BrowseInvoicesPage.tpl', 32, false),array('function', 'form_element', 'manager_BrowseInvoicesPage.tpl', 5, false),array('function', 'echo', 'manager_BrowseInvoicesPage.tpl', 9, false),array('function', 'form_description', 'manager_BrowseInvoicesPage.tpl', 17, false),array('modifier', 'datetime', 'manager_BrowseInvoicesPage.tpl', 41, false),array('modifier', 'currency', 'manager_BrowseInvoicesPage.tpl', 49, false),)), $this); ?>
<div class="manager_content"</div>
<div class="action">
  <p class="header">Actions</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'browse_invoices_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('phrase' => 'INVOICES'), $this);?>
 </h2>

<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_invoices')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SEARCH'), $this);?>
 </th>
        <td>
          <?php echo smarty_form_description(array('field' => 'accountname'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'accountname','size' => '30'), $this);?>

        </td>
        <td class="submit"> 
          <?php echo smarty_form_element(array('field' => 'search'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="table">
  <?php $this->_tag_stack[] = array('form', array('name' => 'browse_invoices')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('form_table', array('field' => 'invoices','size' => '10')); $_block_repeat=true;smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'id','header' => "[ID]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <a href="./manager_content.php?page=billing_view_invoice&invoice=<?php echo $this->_tpl_vars['invoices']['id']; ?>
"><?php echo $this->_tpl_vars['invoices']['id']; ?>
</a>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'accountname','header' => "[ACCOUNT]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <a href="./manager_content.php?page=accounts_view_account&account=<?php echo $this->_tpl_vars['invoices']['accountid']; ?>
"><?php echo $this->_tpl_vars['invoices']['accountname']; ?>
</a>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'date','header' => "[INVOICE_DATE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['invoices']['date'])) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date')); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'periodbegin','header' => "[BILLING_PERIOD]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['invoices']['periodbegin'])) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date')); ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['invoices']['periodend'])) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date')); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'total','header' => "[INVOICE_TOTAL]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['invoices']['total'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'totalpayments','header' => "[AMOUNT_PAID]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['invoices']['totalpayments'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'balance','header' => "[AMOUNT_DUE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['invoices']['balance'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>