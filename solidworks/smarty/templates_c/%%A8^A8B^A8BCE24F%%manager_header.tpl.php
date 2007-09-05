<?php /* Smarty version 2.6.14, created on 2007-08-21 12:10:47
         compiled from manager_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'manager_header.tpl', 14, false),array('function', 'echo', 'manager_header.tpl', 21, false),)), $this); ?>
        <div class="content_mast">
          <h1><?php echo $this->_tpl_vars['company_name']; ?>
</h1>

          <p class="navigation">

                        <?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['location_stack']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
$this->_sections['page']['step'] = 1;
$this->_sections['page']['start'] = $this->_sections['page']['step'] > 0 ? 0 : $this->_sections['page']['loop']-1;
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = $this->_sections['page']['loop'];
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
                 $this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
                 $this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>

              <?php if ($this->_sections['page']['last']): ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['location_stack'][$this->_sections['page']['index']]['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

              <?php else: ?>
                <a href="<?php echo $this->_tpl_vars['location_stack'][$this->_sections['page']['index']]['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['location_stack'][$this->_sections['page']['index']]['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a> >
              <?php endif; ?>

            <?php endfor; else: ?>

              <?php echo smarty_echo(array('phrase' => 'HOME'), $this);?>


            <?php endif; ?>

          </p>

	  <p class="user_display">
            <?php echo smarty_echo(array('phrase' => 'LOGGED_IN_AS'), $this);?>
: <?php echo $this->_tpl_vars['username']; ?>

            (<a href="manager_content.php?page=home&action=logout"><?php echo smarty_echo(array('phrase' => 'LOGOUT'), $this);?>
</a>)
          </p>

          <p class="ip_display">
            <?php echo $this->_tpl_vars['version']; ?>
 <?php echo smarty_echo(array('phrase' => 'ON'), $this);?>
 <?php echo $this->_tpl_vars['machine']; ?>

          </p>

        </div>