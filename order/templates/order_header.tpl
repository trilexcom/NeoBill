<div class="header">
  <h1>SolidState Order Interface</h1>
  <p>Colors & styles can be customized in order/style.css</p>
  <p>Customize this header in order/templates/order_header.tpl</p>
</div>

<p>
  {if $username == null }
    {echo phrase="IF_YOU_ARE_AN_EXISTING_CUSTOMER"}
    <a href="index.php?page=customerlogin">{echo phrase="PLEASE_LOGIN"}</a>.
  {elseif $username == " "}
    
  {elseif isset( $username ) && !$supressWelcome}
    {echo phrase="WELCOME_BACK"}, {$username}!
  {/if}
</p>
