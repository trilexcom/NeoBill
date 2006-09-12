<h2> {echo phrase="ASSIGN_PRODUCT"}: {dbo_echo dbo="account_dbo" field="accountname"} </h2>

{form name="assign_product"}

  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="productid"} </th>
        <td> {form_element field="productid"} </td>
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element field="date"} </td>
      </tr>
      <tr>
        <th> {form_description field="note"} </th>
        <td> {form_element field="note" size="40"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"} 
          {form_element field="cancel"}
        </th>
      </tr>
    </table>
  </div>

{/form}
