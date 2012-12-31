<?php /* Smarty version 2.6.14, created on 2012-03-10 19:04:03
         compiled from manager_HomePage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_HomePage.tpl', 2, false),array('modifier', 'currency', 'manager_HomePage.tpl', 12, false),)), $this); ?>
<div class="manager_content"</div>
<h2> <?php echo smarty_echo(array('phrase' => 'BILLING_SUMMARY'), $this);?>
 </h2> 
  <div class="properties">
    <table style="width: 90%">
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo smarty_echo(array('phrase' => 'OUTSTANDING_INVOICES'), $this);?>
 </a></th>
        <td> <?php echo $this->_tpl_vars['os_invoices_count']; ?>
</a> </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_generate"><?php echo smarty_echo(array('phrase' => 'GENERATE_INVOICES'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo smarty_echo(array('phrase' => 'TOTAL_OUTSTANDING_INVOICES'), $this);?>
 </a></th>
        <td> <?php echo ((is_array($_tmp=$this->_tpl_vars['os_invoices_total'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
 </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo smarty_echo(array('phrase' => 'PAST_DUE_INVOICES'), $this);?>
 </a></th>
        <td> <?php echo $this->_tpl_vars['os_invoices_count_past_due']; ?>
 </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo smarty_echo(array('phrase' => 'TOTAL_PAST_DUE'), $this);?>
 </a></th>
        <td> <?php echo ((is_array($_tmp=$this->_tpl_vars['os_invoices_total_past_due'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
 </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo smarty_echo(array('phrase' => '30_DAYS_PAST_DUE'), $this);?>
 </a></th>
        <td> <?php echo $this->_tpl_vars['os_invoices_count_past_due_30']; ?>
 </td>
      </tr> 
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding"><?php echo smarty_echo(array('phrase' => 'TOTAL_30_PAST_DUE'), $this);?>
 </a></th>
        <td> <?php echo ((is_array($_tmp=$this->_tpl_vars['os_invoices_total_past_due_30'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>
 </td>
        <td class="action_cell"/>
      </tr> 
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'PAYMENTS_RECEIVED'), $this);?>
 <?php echo $this->_tpl_vars['month']; ?>
 </th>
        <td> <?php echo $this->_tpl_vars['payments_count']; ?>
 </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_add_payment"><?php echo smarty_echo(array('phrase' => 'ENTER_PAYMENT'), $this);?>
</a> </td>
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

<h2> <?php echo smarty_echo(array('phrase' => 'ACCOUNTS_SUMMARY'), $this);?>
 </h2>
<p/>
<div class="properties">
  <table style="width: 90%">
    <tr>
      <th> <a href="manager_content.php?page=accounts_browse"><?php echo smarty_echo(array('phrase' => 'ACTIVE_ACCOUNTS'), $this);?>
 </a></th>
      <td> <?php echo $this->_tpl_vars['active_accounts_count']; ?>
 </td>
      <td class="action_cell"> &raquo; <a href="manager_content.php?page=accounts_new_account"><?php echo smarty_echo(array('phrase' => 'CREATE_NEW_ACCOUNT'), $this);?>
</a> </td>
    </tr>
    <tr>
      <th> <a href="manager_content.php?page=accounts_browse_inactive"><?php echo smarty_echo(array('phrase' => 'INACTIVE_ACCOUNTS'), $this);?>
 </a></th>
      <td> <?php echo $this->_tpl_vars['inactive_accounts_count']; ?>
 </td>
      <td class="action_cell"/>
    </tr>
    <tr>
      <th> <?php echo smarty_echo(array('phrase' => 'ALL_ACCOUNTS'), $this);?>
 </th>
      <td> <?php echo $this->_tpl_vars['total_accounts']; ?>
 </td>
      <td class="action_cell"/>
    </tr>
    <tr>
      <th> <a href="manager_content.php?page=accounts_browse_pending"><?php echo smarty_echo(array('phrase' => 'PENDING_ACCOUNTS'), $this);?>
 </a></th>
      <td> <?php echo $this->_tpl_vars['pending_accounts_count']; ?>
 </td>
      <td class="action_cell"/>
    </tr>
  </table>
</div>