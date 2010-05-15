<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>{$order_title}</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
		<link rel="stylesheet" type="text/css" href="coffee.css" media="screen"/>
	</head>

	<body>

		<div class="container">

			{* Include page header *}
			{include file="order_header.tpl"}

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
						  {if $username == null && !$supressWelcome }
							{echo phrase="IF_YOU_ARE_AN_EXISTING_CUSTOMER"}
							<a href="index.php?page=customerlogin">{echo phrase="PLEASE_LOGIN"}</a>.
						  {elseif $username == " "}

						  {elseif isset( $username ) && !$supressWelcome}
							{echo phrase="WELCOME_BACK"}, {$username}!
						  {/if}
						</div><br/>

						{* Display any error messages *}
						{page_errors}

						{* Display any page messages *}
						{page_messages}

						{* Include the page content *}
						{include file="$content_template"}

					</div>

				</div>

				<div class="clearer"><span></span></div>

			</div>

			{* Include page footer *}
			{include file="order_footer.tpl"}

			<div class="footer">&copy; 2010 <a href="http://www.solid-state.org">solid-state.org</a>. Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> &amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>. Template design by <a href="http://templates.arcsin.se">Arcsin</a>
			</div>

		</div>

	</body>

</html>
