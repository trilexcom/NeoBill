<?php /* Smarty version 2.6.14, created on 2007-08-21 15:42:44
         compiled from manager_ServicesHostingServicesPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_ServicesHostingServicesPage.tpl', 2, false),array('function', 'form_element', 'manager_ServicesHostingServicesPage.tpl', 4, false),array('function', 'form_description', 'manager_ServicesHostingServicesPage.tpl', 15, false),array('function', 'dbo_echo', 'manager_ServicesHostingServicesPage.tpl', 40, false),array('block', 'form', 'manager_ServicesHostingServicesPage.tpl', 3, false),array('block', 'dbo_table', 'manager_ServicesHostingServicesPage.tpl', 35, false),array('block', 'dbo_table_column', 'manager_ServicesHostingServicesPage.tpl', 39, false),array('modifier', 'truncate', 'manager_ServicesHostingServicesPage.tpl', 48, false),array('modifier', 'currency', 'manager_ServicesHostingServicesPage.tpl', 56, false),)), $this); ?>
<div class="action">
  <p class="header"><?php echo smarty_echo(array('phrase' => 'ACTIONS'), $this);?>
</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'web_hosting_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('phrase' => 'WEB_HOSTING_SERVICES'), $this);?>
 </h2>
<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_servicedbo_table')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SEARCH'), $this);?>
 </th>
        <td>
          <?php echo smarty_form_description(array('field' => 'id'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'id','size' => '4'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'title'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'title','size' => '30'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'description'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'description','size' => '30'), $this);?>

        </td>
        <td class="submit"> 
          <?php echo smarty_form_element(array('field' => 'search'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'HostingServiceDBO','name' => 'servicedbo_table','title' => "[WEB_HOSTING_SERVICES]")); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    
    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[ID]",'sort_field' => 'id')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a target="content" href="manager_content.php?page=services_view_hosting_service&id=<?php echo smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'id'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'id'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[TITLE]",'sort_field' => 'title')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a target="content" href="manager_content.php?page=services_view_hosting_service&id=<?php echo smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'id'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'title'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[DESCRIPTION]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'description'), $this))) ? $this->_run_mod_handler('truncate', true, $_tmp, 40, "...") : smarty_modifier_truncate($_tmp, 40, "..."));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[UNIQUE_IP_ADDRESS]")); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'uniqueip'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[SETUP_PRICE]",'sort_field' => 'setupprice1mo')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'setupprice1mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (1 <?php echo smarty_echo(array('phrase' => 'MONTH'), $this);?>
)<br/>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'setupprice3mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (3 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
)<br/>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'setupprice6mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (6 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
)<br/>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'setupprice12mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (12 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
)
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[RECURRING_PRICE]",'sort_field' => 'price1mo')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'price1mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (1 <?php echo smarty_echo(array('phrase' => 'MONTH'), $this);?>
)<br/>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'price3mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (3 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
)<br/>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'price6mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (6 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
)<br/>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'price12mo'), $this))) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp));?>
 (12 <?php echo smarty_echo(array('phrase' => 'MONTHS'), $this);?>
)
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[TAXABLE]",'sort_field' => 'taxable')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'servicedbo_table','field' => 'taxable'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>