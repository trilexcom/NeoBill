<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

  <head>
    <title>Solid-State Manager - {$location|capitalize}</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
  </head>

  <body>

    {page_errors}

    <div class="login">

      {form name="login"}  
        <h1>Solid-State {echo phrase="LOGIN"}</h1>

        <p>{echo phrase="USERNAME"}:</p>
        {form_element field="username" size="30"}

        <p>{echo phrase="PASSWORD"}:</p>
        {form_element field="password" size="30"}<br/>

        <br/>{form_element field="continue"}

      {/form}
    </div>
  </body>
</html>
