<?php /* Smarty version 2.6.14, created on 2012-03-10 19:09:52
         compiled from order_content.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo', 'order_content.tpl', 34, false),array('function', 'page_errors', 'order_content.tpl', 44, false),array('function', 'page_messages', 'order_content.tpl', 47, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title><?php echo $this->_tpl_vars['order_title']; ?>
</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
		<link rel="stylesheet" type="text/css" href="coffee.css" media="screen"/>
	</head>

	<body>

		<div class="container">

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "order_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<div class="navigation">
				<a href="#"></a>
				<a href="#"></a>
				<a href="#"></a>
				<a href="#"></a>
				<a href="#"></a>
				<div class="clearer"><span></span></div>
			</div>

			<div class="main">

				<div class="content">

					<div class="ordercontent">

						<div>
						  <?php if ($this->_tpl_vars['username'] == null && ! $this->_tpl_vars['supressWelcome']): ?>
							<?php echo smarty_echo(array('phrase' => 'IF_YOU_ARE_AN_EXISTING_CUSTOMER'), $this);?>

							<a href="index.php?page=customerlogin"><?php echo smarty_echo(array('phrase' => 'PLEASE_LOGIN'), $this);?>
</a>.
						  <?php elseif ($this->_tpl_vars['username'] == ' '): ?>

						  <?php elseif (isset ( $this->_tpl_vars['username'] ) && ! $this->_tpl_vars['supressWelcome']): ?>
							<?php echo smarty_echo(array('phrase' => 'WELCOME_BACK'), $this);?>
, <?php echo $this->_tpl_vars['username']; ?>
!
						  <?php endif; ?>
						</div><br/>

												<?php echo smarty_page_errors(array(), $this);?>


												<?php echo smarty_page_messages(array(), $this);?>


												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['content_template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

					</div>

				</div>

				<div class="clearer"><span></span></div>

			</div>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "order_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<div class="footer">&copy; 2011 <a href="http://www.neobill.net">NeoBill</a>. Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> &amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>. Template design by <a href="http://templates.arcsin.se">Arcsin</a>
			</div>

		</div>

	</body>

</html>