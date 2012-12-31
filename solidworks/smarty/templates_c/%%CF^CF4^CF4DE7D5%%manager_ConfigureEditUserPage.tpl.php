<?php /* Smarty version 2.6.14, created on 2012-03-20 18:09:44
         compiled from manager_ConfigureEditUserPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_ConfigureEditUserPage.tpl', 20, false),array('function', 'form_element', 'manager_ConfigureEditUserPage.tpl', 21, false),array('function', 'dbo_echo', 'manager_ConfigureEditUserPage.tpl', 30, false),array('function', 'form_description', 'manager_ConfigureEditUserPage.tpl', 43, false),)), $this); ?>
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

  <div id="info" name="[USER_INFO]" width="80">
    <div class="action">
      <p class="header">Actions</p>
      <?php $this->_tag_stack[] = array('form', array('name' => 'edit_user_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo smarty_form_element(array('field' => 'delete'), $this);?>

      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    </div>

    <?php $this->_tag_stack[] = array('form', array('name' => 'edit_user')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [EDIT_USER]: <?php echo smarty_dbo_echo(array('dbo' => 'edit_user_dbo','field' => 'username'), $this);?>
 </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="left"/>
              <td class="right"> 
                <input type="submit" value="Update User"/> 
              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'type'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'type'), $this);?>
 </td>
            </tr>
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'contactname'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'contactname','size' => '30'), $this);?>
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
            <tr>
              <th> <?php echo smarty_form_description(array('field' => 'theme'), $this);?>
 </th>
              <td> <?php echo smarty_form_element(array('dbo' => 'edit_user_dbo','field' => 'theme'), $this);?>
 </td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  </div>

  <div id="password" name="[PASSWORD]" width="80">
    <?php $this->_tag_stack[] = array('form', array('name' => 'edit_user_pass')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [RESET_PASSWORD] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right"> <input type="submit" value="Reset Password"/> </td>
            </tr>
          </tfoot>
          <tbody>
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
          </tbody>
        </table>
      </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  </div> 
</div>
</div>