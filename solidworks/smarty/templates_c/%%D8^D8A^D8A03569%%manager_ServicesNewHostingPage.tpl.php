<?php /* Smarty version 2.6.14, created on 2007-09-01 15:03:20
         compiled from manager_ServicesNewHostingPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_ServicesNewHostingPage.tpl', 1, false),array('function', 'form_description', 'manager_ServicesNewHostingPage.tpl', 6, false),array('function', 'form_element', 'manager_ServicesNewHostingPage.tpl', 7, false),array('block', 'form', 'manager_ServicesNewHostingPage.tpl', 2, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'NEW_HOSTING_SERVICE'), $this);?>
 </h2>
<?php $this->_tag_stack[] = array('form', array('name' => 'new_hosting')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'title'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'title','size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'description'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'description','cols' => '40','rows' => '3'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'uniqueip'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'uniqueip'), $this);?>
 </td>
      </tr>
      <tr>
        <th><?php echo smarty_form_description(array('field' => 'allow1'), $this);?>
</th>
        <td>
          <table class="inner">
            <tr>
              <td><?php echo smarty_form_element(array('field' => 'allow1'), $this);?>
  1 <?php echo smarty_echo(array('phrase' => 'MONTH'), $this);?>
 </td>
              <td><?php echo smarty_form_element(array('field' => 'allow3'), $this);?>
  3 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
 </td>
              <td><?php echo smarty_form_element(array('field' => 'allow6'), $this);?>
  6 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
 </td>
              <td><?php echo smarty_form_element(array('field' => 'allow12'), $this);?>
  12 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
 </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SETUP_PRICE'), $this);?>
: <b>*</b></th>
        <td>
          <table class="inner">
            <tr>
              <td> <?php echo smarty_form_element(array('field' => 'setupprice1mo','size' => '7'), $this);?>
 </td>
              <td> <?php echo smarty_form_element(array('field' => 'setupprice3mo','size' => '7'), $this);?>
 </td>
              <td> <?php echo smarty_form_element(array('field' => 'setupprice6mo','size' => '7'), $this);?>
 </td>
              <td> <?php echo smarty_form_element(array('field' => 'setupprice12mo','size' => '7'), $this);?>
 </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'RECURRING_PRICE'), $this);?>
: <b>*</b></th>
        <td> 
          <table class="inner">
            <tr>
              <td> <?php echo smarty_form_element(array('field' => 'price1mo','size' => '7'), $this);?>
 </td>
              <td> <?php echo smarty_form_element(array('field' => 'price3mo','size' => '7'), $this);?>
 </td>
              <td> <?php echo smarty_form_element(array('field' => 'price6mo','size' => '7'), $this);?>
 </td>
              <td> <?php echo smarty_form_element(array('field' => 'price12mo','size' => '7'), $this);?>
 </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'taxable'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'taxable'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

          <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

        </td>
	<td/>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>