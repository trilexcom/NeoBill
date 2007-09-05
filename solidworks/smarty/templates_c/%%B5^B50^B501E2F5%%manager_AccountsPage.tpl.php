<?php /* Smarty version 2.6.14, created on 2007-08-27 11:41:52
         compiled from manager_AccountsPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_AccountsPage.tpl', 1, false),array('function', 'form_description', 'manager_AccountsPage.tpl', 8, false),array('function', 'form_element', 'manager_AccountsPage.tpl', 9, false),array('block', 'form', 'manager_AccountsPage.tpl', 3, false),)), $this); ?>
<h2><?php echo smarty_echo(array('phrase' => 'ACCOUNTS_SUMMARY'), $this);?>
</h2>
<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_accountdbo_table')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
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
<p/>
<div class="properties">
  <table width="90%">
    <tr>
      <th> <?php echo smarty_echo(array('phrase' => 'ACTIVE_ACCOUNTS'), $this);?>
 </th>
      <td> <a href="manager_content.php?page=accounts_browse"><?php echo $this->_tpl_vars['active_accounts_count']; ?>
</a> </td>
      <td class="action_cell"> &raquo; <a href="manager_content.php?page=accounts_new_account"><?php echo smarty_echo(array('phrase' => 'CREATE_NEW_ACCOUNT'), $this);?>
</a> </td>
    </tr>
    <tr>
      <th> <?php echo smarty_echo(array('phrase' => 'INACTIVE_ACCOUNTS'), $this);?>
 </th>
      <td> <a href="manager_content.php?page=accounts_browse_inactive"><?php echo $this->_tpl_vars['inactive_accounts_count']; ?>
</a> </td>
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
      <th> <?php echo smarty_echo(array('phrase' => 'PENDING_ACCOUNTS'), $this);?>
 </th>
      <td> <a href="manager_content.php?page=accounts_browse_pending"><?php echo $this->_tpl_vars['pending_accounts_count']; ?>
</a> </td>
      <td class="action_cell"/>
    </tr>
  </table>
</div>