<h2> {echo phrase="GENERATE_INVOICE_BATCH"} </h2>

{form name="generate_invoices"}
  <div class="form">
    <table style="width: 70%">
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
        <td> {form_element field="note"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"} 
        </th>
      </tr>
    </table>
  </div>
{/form}
