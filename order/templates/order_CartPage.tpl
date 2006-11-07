<b> {echo phrase="YOUR_ORDER"}: </b>
{form name="cart_mod"}
  <div class="cart">
    {form_table field="cart"}

      {form_table_column columnid=""}
        <center> {form_table_checkbox option=$cart.orderitemid} </center>
      {/form_table_column}

      {form_table_column columnid="description" header="[ITEM]"}
        {$cart.description}
      {/form_table_column}

      {form_table_column columnid="term" header="[TERM]"}
        {$cart.term}
      {/form_table_column}

      {form_table_column columnid="setupfee" header="[SETUP_FEE]"}
        {$cart.setupfee|currency}
      {/form_table_column}

      {form_table_column columnid="price" header="[PRICE]"}
        {$cart.price|currency}
      {/form_table_column}

      {form_table_footer}
        {form_element field="adddomain"}
        {form_element field="addhosting"}
        {form_element field="remove"}
      {/form_table_footer}
    
    {/form_table}
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
        {form_table field="domaintable"}

          {form_table_column columnid=""}
            <center> {form_table_checkbox option=$domaintable.orderitemid} </center>
          {/form_table_column}

          {form_table_column columnid="domainname" header="[DOMAIN_NAME]"}
            {$domaintable.domainname}
          {/form_table_column}

          {form_table_footer}
            {form_element field="removedomain"}
          {/form_table_footer}

        {/form_table}
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
