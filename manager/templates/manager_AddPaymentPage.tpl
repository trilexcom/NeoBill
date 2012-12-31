<div class="manager_content"</div>
{form name="new_payment"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [ENTER_PAYMENT] </th>
        </tr>
      </thead>
      <tfoot>
        <tr class="footer">
          <td class="left">
            {form_element field="cancel"}
          </td>
          <td class="right">
            {form_element field="continue"} 
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th> {echo phrase="ACCOUNT"}: </th>
          <td> {dbo_echo dbo="account_dbo" field="accountname"} </td>
        </tr>
        <tr>
          {if isset($invoice_id)}
            <th> {form_description field="invoice"} </th>
            <td> {echo phrase="INVOICE"} #{$invoice_id} </td>
          {else}
            <th> {form_description field="invoice"} </th>
            <td> {form_element field="invoice"} </td>
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
      </tbody>
    </table>
  </div>
{/form}
