<h2> {echo phrase="NEW_TAX_RULE"} </h2>

{form name="new_tax_rule"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="rate"} </th>
        <td> {form_element field="rate" size="4"} % </td>
      </tr>
      <tr>
        <th> {form_description field="country"} </th>
        <td> {form_element field="country"} </td>
      </tr>
      <tr>
        <th> {form_description field="allstates"} </th>
        <td> {form_element field="allstates" option="true"} </td>
        </td>
      </tr>
      <tr>
        <th> &nbsp;{form_description field="state"} </th>
        <td> {form_element field="state" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element field="description" size="40"} </td>
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
