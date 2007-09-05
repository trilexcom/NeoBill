<?php /* Smarty version 2.6.14, created on 2007-08-24 11:56:02
         compiled from ../../modules/resellerclub/templates/rcm_ConfigPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', '../../modules/resellerclub/templates/rcm_ConfigPage.tpl', 1, false),array('function', 'form_description', '../../modules/resellerclub/templates/rcm_ConfigPage.tpl', 7, false),array('function', 'form_element', '../../modules/resellerclub/templates/rcm_ConfigPage.tpl', 8, false),array('block', 'form', '../../modules/resellerclub/templates/rcm_ConfigPage.tpl', 3, false),)), $this); ?>
<h2> <?php echo smarty_echo(array('phrase' => 'RESELLER_CLUB_MODULE'), $this);?>
 </h2>

<?php $this->_tag_stack[] = array('form', array('name' => 'rcm_config')); $_block_repeat=true;smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <div class="form">
    <table>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'username'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'username','value' => ($this->_tpl_vars['rcusername']),'size' => '40'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'password'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'password','value' => ($this->_tpl_vars['password'])), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'resellerid'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'resellerid','value' => ($this->_tpl_vars['resellerid'])), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'parentid'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'parentid','value' => ($this->_tpl_vars['parentid'])), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'role'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'role','value' => ($this->_tpl_vars['role'])), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'langpref'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'langpref','value' => ($this->_tpl_vars['langpref'])), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'serviceurl'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'serviceurl','value' => ($this->_tpl_vars['serviceurl']),'size' => '60'), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'debug'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'debug','value' => ($this->_tpl_vars['debug'])), $this);?>
 </td>
      </tr>
      <tr>
        <th> <?php echo smarty_form_description(array('field' => 'defaultcustomerpassword'), $this);?>
 </th>
        <td> <?php echo smarty_form_element(array('field' => 'defaultcustomerpassword','value' => ($this->_tpl_vars['defaultcustomerpassword'])), $this);?>
 </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          <?php echo smarty_form_element(array('field' => 'save'), $this);?>

        </td>
      </tr>
    </table>
  </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>