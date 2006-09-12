<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <title>Solid-State Order/Signup Interface - {$location|capitalize}</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
  </head>

  <body>

    <div class="content">

      {* Include page header *}
      {include file="order_header.tpl"}

      <div class="ordercontent">

        {* Display any error messages *}
        {page_errors}

        {* Display any page messages *}
        {page_messages}

        {* Include the page content *}
        {include file="$content_template"}

      </div>

      {* Include page footer *}
      {include file="order_footer.tpl"}

    </div>

  </body>

</html>
