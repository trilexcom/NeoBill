<?php /* Smarty version 2.6.14, created on 2007-08-21 12:55:11
         compiled from manager_ConfigureUsers.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'manager_ConfigureUsers.tpl', 3, false),array('block', 'dbo_table', 'manager_ConfigureUsers.tpl', 39, false),array('block', 'dbo_table_column', 'manager_ConfigureUsers.tpl', 44, false),array('function', 'form_element', 'manager_ConfigureUsers.tpl', 4, false),array('function', 'echo', 'manager_ConfigureUsers.tpl', 8, false),array('function', 'form_description', 'manager_ConfigureUsers.tpl', 15, false),array('function', 'dbo_echo', 'manager_ConfigureUsers.tpl', 45, false),array('modifier', 'mailto', 'manager_ConfigureUsers.tpl', 58, false),)), $this); ?>
<div class="action">
  <p class="header">Actions</p>
  <?php $this->_tag_stack[] = array('form', array('name' => 'users_action')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_form_element(array('field' => 'add'), $this);?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<h2> <?php echo smarty_echo(array('field' => 'USERS'), $this);?>
 </h2>
<div class="search">
  <?php $this->_tag_stack[] = array('form', array('name' => 'search_userdbo_table')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <table>
      <tr>
        <th> <?php echo smarty_echo(array('phrase' => 'SEARCH'), $this);?>
 </th>
        <td>
          <?php echo smarty_form_description(array('field' => 'username'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'username','size' => '10'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'firstname'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'firstname','size' => '20'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'lastname'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'lastname','size' => '20'), $this);?>

        </td>
        <td>
          <?php echo smarty_form_description(array('field' => 'type'), $this);?>
 <br/>
          <?php echo smarty_form_element(array('field' => 'type'), $this);?>

        </td>
        <td class="submit"> 
          <?php echo smarty_form_element(array('field' => 'search'), $this);?>

        </td>
      </tr>
    </table>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="table">
  <?php $this->_tag_stack[] = array('dbo_table', array('dbo_class' => 'UserDBO','name' => 'userdbo_table','title' => "[USERS]",'size' => '10')); $_block_repeat=true;smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[USERNAME]",'sort_field' => 'username')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <a href="manager_content.php?page=config_edit_user&username=<?php echo smarty_dbo_echo(array('dbo' => 'userdbo_table','field' => 'username'), $this);?>
"><?php echo smarty_dbo_echo(array('dbo' => 'userdbo_table','field' => 'username'), $this);?>
</a>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[TYPE]",'sort_field' => 'type')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'userdbo_table','field' => 'type'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[NAME]",'sort_field' => 'lastname')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo smarty_dbo_echo(array('dbo' => 'userdbo_table','field' => 'firstname'), $this);?>

      <?php echo smarty_dbo_echo(array('dbo' => 'userdbo_table','field' => 'lastname'), $this);?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('dbo_table_column', array('header' => "[EMAIL]",'sort_field' => 'email')); $_block_repeat=true;smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <?php echo ((is_array($_tmp=smarty_dbo_echo(array('dbo' => 'userdbo_table','field' => 'email'), $this))) ? $this->_run_mod_handler('mailto', true, $_tmp) : smarty_modifier_mailto($_tmp));?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table_column($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_dbo_table($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>