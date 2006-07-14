<h1> {echo phrase="THANK_YOU_FOR_YOUR_ORDER"} </h2>

<p>
  {echo phrase="YOUR_ORDER_REFERENCE_NUMBER_IS"}:
  {dbo_echo dbo="order" field="id"}
</p>

<p>
  {echo phrase="A_CONFIRMATION_EMAIL"}
  {dbo_echo dbo="order" field="contactemail"}.
</p>

<p>
  To customize this page, edit order/templates/order_ReceiptPage.tpl.
</p>