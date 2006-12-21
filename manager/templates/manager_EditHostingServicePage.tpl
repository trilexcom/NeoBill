<h2> {echo phrase="HOSTING_SERVICE"} ({echo phrase="ID"}: {dbo_echo dbo="hosting_dbo" field="id"}) </h2>

{form name="edit_hosting"}
  <div class="form">
    <table style="width: 67%">
      <tr>
        <th> {form_description field="title"} </th>
        <td> {form_element dbo="hosting_dbo" field="title" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element dbo="hosting_dbo" field="description" cols="40" rows="3"} </td>
      </tr>
      <tr>
        <th> {form_description field="uniqueip"} </th>
        <td> {form_element dbo="hosting_dbo" field="uniqueip"} </td>
      </tr>
      <tr>
        <th> {form_description field="domainrequirement"} </th>
        <td> {form_element dbo="hosting_dbo" field="domainrequirement"} </td>
      </tr>
      <tr>
        <th> [ADD_TO_CART_URL]: </th>
        <td> order/index.php?page=purchasehosting&service={$serviceDBO->getID()} </td>
      </tr>
      <tr class="footer">
        <th> 
          {form_element field="save"}
          {form_element field="cancel"}
        </th>
	<td/>
      </tr>
    </table>
  </div>
{/form}

<h2> [PRICING] </h2>

{form name="edit_hosting_pricing"}
  <div class="table">
    {form_table field="prices" style="width: 67%"}

      {form_table_column columnid="id" header=""}
        {form_table_checkbox option=$prices.id}
      {/form_table_column}

      {form_table_column columnid="type" header="[TYPE]"}
        {$prices.type}
      {/form_table_column}

      {form_table_column columnid="termlength" header="[TERM_LENGTH]"}
        {if $prices.type == "Onetime"}
          [N/A]
        {else}
          {$prices.termlength} [MONTHS]
        {/if}
      {/form_table_column}

      {form_table_column columnid="price" header="[PRICE]"}
        {$prices.price|currency}
      {/form_table_column}

      {form_table_column columnid="taxable" header="[TAXABLE]"}
        {$prices.taxable}
      {/form_table_column}

      {form_table_footer}
        {form_element field="delete"}
      {/form_table_footer}

    {/form_table}
  </div>
{/form}

{form name="edit_hosting_add_price"}
  <div class="form">
    <table style="width: 67%">
      <tr>
        <th style="width: 25%"> {form_description field="type"} </th>
        <th style="width: 25%"> {form_description field="termlength"} </th>
        <th style="width: 25%"> {form_description field="price"} </th>
        <th style="width: 25%"> {form_description field="taxable"} </th>
      </tr>
      <tr>
        <td style="width: 25%"> {form_element field="type"} </td>
        <td style="width: 25%"> {form_element field="termlength" size="4"} </td>
        <td style="width: 25%"> {form_element field="price" size="6"} </td>
        <td style="width: 25%"> {form_element field="taxable"} </td>
      </tr>
      <tr class="footer">
        <td colspan="4"> {form_element field="add"} </td>
      </tr>
    </table>
  </div>
{/form}