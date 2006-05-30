<h2> {echo phrase="EDIT_PAYMENT"} </h2>

{form name="edit_payment"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {echo phrase="ACCOUNT"}: </th>
        <td> {dbo_echo dbo="payment_dbo" field="accountname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="INVOICE"}: </th>
        <td> #{dbo_echo dbo="payment_dbo" field="invoiceid"} </td>
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element dbo="payment_dbo" field="date"} </td>
      </tr>
      <tr>
        <th> {form_description field="type"} </th>
        <td> {form_element dbo="payment_dbo" field="type"} </td>
      </tr>
      <tr>
        <th> {form_description field="amount"} </th>
        <td> {form_element dbo="payment_dbo" field="amount" size="7"} </td>
      </tr>
      <tr>
        <th> {form_description field="transaction1"} </th>
        <td> {form_element dbo="payment_dbo" field="transaction1" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="transaction2"} </th>
        <td> {form_element field="transaction2" size="20"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="save"} 
          {form_element field="cancel"}
        </th>
      </tr>
    </table>
  </div>
{/form}

