<?php /* Smarty version 2.6.14, created on 2007-08-27 11:49:27
         compiled from manager_NewAccountPage_confirm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_NewAccountPage_confirm.tpl', 2, false),array('function', 'dbo_echo', 'manager_NewAccountPage_confirm.tpl', 10, false),array('function', 'form_element', 'manager_NewAccountPage_confirm.tpl', 72, false),array('block', 'form', 'manager_NewAccountPage_confirm.tpl', 4, false),array('modifier', 'country', 'manager_NewAccountPage_confirm.tpl', 52, false),)), $this); ?>
<p class="message"> 
  <?php echo smarty_echo(array('phrase' => 'ACCOUNT_CONFIRM'), $this);?>

</p>
<?php $this->_tag_stack[] = array('form', array('name' => 'new_account_confirm')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <h2> <?php echo smarty_echo(array('phrase' => 'CREATE_ACCOUNT'), $this);?>
 </h2>
  <div class="properties">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_NAME'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'accountname'), $this);?>
 </td>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_TYPE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'type'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_STATUS'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'status'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'BILLING_STATUS'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'billingstatus'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'BILLING_DAY'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'billingday'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'CONTACT_NAME'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'contactname'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'CONTACT_EMAIL'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'contactemail'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ADDRESS'), $this);?>
: </th>
        <td>
          <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'address1'), $this);?>
 <br/>
          <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'address2'), $this);?>
 <br/>
        </td>
      </tr>
      <tr> 
        <th> <?php echo smarty_echo(array('phrase' => 'CITY'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'city'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'STATE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'state'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'COUNTRY'), $this);?>
: </th>
        <td> <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'country'), $this))) ? $this->_run_mod_handler('country', true, $_tmp) : smarty_modifier_country($_tmp));?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'ZIP_CODE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'postalcode'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'PHONE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'phone'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'MOBILE_PHONE'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'mobilephone'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'FAX'), $this);?>
: </th>
        <td> <?php echo smarty_dbo_echo(array('dbo' => 'new_account_dbo','field' => 'fax'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th class="footer"> 
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

          <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

        </th>
        <td/>
      </tr>
    </table>
  </div
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>