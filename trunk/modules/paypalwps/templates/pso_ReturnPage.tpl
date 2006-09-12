{if $paymentStatus == "Pending"}
  {echo phrase="PAYMENT_IS_PENDING_TEXT"}
{else}
  Your payment of {$amount} was been received via Paypal.  You will receive an e-mail confirmation shortly.
{/if}
