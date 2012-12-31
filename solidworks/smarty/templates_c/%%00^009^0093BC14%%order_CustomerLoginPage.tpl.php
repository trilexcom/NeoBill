<?php /* Smarty version 2.6.14, created on 2012-03-10 20:35:01
         compiled from order_CustomerLoginPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'order_CustomerLoginPage.tpl', 1, false),array('function', 'echo', 'order_CustomerLoginPage.tpl', 5, false),array('function', 'form_description', 'order_CustomerLoginPage.tpl', 12, false),array('function', 'form_element', 'order_CustomerLoginPage.tpl', 13, false),)), $this); ?>
<?php $this->_tag_stack[] = array('form', array('name' => 'login')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td> <?php echo smarty_echo(array('phrase' => 'CUSTOMER_LOGIN'), $this);?>
 </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> <?php echo smarty_form_description(array('field' => 'user'), $this);?>
 </th>
                <td> <?php echo smarty_form_element(array('field' => 'user'), $this);?>
 </td>
              </tr>
              <tr>
                <th> <?php echo smarty_form_description(array('field' => 'password'), $this);?>
 </th>
                <td> <?php echo smarty_form_element(array('field' => 'password'), $this);?>
 </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="right">
          <?php echo smarty_form_element(array('field' => 'back'), $this);?>

          <?php echo smarty_form_element(array('field' => 'login'), $this);?>

        </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>