<?php /* Smarty version 2.6.14, created on 2007-08-27 11:46:01
         compiled from manager_DeleteServerPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'manager_DeleteServerPage.tpl', 1, false),array('function', 'dbo_echo', 'manager_DeleteServerPage.tpl', 11, false),array('function', 'form_element', 'manager_DeleteServerPage.tpl', 20, false),array('block', 'form', 'manager_DeleteServerPage.tpl', 19, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'DELETE_SERVER'), $this);?>
 </h2>

<p class="message">
  <?php echo smarty_echo(array('phrase' => 'DELETE_SERVER_NOTICE'), $this);?>

</p>

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
         <?php $this->_tag_stack[] = array('form', array('name' => 'delete_server')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
           <?php echo smarty_form_element(array('field' => 'delete'), $this);?>

           <?php echo smarty_form_element(array('field' => 'cancel'), $this);?>

         <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
       </td>
    </tr>
  </table>
</div>