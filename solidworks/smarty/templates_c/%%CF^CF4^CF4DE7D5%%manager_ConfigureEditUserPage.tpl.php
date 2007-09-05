<?php /* Smarty version 2.6.14, created on 2007-08-21 12:55:14
         compiled from manager_ConfigureEditUserPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_ConfigureEditUserPage.tpl', 3, false),array('function', 'form_element', 'manager_ConfigureEditUserPage.tpl', 4, false),array('function', 'echo', 'manager_ConfigureEditUserPage.tpl', 10, false),array('function', 'dbo_echo', 'manager_ConfigureEditUserPage.tpl', 10, false),array('function', 'form_description', 'manager_ConfigureEditUserPage.tpl', 14, false),)), $this); ?>
<div class="action">
  <p class="header">Actions</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'edit_user_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'delete'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<?php $this->_tag_stack[] = array('form', array('name' => 'edit_user')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

  <h2><?php echo smarty_echo(array('phrase' => 'EDIT_USER'), $this);?>
: <?php echo smarty_dbo_echo(array('dbo' => 'edit_user_dbo','field' => 'username'), $this);?>
</h2>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'type'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'type'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'firstname'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'firstname','size' => '30'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'lastname'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'lastname','size' => '30'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'email'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'email','size' => '30'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'language'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'language'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th> 
          <input type="submit" value="Update User"/> 
        </th>
	<td/>
      </tr>
    </table>
  </div>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('form', array('name' => 'edit_user_pass')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

  <h2> <?php echo smarty_echo(array('phrase' => 'RESET_PASSWORD'), $this);?>
 </h2>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'password'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'password','size' => '20'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'repassword'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'repassword','size' => '20'), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <th> <input type="submit" value="Reset Password"/> </th>
	<td/>
      </tr>
    </table>
  </div>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>