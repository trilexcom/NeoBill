<?php /* Smarty version 2.6.14, created on 2007-08-27 11:46:19
         compiled from manager_NewAccountPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_NewAccountPage.tpl', 1, false),array('function', 'echo', 'manager_NewAccountPage.tpl', 4, false),array('function', 'form_description', 'manager_NewAccountPage.tpl', 7, false),array('function', 'form_element', 'manager_NewAccountPage.tpl', 8, false),)), $this); ?>
<?php $this->_tag_stack[] = array('form', array('name' => 'new_account')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
<div class="form">

  <h2> <?php echo smarty_echo(array('phrase' => 'ACCOUNT_INFORMATION'), $this);?>
 </h2>
  <table style="width: 70%">
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'type'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'type','option' => 'Business Account'), $this);?>
 </td>
    </tr>
    <tr>
      <th/>
      <td> 
        &nbsp; &nbsp; &nbsp; <?php echo smarty_form_description(array('field' => 'businessname'), $this);?>
 <br/>
        &nbsp; &nbsp; &nbsp; <?php echo smarty_form_element(array('field' => 'businessname','size' => '30'), $this);?>

      </td>
    </tr>
    <tr>
      <th/>
      <td> <?php echo smarty_form_element(array('field' => 'type','option' => 'Individual Account'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'status'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'status'), $this);?>
 </td>
    </tr>
  </table>

  <h2> <?php echo smarty_echo(array('phrase' => 'BILLING_INFORMATION'), $this);?>
 </h2>
  <table style="width: 70%">
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'billingstatus'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'billingstatus'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'billingday'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'billingday','size' => '2'), $this);?>
 </td>
    </tr>
  </table>

  <h2> <?php echo smarty_echo(array('phrase' => 'CONTACT_INFORMATION'), $this);?>
 </h2>
  <table style="width: 70%">
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'contactname'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'contactname','size' => '30'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'contactemail'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'contactemail','size' => '30'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'address1'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'address1','size' => '40'), $this);?>
 </th>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'address2'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'address2','size' => '40'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'city'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'city','size' => '30'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'state'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'state','size' => '20'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'country'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'country','size' => '20'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'postalcode'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'postalcode','size' => '10'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'phone'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'phone','size' => '15'), $this);?>
 </th>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'mobilephone'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'mobilephone','size' => '15'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_form_description(array('field' => 'fax'), $this);?>
 </th>
      <td> <?php echo smarty_form_element(array('field' => 'fax','size' => '15'), $this);?>
 </td>
    </tr>
    <tr class="footer">
      <th colspan="2">
        <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

        <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

      </th>
    </tr>
  </table>
</div class="form">
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>