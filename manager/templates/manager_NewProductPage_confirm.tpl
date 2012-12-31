<div class="manager_content"</div>
<p class="message">
  {echo phrase="NEW_PRODUCT_CONFIRM"}
</p>

{form name="new_product_confirm"}
  <h2> {echo phrase="ADD_PRODUCT"} </h2>
  <div class="properties">
    <table style="width: 70%">
      <tr>
        <th> {echo phrase="PRODUCT_NAME"}: </th>
        <td> {dbo_echo dbo="new_product_dbo" field="name"} </td>
      </tr>
      <tr>
        <th> {echo phrase="DESCRIPTION"}: </th>
        <td>
          <textarea cols="40" rows="3" readonly="readonly">{dbo_echo dbo="new_product_dbo" field="description"}</textarea>
        </td>
      </tr>
      <tr>
        <th> {echo phrase="PRICE"}: </th>
        <td> {dbo_echo|currency dbo="new_product_dbo" field="price"} </td>
      </tr>
      <tr>
        <th> {echo phrase="TAXABLE"}: </th>
        <td> {dbo_echo dbo="new_product_dbo" field="taxable"} </td>
      </tr>
      <tr class="footer">
        <th class="footer"> 
          {form_element field="continue"}
          {form_element field="goback"}
        </th>
        <td/>
      </tr>
    </table>
  </div>
{/form}
