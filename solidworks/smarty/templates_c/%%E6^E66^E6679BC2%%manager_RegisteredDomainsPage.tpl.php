<?php /* Smarty version 2.6.14, created on 2007-08-21 13:02:43
         compiled from manager_RegisteredDomainsPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_RegisteredDomainsPage.tpl', 1, false),array('function', 'form_description', 'manager_RegisteredDomainsPage.tpl', 9, false),array('function', 'form_element', 'manager_RegisteredDomainsPage.tpl', 10, false),array('function', 'dbo_echo', 'manager_RegisteredDomainsPage.tpl', 31, false),array('block', 'form', 'manager_RegisteredDomainsPage.tpl', 4, false),array('block', 'dbo_table', 'manager_RegisteredDomainsPage.tpl', 25, false),array('block', 'dbo_table_column', 'manager_RegisteredDomainsPage.tpl', 30, false),array('modifier', 'datetime', 'manager_RegisteredDomainsPage.tpl', 39, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'REGISTERED_DOMAINS'), $this);?>
 </h2>

<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_domaindbo_table')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SEARCH'), $this);?>
 </th>
        <td> 
          <?php echo smarty_form_description(array('field' => 'domainname'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'domainname'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'tld'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'tld'), $this);?>

        </td>
        <td class="submit">
          <?php echo smarty_form_element(array('field' => 'search'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'DomainServicePurchaseDBO','name' => 'domaindbo_table','title' => "[REGISTERED_DOMAINS]",'size' => '10')); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[DOMAIN_NAME]",'sort_field' => 'domainname')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="manager_content.php?page=domains_edit_domain&id=<?php echo smarty_dbo_echo(array('dbo' => 'domaindbo_table','field' => 'id'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'domaindbo_table','field' => 'fulldomainname'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ACCOUNT]",'sort_field' => 'accountname')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="manager_content.php?page=accounts_view_account&id=<?php echo smarty_dbo_echo(array('dbo' => 'domaindbo_table','field' => 'accountid'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'domaindbo_table','field' => 'accountname'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[REGISTRATION_DATE]",'sort_field' => 'date')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'domaindbo_table','field' => 'date'), $this))) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date'));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[TERM]",'sort_field' => 'term')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'domaindbo_table','field' => 'term'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[EXPIRATION_DATE]",'sort_field' => 'expiredate')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'domaindbo_table','field' => 'expiredate'), $this))) ? $this->_run_mod_handler('datetime', true, $_tmp, 'date') : smarty_modifier_datetime($_tmp, 'date'));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>