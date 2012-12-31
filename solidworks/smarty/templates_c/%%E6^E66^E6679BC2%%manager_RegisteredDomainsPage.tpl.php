<?php /* Smarty version 2.6.14, created on 2012-03-20 18:08:22
         compiled from manager_RegisteredDomainsPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_RegisteredDomainsPage.tpl', 2, false),array('function', 'form_description', 'manager_RegisteredDomainsPage.tpl', 10, false),array('function', 'form_element', 'manager_RegisteredDomainsPage.tpl', 11, false),array('function', 'form_table_checkbox', 'manager_RegisteredDomainsPage.tpl', 34, false),array('block', 'form', 'manager_RegisteredDomainsPage.tpl', 5, false),array('block', 'form_table', 'manager_RegisteredDomainsPage.tpl', 31, false),array('block', 'form_table_column', 'manager_RegisteredDomainsPage.tpl', 33, false),array('block', 'form_table_footer', 'manager_RegisteredDomainsPage.tpl', 57, false),array('modifier', 'datetime', 'manager_RegisteredDomainsPage.tpl', 46, false),)), $this); ?>
<div class="manager_content"</div>
<h2> <?php echo smarty_echo(array('phrase' => 'REGISTERED_DOMAINS'), $this);?>
 </h2>

<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_domains')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SEARCH'), $this);?>
 </th>
        <td> 
          <?php echo smarty_form_description(array('field' => 'fulldomainname'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'fulldomainname','size' => '30'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'tld'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'tld','size' => '6'), $this);?>

        </td>
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
  <?php $this->_tag_stack[] = array('form', array('name' => 'registered_domains')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('form_table', array('field' => 'domains','empty' => "[THERE_ARE_NO_REGISTERED_DOMAINS]")); $_block_repeat=true;smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'id','header' => "")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <center> <?php echo smarty_form_table_checkbox(array('option' => $this->_tpl_vars['domains']['id']), $this);?>
 </center>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'fulldomainname','header' => "[DOMAIN_NAME]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <a href="manager_content.php?page=domains_edit_domain&dpurchase=<?php echo $this->_tpl_vars['domains']['id']; ?>
"><?php echo $this->_tpl_vars['domains']['fulldomainname']; ?>
</a>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'accountname','header' => "[ACCOUNT]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <a href="manager_content.php?page=accounts_view_account&account=<?php echo $this->_tpl_vars['domains']['accountid']; ?>
"><?php echo $this->_tpl_vars['domains']['accountname']; ?>
</a>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'date','header' => "[REGISTRATION_DATE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['domains']['date'])) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date')); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'term','header' => "[TERM]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['domains']['term']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'expiredate','header' => "[EXPIRATION_DATE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['domains']['expiredate'])) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date')); ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_footer', array()); $_block_repeat=true;smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_form_element(array('field' => 'remove'), $this);?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>
</div>