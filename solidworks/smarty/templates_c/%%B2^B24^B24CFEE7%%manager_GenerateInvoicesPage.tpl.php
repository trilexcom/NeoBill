<?php /* Smarty version 2.6.14, created on 2007-08-24 11:58:39
         compiled from manager_GenerateInvoicesPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_GenerateInvoicesPage.tpl', 1, false),array('function', 'form_description', 'manager_GenerateInvoicesPage.tpl', 7, false),array('function', 'form_element', 'manager_GenerateInvoicesPage.tpl', 8, false),array('block', 'form', 'manager_GenerateInvoicesPage.tpl', 3, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'GENERATE_INVOICE_BATCH'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'generate_invoices')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'date'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'date'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'periodbegin'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'periodbegin'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'terms'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'terms','size' => '2'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'note'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'note'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>
 
        </th>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>