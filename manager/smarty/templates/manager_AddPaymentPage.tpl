<h2> {echo phrase="ENTER_PAYMENT"} </h2>

{form name="new_payment"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {echo phrase="ACCOUNT"}: </th>
        <td> {dbo_echo dbo="account_dbo" field="accountname"} </td>
      </tr>
      <tr>
        {if isset($invoice_id)}
          <th> {form_description field="invoiceid"} </th>
          <td> {echo phrase="INVOICE"} #{$invoice_id} </td>
        {else}
          <th> {form_description field="invoiceid"} </th>
          <td> {form_element field="invoiceid"} </td>
        {/if}
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
          {form_element field="cancel"}
        </th>
      </tr>
    </table>
  </div>
{/form}
