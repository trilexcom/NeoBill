<h2> {echo phrase="ENTER_PAYMENT"} </h2>

{form name="billing_payment"}
  <div class="form">
    <table stlye="width: 70%">
      <tr>
        <th> {form_description field="invoiceid_select"} </th>
        <td> {form_element field="invoiceid_select"} </td>
      </tr>
      <tr>
        <th> &nbsp;&nbsp; or {form_description field="invoiceid_int"} </th>
        <td> {form_element field="invoiceid_int" size="5"} </td>
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element field="date"} </td>
      </tr>
      <tr>
        <th> {form_description field="type"} </th>
        <td> {form_element field="type"} </td>
      </tr>
      <tr>
        <th> {form_description field="amount"} </th>
        <td> {form_element field="amount" size="7"} </td>
      </tr>
      <tr>
        <th> {form_description field="transaction1"} </th>
        <td> {form_element field="transaction1" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="transaction2"} </th>
        <td> {form_element field="transaction2" size="20"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"} 
        </th>
      </tr>
    </table>
  </div>
{/form}
