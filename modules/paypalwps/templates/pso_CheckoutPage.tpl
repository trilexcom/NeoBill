<div class="manager_content"></div>
<form action="{$cartURL}" method="POST">
  <input type="hidden" name="cmd" value="_cart"/>
  <input type="hidden" name="upload" value="1"/>
  <input type="hidden" name="custom" value="{$orderid}"/>
  <input type="hidden" name="business" value="{$account}"/>
  <input type="hidden" name="currency_code" value="{$currencyCode}"/>

  {* Generate list of cart items *}
  {foreach from=$paypalCart item=cartitem key=itemnum name=cartloop}
    <input type="hidden" name="item_name_{$itemnum+1}" value="{$cartitem.name}"/>
    <input type="hidden" name="quantity_{$itemnum+1}" value="{$cartitem.quantity}"/>
    <input type="hidden" name="amount_{$itemnum+1}" value="{$cartitem.amount}"/>
    <input type="hidden" name="tax_{$itemnum+1}" value="{$cartitem.tax}"/>
  {/foreach}

  <div class="domainoption">
    <table>
      <tr class="reverse"> <td colspan="2"> {echo phrase="PAY_WITH_PAYPAL"} </td> </tr>
      <tr> 
        <td colspan="2"> 
          {echo phrase="PAY_WITH_PAYPAL_TEXT"}
          <p align="center"> <input type="submit" value="Pay with Paypal"/> </p>
        </td>
      </tr>
    </table>
  </div>
</form>
<div class="buttoncontainer">
  <table>
    <tr class="buttoncontainer">
      <td class="left">
        {form name="pso_checkout"}
          {form_element field="startover"}
        {/form}
      </td>
      <td class="right">
        {form name="pso_checkout"}
          {form_element field="back"}
        {/form}
      </td>
  </table>
</div>
