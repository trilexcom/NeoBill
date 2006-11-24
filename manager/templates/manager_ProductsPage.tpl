<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="products_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="PRODUCTS"} </h2>
<div class="search">
  {form name="search_products"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="name"} <br/>
          {form_element field="name" size="30"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="products"}
    {form_table field="products" size="10"}

      {form_table_column columnid="id" header=""}
        <center> {form_table_checkbox option=$products.id} </center>
      {/form_table_column}

      {form_table_column columnid="name" header="[PRODUCT_NAME]"}
        <a target="content" href="manager_content.php?page=services_edit_product&product={$products.id}"> {$products.name} </a>
      {/form_table_column}

      {form_table_column columnid="price" header="[PRICING]"}
        {$products.pricing}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}
    
    {/form_table}
  {/form}
</div>