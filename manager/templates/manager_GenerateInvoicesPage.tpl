<div class="manager_content"</div>
{form name="generate_invoices"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [GENERATE_INVOICE_BATCH] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left"/>
          <td class="right">
            {form_element field="continue"} 
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th> {form_description field="date"} </th>
          <td> {form_element field="date"} </td>
        </tr>
        <tr>
          <th> [INVOICE_PERIOD]: </th>
          <td> 
            {form_element field="periodbegin"} to {form_element field="periodend" value=$nextMonth}
          </td>
        </tr>
        <tr>
          <th> {form_description field="terms"} </th>
          <td> {form_element field="terms" size="2"} </td>
        </tr>
        <tr>
          <th> {form_description field="note"} </th>
          <td> {form_element field="note" rows="4" cols="60"} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}
