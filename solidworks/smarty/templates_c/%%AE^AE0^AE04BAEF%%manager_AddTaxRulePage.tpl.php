<?php /* Smarty version 2.6.14, created on 2007-08-21 13:09:03
         compiled from manager_AddTaxRulePage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_AddTaxRulePage.tpl', 1, false),array('function', 'form_description', 'manager_AddTaxRulePage.tpl', 7, false),array('function', 'form_element', 'manager_AddTaxRulePage.tpl', 8, false),array('block', 'form', 'manager_AddTaxRulePage.tpl', 3, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'NEW_TAX_RULE'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'new_tax_rule')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'rate'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'rate','size' => '4'), $this);?>
 % </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'country'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'country'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'allstates'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'allstates'), $this);?>
 </td>
        </td>
      </tr>
      <tr>
        <th> &nbsp;<?php echo smarty_form_description(array('field' => 'state'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'state','size' => '20'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'description'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'description','size' => '40'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>
 
          <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

        </th>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>