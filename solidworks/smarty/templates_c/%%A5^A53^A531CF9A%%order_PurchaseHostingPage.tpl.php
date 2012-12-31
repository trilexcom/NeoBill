<?php /* Smarty version 2.6.14, created on 2012-03-10 19:09:52
         compiled from order_PurchaseHostingPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'order_PurchaseHostingPage.tpl', 3, false),array('function', 'form_description', 'order_PurchaseHostingPage.tpl', 15, false),array('function', 'form_element', 'order_PurchaseHostingPage.tpl', 16, false),)), $this); ?>
<script type="text/javascript" src="javascript/purchasehostingpage.js"></script>

<?php $this->_tag_stack[] = array('form', array('name' => 'purchasehosting')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div id="purchaseoption" class="domainoption">
    <table>
    </table>
  </div>

  <div name="hostingoption" class="domainoption">
    <table>
      <tr class="reverse">
        <th colspan="2"> [PLEASE_SELECT_A_HOSTING_OPTION]: </th>
      </tr>
      <tr>
        <td> <?php echo smarty_form_description(array('field' => 'hostingservice'), $this);?>
</td>
        <td> <?php echo smarty_form_element(array('field' => 'hostingservice','onchange' => "submit()",'value' => $this->_tpl_vars['service']), $this);?>
 </td>
      </tr>
      <tr>
        <td> <?php echo smarty_form_description(array('field' => 'hostingterm'), $this);?>
</td>
        <td> <?php echo smarty_form_element(array('field' => 'hostingterm'), $this);?>
 </td>
      </tr>
    </table>
  </div>
  
  <p/>

  <?php if ($this->_tpl_vars['serviceDBO']->isDomainRequired()): ?>
    <div name="domainoption" class="domainoption">
      <table name="domainoption">
        <tr class="reverse">
          <th colspan="2"> [PLEASE_SELECT_A_DOMAIN_OPTION]: </th>
        </tr>
        <tr>
          <td> <?php echo smarty_form_element(array('field' => 'domainoption','id' => 'New','option' => 'New','onchange' => "showDomainBox()"), $this);?>
 </td>
        </tr>
        <tr>
          <td> <?php echo smarty_form_element(array('field' => 'domainoption','id' => 'Transfer','option' => 'Transfer','onchange' => "showDomainBox()"), $this);?>
 </td>
        </tr>
        <tr>
          <td> <?php echo smarty_form_element(array('field' => 'domainoption','id' => 'InCart','option' => 'InCart','onchange' => "showDomainBox()"), $this);?>
 </td>
        </tr>
        <tr>
          <td> <?php echo smarty_form_element(array('field' => 'domainoption','id' => 'Existing','option' => 'Existing','onchange' => "showDomainBox()"), $this);?>
 </td>
        </tr>
        <tr>
          <td class="indent"> 
            <div id="newdomain" class="form">
              <table>
                <tr>
                  <th> [REGISTER_NEW_DOMAIN]: </th>
                  <td> <?php echo smarty_form_element(array('field' => 'registerdomainname','size' => '30','value' => $this->_tpl_vars['domain']), $this);?>
.<?php echo smarty_form_element(array('field' => 'registerdomaintld','onchange' => "submit()",'value' => $this->_tpl_vars['tld']), $this);?>
 </td>
                </tr>
                <tr>
                  <th> <?php echo smarty_form_description(array('field' => 'registerdomainterm'), $this);?>
 </th>
                  <td> <?php echo smarty_form_element(array('field' => 'registerdomainterm'), $this);?>
 </td>
                </tr>
              </table>
            </div>
            <div id="transferdomain" class="form">
              <table>
                <tr>
                  <th> [DOMAIN_TO_TRANSFER]: </th>
                  <td> <?php echo smarty_form_element(array('field' => 'transferdomainname','size' => '30'), $this);?>
.<?php echo smarty_form_element(array('field' => 'transferdomaintld','onchange' => "submit()"), $this);?>
 </td>
                </tr>
                <tr>
                  <th> <?php echo smarty_form_description(array('field' => 'transferdomainterm'), $this);?>
 </th>
                  <td> <?php echo smarty_form_element(array('field' => 'transferdomainterm'), $this);?>
 </td>
                </tr>
              </table>
            </div>
            <div id="incartdomain" class="form">
              <table>
                <tr>
                  <th> <?php echo smarty_form_description(array('field' => 'incartdomain'), $this);?>
 </th>
                  <td> <?php echo smarty_form_element(array('field' => 'incartdomain','empty' => "[THERE_ARE_NO_DOMAINS_IN_YOUR_CART]"), $this);?>
 </td>
                </tr>
              </table>
            </div>
            <div id="existingdomain" class="form">
              <table>
                <tr>
                  <th> [YOUR_EXISTING_DOMAIN]: </th>
                  <td> <?php echo smarty_form_element(array('field' => 'existingdomainname','size' => '40'), $this);?>
 </td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
  <?php endif; ?>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left">
          <?php if (! $this->_tpl_vars['orderDBO']->isEmpty()): ?>
            <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

          <?php endif; ?>
        </td>
        <td class="right">
          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

        </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<script type="text/javascript">
  showDomainBox();
</script>