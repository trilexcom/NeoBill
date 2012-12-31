<?php /* Smarty version 2.6.14, created on 2012-03-10 19:10:59
         compiled from order_CustomerPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'order_CustomerPage.tpl', 1, false),array('function', 'echo', 'order_CustomerPage.tpl', 8, false),array('function', 'form_description', 'order_CustomerPage.tpl', 14, false),array('function', 'form_element', 'order_CustomerPage.tpl', 15, false),)), $this); ?>
<?php $this->_tag_stack[] = array('form', array('name' => 'customer_information')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> E-Mail </th>
      </tr>
      <tr> <td> <?php echo smarty_echo(array('phrase' => 'EMAIL_TEXT'), $this);?>
 </td> </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'contactemail'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'contactemail','size' => '50'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'verifyemail'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('field' => 'verifyemail','size' => '50'), $this);?>
 </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> <?php echo smarty_echo(array('phrase' => 'CONTACT_INFORMATION'), $this);?>
 </th>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'businessname'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'businessname','size' => '50'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'contactname'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'contactname','size' => '50'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'address1'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'address1','size' => '50'), $this);?>
 </td>
              </tr>
              <tr>
                <td> </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'address2','size' => '50'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'city'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'city','size' => '30'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'state'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'state','size' => '30'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'postalcode'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'postalcode','size' => '10'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'country'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'country'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'phone'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'phone'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'mobilephone'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'mobilephone'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'fax'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'fax'), $this);?>
 </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <?php if ($this->_tpl_vars['orderHasDomains']): ?>
    <div class="domainoption">
      <table>
        <tr class="reverse">
          <th> <?php echo smarty_echo(array('phrase' => 'DOMAIN_CONTACT_INFORMATION'), $this);?>
 </th>
        </tr>
        <tr>
          <td>
            <?php echo smarty_echo(array('phrase' => 'DOMAIN_CONTACT_INFORMATION_TEXT'), $this);?>

          </td>
        </tr>
        <tr>
          <td>
            <?php echo smarty_form_element(array('field' => 'domaincontact','option' => 'same'), $this);?>
<br/>
            <?php echo smarty_form_element(array('field' => 'domaincontact','option' => 'new'), $this);?>

          </td>
        </tr>
      </table>
    </div>
  <?php else: ?>
    <input type="hidden" name="domaincontact" value="same"/>
  <?php endif; ?>
            
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th>Login</th> <!-- hardcoded in english -->
      </tr>
      <tr> <td> <?php echo smarty_echo(array('phrase' => 'LOGIN_TEXT'), $this);?>
 </td> </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'username'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('dbo' => 'order','field' => 'username'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'password'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('field' => 'password'), $this);?>
 </td>
              </tr>
              <tr>
                <td> <?php echo smarty_form_description(array('field' => 'repassword'), $this);?>
 </td>
                <td> <?php echo smarty_form_element(array('field' => 'repassword'), $this);?>
 </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> [ADDITIONAL_INFORMATION] </th>
      </tr>
      <tr>
        <td>
          <p> [FEEL_FREE_TO_USE_THIS_SPACE_TO_ASK_QUESTIONS_OR]: </p>
          <?php echo smarty_form_element(array('field' => 'note','rows' => '5','cols' => '60'), $this);?>

        </td>
      </tr>
    </table>
  </div>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left"> <?php echo smarty_form_element(array('field' => 'startover'), $this);?>
 </td>
        <td class="right">
          <?php echo smarty_form_element(array('field' => 'back'), $this);?>

          <?php echo smarty_form_element(array('field' => 'continue'), $this);?>

        </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>