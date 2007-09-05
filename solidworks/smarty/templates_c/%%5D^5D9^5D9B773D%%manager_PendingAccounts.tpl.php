<?php /* Smarty version 2.6.14, created on 2007-08-24 11:58:29
         compiled from manager_PendingAccounts.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_PendingAccounts.tpl', 2, false),array('function', 'form_element', 'manager_PendingAccounts.tpl', 4, false),array('function', 'form_description', 'manager_PendingAccounts.tpl', 15, false),array('function', 'dbo_echo', 'manager_PendingAccounts.tpl', 42, false),array('block', 'form', 'manager_PendingAccounts.tpl', 3, false),array('block', 'dbo_table', 'manager_PendingAccounts.tpl', 35, false),array('block', 'dbo_table_column', 'manager_PendingAccounts.tpl', 41, false),array('modifier', 'currency', 'manager_PendingAccounts.tpl', 50, false),)), $this); ?>
<div class="action">
  <p class="header"><?php echo smarty_echo(array('phrase' => 'ACTIONS'), $this);?>
</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'browse_accounts_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('phrase' => 'PENDING_ACCOUNTS'), $this);?>
 </h2>
<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_pending_accountdbo_table')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
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
          <?php echo smarty_form_description(array('field' => 'contactname'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'contactname','size' => '30'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'businessname'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'businessname','size' => '30'), $this);?>

        </td>
        <td class="submit"> 
          <?php echo smarty_form_element(array('field' => 'search'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'AccountDBO','name' => 'pending_accountdbo_table','filter' => "status='Pending'",'title' => "[ACCOUNTS]",'size' => '10')); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ID]",'sort_field' => 'id')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a target="content" href="manager_content.php?page=accounts_view_account&id=<?php echo smarty_dbo_echo(array('dbo' => 'pending_accountdbo_table','field' => 'id'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'pending_accountdbo_table','field' => 'id'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ACCOUNT_NAME]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a target="content" href="manager_content.php?page=accounts_view_account&id=<?php echo smarty_dbo_echo(array('dbo' => 'pending_accountdbo_table','field' => 'id'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'pending_accountdbo_table','field' => 'accountname'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[BALANCE]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'pending_accountdbo_table','field' => 'balance'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[STATUS]",'sort_field' => 'status')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'pending_accountdbo_table','field' => 'status'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>