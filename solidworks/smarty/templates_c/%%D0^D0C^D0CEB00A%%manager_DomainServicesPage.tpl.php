<?php /* Smarty version 2.6.14, created on 2012-03-10 19:07:10
         compiled from manager_DomainServicesPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_DomainServicesPage.tpl', 3, false),array('function', 'form_element', 'manager_DomainServicesPage.tpl', 5, false),array('function', 'form_description', 'manager_DomainServicesPage.tpl', 16, false),array('function', 'form_table_checkbox', 'manager_DomainServicesPage.tpl', 32, false),array('block', 'form', 'manager_DomainServicesPage.tpl', 4, false),array('block', 'form_table', 'manager_DomainServicesPage.tpl', 29, false),array('block', 'form_table_column', 'manager_DomainServicesPage.tpl', 31, false),array('block', 'form_table_footer', 'manager_DomainServicesPage.tpl', 51, false),)), $this); ?>
<div class="manager_content"</div>
<div class="action">
  <p class="header"><?php echo smarty_echo(array('phrase' => 'ACTIONS'), $this);?>
</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'domain_services_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('phrase' => 'DOMAIN_SERVICES'), $this);?>
 </h2>
<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_domain_services')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SEARCH'), $this);?>
 </th>
        <td>
          <?php echo smarty_form_description(array('field' => 'tld'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'tld','size' => '6'), $this);?>

        </td>
        <td class="submit"> 
          <?php echo smarty_form_element(array('field' => 'search'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="table">
  <?php $this->_tag_stack[] = array('form', array('name' => 'domain_services')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('form_table', array('field' => 'services','size' => '10','style' => "width: 67%")); $_block_repeat=true;smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'tld','header' => "")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <center> <?php echo smarty_form_table_checkbox(array('option' => $this->_tpl_vars['services']['tld']), $this);?>
 </center>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'tld','header' => "[TLD]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <a href="manager_content.php?page=services_edit_domain_service&dservice=<?php echo $this->_tpl_vars['services']['tld']; ?>
"> .<?php echo $this->_tpl_vars['services']['tld']; ?>
 </a>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'module','header' => "[MODULE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['services']['module']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'pricing','header' => "[PRICING]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['services']['pricing']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'public','header' => "[PUBLIC]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['services']['public']; ?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

      <?php $this->_tag_stack[] = array('form_table_footer', array()); $_block_repeat=true;smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_form_element(array('field' => 'remove'), $this);?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>