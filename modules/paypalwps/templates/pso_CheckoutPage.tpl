<div class="domainoption">
  <table>
    <tr class="reverse"> <td colspan="2"> {echo phrase="PAY_WITH_PAYPAL"} </td> </tr>
    <tr> <td colspan="2"> {echo phrase="PAY_WITH_PAYPAL_TEXT"} </td> </tr>
    </tr>
  </table>
</div>
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
      <td class="right">
        <form action="{$cartURL}" method="POST">
          <input type="hidden" name="cmd" value="_cart"/>
          <input type="hidden" name="upload" value="1"/>
          <input type="hidden" name="custom" value="{$orderid}"/>
          <input type="hidden" name="business" value="{$account}"/>

          {* Generate list of cart items *}
          {foreach from=$paypalCart item=cartitem key=itemnum name=cartloop}
            <input type="hidden" name="item_name_{$itemnum+1}" value="{$cartitem.name}"/>
            <input type="hidden" name="quantity_{$itemnum+1}" value="{$cartitem.quantity}"/>
            <input type="hidden" name="amount_{$itemnum+1}" value="{$cartitem.amount}"/>
            <input type="hidden" name="tax_{$itemnum+1}" value="{$cartitem.tax}"/>
          {/foreach}

          <input type="submit" value="Pay with Paypal"/>
        </form>
      </td>
    </tr>
  </table>
</div>