<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>NeoBill Manager - {$location|capitalize}</title>
    <link rel="stylesheet" type="text/css" href="./style.css" /> 
    <link rel="stylesheet" type="text/css" href="./css/demos.css" />
    <script src="./js/jquery-1.7.js"></script>
	<script src="./js/jquery.ui.core.js"></script>
	<script src="./js/jquery.ui.widget.js"></script>
	<script src="./js/jquery.ui.position.js"></script>
	<script src="./js/jquery.ui.button.js"></script>
	<script src="./js/jquery.ui.menu.js"></script>
	<script src="./js/jquery.ui.menubar.js"></script>
    <script src="./js/jquery.ui.menuitem.js"></script>
	<link rel="stylesheet" href="./css/jquery.ui.all.css" /> 
  </head>

  <body>
{include file="$header_template"}
    {page_errors}
<div class="manager_content"</div>
    <div class="login">

      {form name="login"}  
        <h1>NeoBill {echo phrase="LOGIN"}</h1>

        <p>{echo phrase="USERNAME"}:</p>
        {form_element field="username" size="30"}

        <p>{echo phrase="PASSWORD"}:</p>
        {form_element field="password" size="30"}<br/>

        <p>[THEME]:</p>
        {form_element field="theme"} <br/>

        <br/>{form_element field="continue"}

      {/form}
    </div>
  </body>
</html>
