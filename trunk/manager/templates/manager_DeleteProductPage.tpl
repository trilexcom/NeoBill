<p class="message">
  {echo phrase="DELETE_PRODUCT"}
</p>

{form name="delete_product"}
  <h2> {echo phrase="PRODUCT"} </h2>
  <div class="properties">
    <table style="width: 575px">
      <tr>
        <th> {echo phrase="PRODUCT_NAME"}: </th>
        <td> {dbo_echo dbo="product_dbo" field="name"} </td>
      </tr>
      <tr>
        <th> {echo phrase="DESCRIPTION"}: </th>
        <td>
          <textarea cols="40" rows="3" readonly="readonly">{dbo_echo dbo="product_dbo" field="description"}</textarea>
        </td>
      </tr>
      <tr>
        <th> {echo phrase="PRICE"}: </th>
        <td> {dbo_echo|currency dbo="product_dbo" field="price"} </td>
      </tr>
      <tr class="footer">
        <th class="footer">
          {form_element field="delete"}
          {form_element field="cancel"}
        </th>
        <td/>
      </tr>
    </table>
  </div>
{/form}
