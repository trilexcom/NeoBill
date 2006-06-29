<h2> {echo phrase="PRODUCT"} ({echo phrase="ID"}: {dbo_echo dbo="product_dbo" field="id"}) </h2>

{form name="edit_product"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="name"} </th>
        <td> {form_element dbo="product_dbo" field="name" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element dbo="product_dbo" field="description" cols="40" rows="3"} </td>
      </tr>
      <tr>
        <th> {form_description field="price"} </th>
        <td> {form_element dbo="product_dbo" field="price" size="7"} </td>
      </tr>
      <tr>
        <th> {form_description field="taxable"} </th>
        <td> {form_element dbo="product_dbo" field="taxable"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="save"}
          {form_element field="cancel"}
        </th>
	<td/>
      </tr>
    </table>
  </div>
{/form}
