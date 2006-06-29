<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="products_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="PRODUCTS"} </h2>
<div class="search">
  {form name="search_productdbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="id"} <br/>
          {form_element field="id" size="4"}
        </td>
        <td>
          {form_description field="name"} <br/>
          {form_element field="name" size="30"}
        </td>
        <td>
          {form_description field="description"} <br/>
          {form_element field="description" size="30"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {dbo_table dbo_class="ProductDBO" 
             name="productdbo_table" 
             title="[PRODUCTS]" 
             size="10"}

    {dbo_table_column header="[ID]" sort_field="id"}
      <a target="content" href="manager_content.php?page=services_view_product&id={dbo_echo dbo="productdbo_table" field="id"}"> {dbo_echo dbo="productdbo_table" field="id"} </a>
    {/dbo_table_column}

    {dbo_table_column header="[PRODUCT_NAME]" sort_field="name"}
      <a target="content" href="manager_content.php?page=services_view_product&id={dbo_echo dbo="productdbo_table" field="id"}"> {dbo_echo dbo="productdbo_table" field="name"} </a>
    {/dbo_table_column}

    {dbo_table_column header="[DESCRIPTION]"}
      {dbo_echo|truncate:40:"..." dbo="productdbo_table" field="description"}
    {/dbo_table_column}

    {dbo_table_column header="[PRICE]" sort_field="price"}
      {dbo_echo|currency dbo="productdbo_table" field="price"}
    {/dbo_table_column}

    {dbo_table_column header="[TAXABLE]" sort_field="taxable"}
      {dbo_echo dbo="productdbo_table" field="taxable"}
    {/dbo_table_column}

  {/dbo_table}
</div>
