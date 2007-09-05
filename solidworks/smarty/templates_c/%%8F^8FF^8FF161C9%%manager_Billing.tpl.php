<?php /* Smarty version 2.6.14, created on 2007-08-27 11:41:48
         compiled from manager_Billing.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_Billing.tpl', 1, false),array('modifier', 'currency', 'manager_Billing.tpl', 11, false),)), $this); ?>
<h2><?php echo smarty_echo(array('phrase' => 'BILLING_SUMMARY'), $this);?>
</h2>
  <div class="properties">
    <table style="width: 90%">
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'OUTSTANDING_INVOICES'), $this);?>
 </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo $this->_tpl_vars['os_invoices_count']; ?>
</a> </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_generate"><?php echo smarty_echo(array('phrase' => 'GENERATE_INVOICES'), $this);?>
</a> </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'TOTAL_OUTSTANDING_INVOICES'), $this);?>
 </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo ((is_array($_tmp=$this->_tpl_vars['os_invoices_total'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
</a> </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'PAST_DUE_INVOICES'), $this);?>
 </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo $this->_tpl_vars['os_invoices_count_past_due']; ?>
</a> </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'TOTAL_PAST_DUE'), $this);?>
 </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo ((is_array($_tmp=$this->_tpl_vars['os_invoices_total_past_due'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
</a> </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => '30_DAYS_PAST_DUE'), $this);?>
 </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo $this->_tpl_vars['os_invoices_count_past_due_30']; ?>
</a> </td>
      </tr> 
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'TOTAL_30_PAST_DUE'), $this);?>
 </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo ((is_array($_tmp=$this->_tpl_vars['os_invoices_total_past_due_30'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
</a> </td>
        <td class="action_cell"/>
      </tr> 
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'PAYMENTS_RECEIVED'), $this);?>
 <?php echo $this->_tpl_vars['month']; ?>
 </th>
        <td> <?php echo $this->_tpl_vars['payments_count']; ?>
 </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_add_payment">Enter Payment</a> </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'REVENUE_RECEIVED'), $this);?>
 <?php echo $this->_tpl_vars['month']; ?>
 </th>
        <td> <?php echo ((is_array($_tmp=$this->_tpl_vars['payments_total'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
 </td>
      </tr>
    </table>
  </div>