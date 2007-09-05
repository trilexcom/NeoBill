<?php /* Smarty version 2.6.14, created on 2007-08-27 11:49:31
         compiled from manager_ViewAccountPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'dbo_assign', 'manager_ViewAccountPage.tpl', 1, false),array('function', 'echo', 'manager_ViewAccountPage.tpl', 4, false),array('function', 'dbo_echo', 'manager_ViewAccountPage.tpl', 17, false),array('function', 'form_element', 'manager_ViewAccountPage.tpl', 84, false),array('function', 'form_description', 'manager_ViewAccountPage.tpl', 119, false),array('block', 'form', 'manager_ViewAccountPage.tpl', 11, false),array('block', 'dbo_table', 'manager_ViewAccountPage.tpl', 96, false),array('block', 'dbo_table_column', 'manager_ViewAccountPage.tpl', 101, false),array('modifier', 'country', 'manager_ViewAccountPage.tpl', 64, false),array('modifier', 'datetime', 'manager_ViewAccountPage.tpl', 104, false),)), $this); ?>
<?php echo smarty_dbo_assign(array('dbo' => 'account_dbo','var' => 'account_id','field' => 'id'), $this);?>


<ul id="tabnav">
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&id=<?php echo $this->_tpl_vars['account_id']; ?>
&action=account_info"> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_INFO'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&id=<?php echo $this->_tpl_vars['account_id']; ?>
&action=services"> <?php echo smarty_echo(array('phrase' => 'WEB_HOSTING_SERVICES'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&id=<?php echo $this->_tpl_vars['account_id']; ?>
&action=domains"> <?php echo smarty_echo(array('phrase' => 'DOMAINS'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&id=<?php echo $this->_tpl_vars['account_id']; ?>
&action=products"> <?php echo smarty_echo(array('phrase' => 'OTHER_PRODUCTS_SERVICES'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&id=<?php echo $this->_tpl_vars['account_id']; ?>
&action=billing"> <?php echo smarty_echo(array('phrase' => 'BILLING'), $this);?>
 </a> </li>
</ul>

<?php $this->_tag_stack[] = array('form', array('name' => 'view_account_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <h2> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_INFORMATION'), $this);?>
 </h2>
  <div class="properties">
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_ID'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'id'), $this);?>
 </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=accounts_welcome&id=<?php echo $this->_tpl_vars['account_id']; ?>
"><?php echo smarty_echo(array('phrase' => 'SEND_WELCOME_EMAIL'), $this);?>
</a> </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_NAME'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'accountname'), $this);?>
 </td>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_TYPE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'type'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_STATUS'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'status'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'BILLING_STATUS'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'billingstatus'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'BILLING_DAY'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'billingday'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'CONTACT_NAME'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'contactname'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'CONTACT_EMAIL'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'contactemail'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ADDRESS'), $this);?>
: </th>
        <td>
          <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'address1'), $this);?>
 <br/>
          <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'address2'), $this);?>
 <br/>
        </td>
      </tr>
      <tr> 
        <th> <?php echo smarty_echo(array('phrase' => 'CITY'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'city'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'STATE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'state'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'COUNTRY'), $this);?>
: </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'country'), $this))) ? $this->_run_mod_handler('country', true, $_tmp) : smarty_modifier_country($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ZIP_CODE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'postalcode'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'PHONE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'phone'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'MOBILE_PHONE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'mobilephone'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'FAX'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'account_dbo','field' => 'fax'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th class="footer"> 
          <?php echo smarty_form_element(array('field' => 'edit'), $this);?>

          <?php echo smarty_form_element(array('field' => 'delete'), $this);?>

        </th>
        <td/>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('form', array('name' => 'view_account_note')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <h2> <?php echo smarty_echo(array('phrase' => 'NOTES'), $this);?>
 </h2>
  <div class="table">
    <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'NoteDBO','filter' => "accountid=".($this->_tpl_vars['account_id']),'name' => 'notedbo_table','title' => "[NOTES]")); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      
      <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[POSTED]",'sort_field' => 'updated','style' => "width: 200px")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_echo(array('phrase' => 'BY'), $this);?>
: <?php echo smarty_dbo_echo(array('dbo' => 'notedbo_table','field' => 'username'), $this);?>
 
        <br/>
        <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'notedbo_table','field' => 'updated'), $this))) ? $this->_run_mod_handler('datetime', true, $_tmp) : smarty_modifier_datetime($_tmp));?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[NOTE]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_dbo_echo(array('dbo' => 'notedbo_table','field' => 'text'), $this);?>

        [<a target="content" href="manager_content.php?page=accounts_view_account&action=delete_note&note_id=<?php echo smarty_dbo_echo(array('dbo' => 'notedbo_table','field' => 'id'), $this);?>
">delete</a>]
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  </div>  

    <div class="form">
    <table style="width: 500px">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'text'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'text','cols' => '45','rows' => '5'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th colspan="2"> <?php echo smarty_form_element(array('field' => 'add'), $this);?>
 </th>
      </tr>
    </table>         
    </div>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>