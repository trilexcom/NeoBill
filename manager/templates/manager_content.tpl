<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <title>{$company_name} - Manager Interface</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
    <script type="text/javascript" src="../solidworks/include.js"></script>
  </head>

  {if isset( $jsFunction )}
    <body onLoad="{$jsFunction}">
  {else}
    <body>
  {/if}
 
    <div class="content">

      {* Include page header *}
      {include file="$header_template"}

      {* Display any error messages *}
      {page_errors}

      {* Display any page messages *}
      {page_messages}

      {* Include the page content *}
      {include file="$content_template"}

    </div>

  </body>

</html>
