<b> {echo phrase="YOUR_ORDER"}: </b>
{form name="cart_mod"}
  <div class="cart">
    {form_element field="carttable"}

    {form_element field="adddomain"}
    {form_element field="addhosting"}
    {form_element field="remove"}
  </div>

  <div class="cart_total">
      <table>
        <tr>
          <th>{echo phrase="RECURRING_TOTAL"}:</th>
          <td>{$recurring_total|currency}</td>
        </tr>
        <tr>
          <th>{echo phrase="NONRECURRING_TOTAL"}:</th>
          <td>{$nonrecurring_total|currency}</td>
        </tr>
        <tr>
          <th>{echo phrase="CART_TOTAL"}:</th>
          <td>{$cart_total|currency}</td>
        </tr>
      </table>
      <p>({echo phrase="DOES_NOT_INCLUDE_TAXES"})</p>
  </div>
{/form}

<div class="cart">
  {form name="cart_domains"}

    {if $show_existing_domains}
      <hr/>
      <p> {echo phrase="EXISTING_DOMAIN_LIST"}: </p>
      <div class="domains">
        {form_element field="domaintable"}
        {form_element field="removedomain"}
      </div>
      <p> {echo phrase="EXISTING_DOMAIN_CART_TEXT"} </p>
    {/if}

  {/form}

  <hr/>
</div>

{form name="cart_nav"}
  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left">{form_element field="startover"}</td>
        <td class="right">
          {form_element field="checkout"}
        </td>
      </tr>
    </table>
  </div>
{/form}
