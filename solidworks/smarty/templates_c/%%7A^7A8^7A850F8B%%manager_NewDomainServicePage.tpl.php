<?php /* Smarty version 2.6.14, created on 2012-03-10 19:07:27
         compiled from manager_NewDomainServicePage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_NewDomainServicePage.tpl', 2, false),array('function', 'form_element', 'manager_NewDomainServicePage.tpl', 13, false),array('function', 'form_description', 'manager_NewDomainServicePage.tpl', 22, false),)), $this); ?>
<div class="manager_content"</div>
<?php $this->_tag_stack[] = array('form', array('name' => 'new_domain_service')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [NEW_DOMAIN_SERVICE] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left">
            <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

          </td>
          <td class="right">
            <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

          </td>
        </tr>
      </tfoot>
      <tbody>
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
          <th> <?php echo smarty_form_description(array('field' => 'public'), $this);?>
 </th>
          <td> <?php echo smarty_form_element(array('field' => 'public','option' => 'Yes'), $this);?>
 </td>
        </tr>
      </tbody>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>