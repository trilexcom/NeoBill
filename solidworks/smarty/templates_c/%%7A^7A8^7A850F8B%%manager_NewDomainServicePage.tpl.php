<?php /* Smarty version 2.6.14, created on 2007-08-27 11:44:24
         compiled from manager_NewDomainServicePage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_NewDomainServicePage.tpl', 1, false),array('function', 'form_description', 'manager_NewDomainServicePage.tpl', 7, false),array('function', 'form_element', 'manager_NewDomainServicePage.tpl', 8, false),array('block', 'form', 'manager_NewDomainServicePage.tpl', 3, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'NEW_DOMAIN_SERVICE'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'new_domain_service')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'tld'), $this);?>
 </th>
        <td> .&nbsp;<?php echo smarty_form_element(array('field' => 'tld','size' => '8'), $this);?>
 (com, net, org, ...) </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'modulename'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'modulename'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'description'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'description','cols' => '40','rows' => '3'), $this);?>
 </td>
      </tr>
      <tr> 
        <th> <?php echo smarty_echo(array('phrase' => 'PERIOD'), $this);?>
 </th>
        <th> <?php echo smarty_echo(array('phrase' => 'RECURRING_PRICE'), $this);?>
 </th>
      </tr>
      <tr>
        <th> 1 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price1yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 2 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price2yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 3 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price3yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 4 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price4yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 5 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price5yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 6 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price6yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 7 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price7yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 8 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price8yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 9 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price9yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> 10 <?php echo smarty_echo(array('phrase' => 'YEAR'), $this);?>
: <b>*</b> </th>
        <td> <?php echo smarty_form_element(array('field' => 'price10yr','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'taxable'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'taxable'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

          <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

        </th>
	<td/>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>