<?php /* Smarty version 2.6.14, created on 2007-08-27 11:44:37
         compiled from manager_NewProductPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_NewProductPage.tpl', 1, false),array('function', 'form_description', 'manager_NewProductPage.tpl', 7, false),array('function', 'form_element', 'manager_NewProductPage.tpl', 8, false),array('block', 'form', 'manager_NewProductPage.tpl', 3, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'NEW_PRODUCT'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'new_product')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'name'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'name','size' => '20'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'description'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'description','cols' => '40','rows' => '3'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'price'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'price','size' => '7'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'taxable'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('dbo' => 'product_dbo','field' => 'taxable'), $this);?>
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