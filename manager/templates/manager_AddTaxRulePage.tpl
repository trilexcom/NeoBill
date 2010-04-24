{form name="new_tax_rule"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [NEW_TAX_RULE] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left">
            {form_element field="cancel"}
          </td>
          <td class="right">
            {form_element field="continue"} 
          </th>
        </tr>
      </tfoot>
      <tbody>
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
        </tr>
        <tr>
          <th> &nbsp;{form_description field="state"} </th>
          <td> {form_element field="state" size="20"} </td>
        </tr>
        <tr>
          <th> {form_description field="description"} </th>
          <td> {form_element field="description" size="40"} </td>
        </tr>
    </table>
  </div>
{/form}
