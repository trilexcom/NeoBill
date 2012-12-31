<?php /* Smarty version 2.6.14, created on 2012-03-20 18:10:18
         compiled from manager_Settings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_Settings.tpl', 17, false),array('function', 'form_description', 'manager_Settings.tpl', 27, false),array('function', 'form_element', 'manager_Settings.tpl', 28, false),)), $this); ?>
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
    <?php $this->_tag_stack[] = array('form', array('name' => 'settings_general')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [COMPANY] </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'name'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'name','value' => ($this->_tpl_vars['company_name']),'size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'email'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'email','value' => ($this->_tpl_vars['company_email']),'size' => '30'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'notification_email'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'notification_email','value' => ($this->_tpl_vars['company_notification_email']),'size' => '30'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [WELCOME_EMAIL] </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'welcome_subject'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'welcome_subject','value' => ($this->_tpl_vars['welcome_subject']),'size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
             <th colspan="2"> <?php echo smarty_form_description(array('field' => 'welcome_email'), $this);?>
 </th>
            </tr>
            <tr>
              <td colspan="2"> <?php echo smarty_form_element(array('field' => 'welcome_email','value' => ($this->_tpl_vars['welcome_email']),'cols' => '70','rows' => '10'), $this);?>
 </td>
            </tr>
         </tbody>
       </table>
      </div>

      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [ORDER_CONFIRMATION_EMAIL] </th>
            </tr>
          </thead>
          <tbody>
            <tr>
             <th> <?php echo smarty_form_description(array('field' => 'confirm_subject'), $this);?>
 </th>
             <td> <?php echo smarty_form_element(array('field' => 'confirm_subject','value' => ($this->_tpl_vars['confirmation_subject']),'size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
              <th colspan="2"> <?php echo smarty_form_description(array('field' => 'confirm_email'), $this);?>
 </th>
            </tr>
            <tr>
              <td colspan="2"> <?php echo smarty_form_element(array('field' => 'confirm_email','value' => ($this->_tpl_vars['confirmation_email']),'cols' => '70','rows' => '10'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [ORDER_NOTIFICATION_EMAIL] </th>
            </tr>
          </thead>
          <tfoot>
            <tr> 
              <td class="left"/>
              <td class="right"> <?php echo smarty_form_element(array('field' => 'save'), $this);?>
 </th> 
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'notify_subject'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'notify_subject','value' => ($this->_tpl_vars['notification_subject']),'size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
              <th colspan="2"> <?php echo smarty_form_description(array('field' => 'notify_email'), $this);?>
 </th>
            </tr>
            <tr>
              <td colspan="2"> <?php echo smarty_form_element(array('field' => 'notify_email','value' => ($this->_tpl_vars['notification_email']),'cols' => '70','rows' => '10'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  </div>  

  <div id="themes" name="[THEMES]" width="80">
    <div class="form">
      <?php $this->_tag_stack[] = array('form', array('name' => 'settings_themes')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <table>
          <thead>
            <tr>
              <th colspan="2"> [THEMES] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                <?php echo smarty_form_element(array('field' => 'save'), $this);?>

              </td>
          </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'managertheme'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'managertheme','value' => ($this->_tpl_vars['managerTheme'])), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'ordertheme'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'ordertheme','value' => ($this->_tpl_vars['orderTheme'])), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>
  </div>

  <div id="billing" name="[BILLING]" width="80">
    <div class="form">
      <?php $this->_tag_stack[] = array('form', array('name' => 'settings_invoice')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <table>
          <thead>
            <tr>
              <th colspan="2"> [INVOICE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="right">
                <?php echo smarty_form_element(array('field' => 'save'), $this);?>

              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th colspan="2"> <?php echo smarty_form_description(array('field' => 'subject'), $this);?>
 </th>
            </tr>
            <tr>
              <td colspan="2"> <?php echo smarty_form_element(array('field' => 'subject','value' => ($this->_tpl_vars['invoice_subject']),'size' => '80'), $this);?>
 </td>
            </tr>
            <tr>
              <th colspan="2"> <?php echo smarty_form_description(array('field' => 'text'), $this);?>
 </th>
            </tr>
            <tr>
              <td colspan="2"> <?php echo smarty_form_element(array('field' => 'text','value' => ($this->_tpl_vars['invoice_text']),'cols' => '70','rows' => '20'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>
  </div> 

  <div id="dns" name="[DNS]" width="80">
    <div class="form">
      <?php $this->_tag_stack[] = array('form', array('name' => 'settings_nameservers')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <table>
          <thead>
            <tr>
              <th colspan="2"> [NAME_SERVERS] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                <?php echo smarty_form_element(array('field' => 'save'), $this);?>

              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'nameservers_ns1'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'nameservers_ns1','value' => ($this->_tpl_vars['nameservers_ns1']),'size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'nameservers_ns2'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'nameservers_ns2','value' => ($this->_tpl_vars['nameservers_ns2']),'size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'nameservers_ns3'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'nameservers_ns3','value' => ($this->_tpl_vars['nameservers_ns3']),'size' => '40'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'nameservers_ns4'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'nameservers_ns4','value' => ($this->_tpl_vars['nameservers_ns4']),'size' => '40'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>
  </div> 

  <div id="locale" name="[LOCALE]" width="80">
    <div class="form">
      <?php $this->_tag_stack[] = array('form', array('name' => 'settings_locale')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <table>
          <thead>
            <tr>
              <th colspan="2"> [LOCALE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                <?php echo smarty_form_element(array('field' => 'save'), $this);?>

              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'language'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'language'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'currency'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'currency','value' => ($this->_tpl_vars['currency']),'size' => '5'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>
  </div> 

  <div id="payment_gateway" name="[PAYMENT_GATEWAY]" width="120">
    <div class="form">
      <?php $this->_tag_stack[] = array('form', array('name' => 'settings_payment_gateway')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <table>
          <thead>
            <tr>
              <th colspan="2"> [PAYMENT_GATEWAY] </th>
            </tr>
          </thead>
          <tfoot>
            <?php if ($this->_tpl_vars['gatewaysAreEnabled']): ?>
              <tr>
                <td/>
                <td class="right">
                 <?php echo smarty_form_element(array('field' => 'save'), $this);?>

                </td>
              </tr>
            <?php endif; ?>
          </tfoot>
          <tbody>
            <?php if ($this->_tpl_vars['gatewaysAreEnabled']): ?>
              <tr>
                <th> <?php echo smarty_form_description(array('field' => 'default_module'), $this);?>
 </th>
                <td> <?php echo smarty_form_element(array('field' => 'default_module'), $this);?>
 </td>
              </tr>
              <tr>
                <th> <?php echo smarty_form_description(array('field' => 'order_method'), $this);?>
 </th>
                <td> <?php echo smarty_form_element(array('field' => 'order_method'), $this);?>
 </td>
              </tr>
            <?php else: ?>
              <tr>
                <th colspan="2"> [THERE_ARE_NO_GATEWAY_MODULES] </th>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>
  </div>

  <div id="order_interface" name="[ORDER_INTERFACE]" width="120">
    <div class="form">
      <?php $this->_tag_stack[] = array('form', array('name' => 'settings_order_interface')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <table>
          <thead>
            <tr>
              <th colspan="2"> [ORDER_INTERFACE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                <?php echo smarty_form_element(array('field' => 'save'), $this);?>

              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'title'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'title','size' => '40','value' => $this->_tpl_vars['order_title']), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'accept_checks'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'accept_checks','option' => 'true','value' => $this->_tpl_vars['order_accept_checks']), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'tos_url'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'tos_url','value' => $this->_tpl_vars['order_tos_url'],'size' => '50'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'tos_required'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('field' => 'tos_required','option' => 'true','value' => $this->_tpl_vars['order_tos_required']), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>
  </div>
</div>
</div>