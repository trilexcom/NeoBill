<?php /* Smarty version 2.6.14, created on 2007-08-27 11:45:40
         compiled from manager_ViewServerPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'dbo_assign', 'manager_ViewServerPage.tpl', 2, false),array('function', 'echo', 'manager_ViewServerPage.tpl', 3, false),array('function', 'dbo_echo', 'manager_ViewServerPage.tpl', 14, false),array('function', 'form_element', 'manager_ViewServerPage.tpl', 23, false),array('block', 'form', 'manager_ViewServerPage.tpl', 22, false),)), $this); ?>
<ul id="tabnav">
  <?php echo smarty_dbo_assign(array('dbo' => 'server_dbo','field' => 'id','var' => 'id'), $this);?>

  <li class="selected"> <a href="manager_content.php?page=services_view_server&id=<?php echo $this->_tpl_vars['id']; ?>
&action=info"> <?php echo smarty_echo(array('phrase' => 'SERVER_INFO'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&id=<?php echo $this->_tpl_vars['id']; ?>
&action=ips"> <?php echo smarty_echo(array('phrase' => 'IP_ADDRESSES'), $this);?>
 </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&id=<?php echo $this->_tpl_vars['id']; ?>
&action=services"> <?php echo smarty_echo(array('phrase' => 'HOSTING_SERVICES'), $this);?>
 </a> </li>
</ul>

<h2> <?php echo smarty_echo(array('phrase' => 'SERVER_INFORMATION'), $this);?>
 </h2>

<div class="properties">
  <table>
    <tr>
      <th> <?php echo smarty_echo(array('phrase' => 'HOSTNAME'), $this);?>
: </th>
      <td> <?php echo smarty_dbo_echo(array('dbo' => 'server_dbo','field' => 'hostname'), $this);?>
 </td>
    </tr>
    <tr>
      <th> <?php echo smarty_echo(array('phrase' => 'LOCATION'), $this);?>
: </th>
      <td> <?php echo smarty_dbo_echo(array('dbo' => 'server_dbo','field' => 'location'), $this);?>
 </td>
    </tr>
    <tr class="footer">
       <td colspan="2">
         <?php $this->_tag_stack[] = array('form', array('name' => 'view_server')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
           <?php echo smarty_form_element(array('field' => 'edit'), $this);?>

           <?php echo smarty_form_element(array('field' => 'delete'), $this);?>

         <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
       </td>
    </tr>
  </table>
</div>