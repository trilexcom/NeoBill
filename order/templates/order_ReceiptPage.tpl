<h1> {echo phrase="THANK_YOU_FOR_YOUR_ORDER"} </h2>

<p>
  {echo phrase="YOUR_ORDER_REFERENCE_NUMBER_IS"}:
  {$orderid}
</p>

<p>
  {echo phrase="A_CONFIRMATION_EMAIL"}
  {$contactemail}.
</p>

{if $paybycheck}
  <p>
    Your order will be pending until your check/money order for: 
    {dbo_echo|currency dbo="order" field="total"} has been received.  Please make
    your check payable to Web Hosting Company, Inc. and send to:
  </p>
  <p>
    123 Main St.<br/>
    Anytown, ST. 99999<br/>
    USA<br/>
  </p>
  <p>
    To customize this message, edit order/templates/order_ReceiptPage.tpl
  <p/>
{/if}