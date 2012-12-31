<?php /* Smarty version 2.6.14, created on 2012-03-10 19:05:38
         compiled from manager_EditHostingServicePage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_EditHostingServicePage.tpl', 18, false),array('block', 'form_table', 'manager_EditHostingServicePage.tpl', 70, false),array('block', 'form_table_column', 'manager_EditHostingServicePage.tpl', 72, false),array('block', 'form_table_footer', 'manager_EditHostingServicePage.tpl', 96, false),array('function', 'dbo_echo', 'manager_EditHostingServicePage.tpl', 23, false),array('function', 'form_element', 'manager_EditHostingServicePage.tpl', 29, false),array('function', 'form_description', 'manager_EditHostingServicePage.tpl', 38, false),array('function', 'form_table_checkbox', 'manager_EditHostingServicePage.tpl', 73, false),array('modifier', 'currency', 'manager_EditHostingServicePage.tpl', 89, false),)), $this); ?>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXCommon.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar_start.js"></script>

<?php if ($this->_tpl_vars['tab'] != null): ?>
  <script type="text/javascript">
    var activeTab = "<?php echo $this->_tpl_vars['tab']; ?>
";
  </script>
<?php endif; ?>
<div class="manager_content"
<div id="a_tabbar" 
     class="dhtmlxTabBar" 
     style="margin-top: 0.5em;"  
     imgpath="../include/dhtmlxTabbar/imgs/"
     skinColors="#FFFFFF,#F4F3EE">

  <div id="general" name="[GENERAL]" width="80">
    <?php $this->_tag_stack[] = array('form', array('name' => 'edit_hosting')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [HOSTING_SERVICE] ([ID]: <?php echo smarty_dbo_echo(array('dbo' => 'hosting_dbo','field' => 'id'), $this);?>
) </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="left">
                <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

              </td>
              <td class="right"> 
                <?php echo smarty_form_element(array('field' => 'save'), $this);?>

              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'title'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'hosting_dbo','field' => 'title','size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'description'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'hosting_dbo','field' => 'description','cols' => '40','rows' => '3'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'uniqueip'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'hosting_dbo','field' => 'uniqueip'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'domainrequirement'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'hosting_dbo','field' => 'domainrequirement'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'public'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'hosting_dbo','field' => 'public','option' => 'Yes'), $this);?>
 </td>
            </tr>
            <tr>
              <th> [ADD_TO_CART_URL]: </th>
              <td> order/index.php?page=purchasehosting&service=<?php echo $this->_tpl_vars['serviceDBO']->getID(); ?>
 </td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  </div>

  <div id="pricing" name="[PRICING]" width="80">
    <?php $this->_tag_stack[] = array('form', array('name' => 'edit_hosting_pricing')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <div class="table">
        <?php $this->_tag_stack[] = array('form_table', array('field' => 'prices','style' => "width: 650px")); $_block_repeat=true;smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

          <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'id','header' => "")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <?php echo smarty_form_table_checkbox(array('option' => $this->_tpl_vars['prices']['id']), $this);?>

          <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

          <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'type','header' => "[TYPE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <?php echo $this->_tpl_vars['prices']['type']; ?>

          <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

          <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'termlength','header' => "[TERM_LENGTH]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <?php if ($this->_tpl_vars['prices']['type'] == 'Onetime'): ?>
              [N/A]
            <?php else: ?>
              <?php echo $this->_tpl_vars['prices']['termlength']; ?>
 [MONTHS]
            <?php endif; ?>
          <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

          <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'price','header' => "[PRICE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['prices']['price'])) ? $this->_run_mod_handler('currency', true, $_tmp) : smarty_modifier_currency($_tmp)); ?>

          <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

          <?php $this->_tag_stack[] = array('form_table_column', array('columnid' => 'taxable','header' => "[TAXABLE]")); $_block_repeat=true;smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <?php echo $this->_tpl_vars['prices']['taxable']; ?>

          <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

          <?php $this->_tag_stack[] = array('form_table_footer', array()); $_block_repeat=true;smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <?php echo smarty_form_element(array('field' => 'delete'), $this);?>

          <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table_footer($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('form', array('name' => 'edit_hosting_add_price')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <div class="form">
        <table style>
          <thead>
            <tr>
              <th colspan="4"> [ADD_OR_UPDATE_PRICE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="right" colspan="4"> <?php echo smarty_form_element(array('field' => 'add'), $this);?>
 </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th style="width: 25%"> <?php echo smarty_form_description(array('field' => 'type'), $this);?>
 </th>
              <th style="width: 25%"> <?php echo smarty_form_description(array('field' => 'termlength'), $this);?>
 </th>
              <th style="width: 25%"> <?php echo smarty_form_description(array('field' => 'price'), $this);?>
 </th>
              <th style="width: 25%"> <?php echo smarty_form_description(array('field' => 'taxable'), $this);?>
 </th>
            </tr>
            <tr>
              <td style="width: 25%"> <?php echo smarty_form_element(array('field' => 'type'), $this);?>
 </td>
              <td style="width: 25%"> <?php echo smarty_form_element(array('field' => 'termlength','size' => '4'), $this);?>
 </td>
              <td style="width: 25%"> <?php echo smarty_form_element(array('field' => 'price','size' => '6'), $this);?>
 </td>
              <td style="width: 25%"> <?php echo smarty_form_element(array('field' => 'taxable'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  </div>
</div>