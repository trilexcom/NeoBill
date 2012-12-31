<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>{$company_name} - Manager Interface</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
    <script src="js/jquery-1.7.js"></script>
	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.ui.position.js"></script>
	<script src="js/jquery.ui.button.js"></script>
	<script src="js/jquery.ui.menu.js"></script>
	<script src="js/jquery.ui.menubar.js"></script>
	<script src="js/jquery.ui.tabs.js"></script>
    <script src="js/jquery.ui.menuitem.js"></script>
    <script src="js/manager_custom.js"></script>
    <link rel="stylesheet" href="css/demos.css" type="text/css" />
	<link rel="stylesheet" href="css/jquery.ui.all.css" />
	<link rel="stylesheet" href="css/demos.css" />
	
  </head>

  {if isset( $jsFunction )}
    <body onLoad="{$jsFunction}">
  {else}
    <body>
  {/if}
 
    {include file="$header_template"}

      {* Display any error messages *}
      <div class="manager_error">{page_errors}
      </div>

      {* Display any page messages *}
      <div class="manager_error">{page_messages}
      </div>

      {* Include the page content *}
     {include file="$content_template"}



  </body>

</html>
