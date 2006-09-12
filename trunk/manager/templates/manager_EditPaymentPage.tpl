{form name="edit_payment"}

  {dbo_assign dbo="payment_dbo" field="status" var="status"}
  {dbo_assign dbo="payment_dbo" field="moduletype" var="moduletype"}
  {if $moduletype == "payment_gateway" && $status == "Authorized"}
    <div class="action">
      <p class="header">{echo phrase="ACTIONS"}</p>
      {form_element field="capture"}
      {form_element field="void"}
    </div>
  {elseif $moduletype == "payment_gateway" && $status == "Completed"}
    <div class="action">
      <p class="header">{echo phrase="ACTIONS"}</p>
      {form_element field="refund"}
    </div>
  {/if}

  <h2> {echo phrase="EDIT_PAYMENT"} </h2>

  <div class="form">
    <table style="width: 70%">
      <tr>
        {dbo_assign dbo="payment_dbo" field="invoiceid" var="invoiceid"}
        {if $invoiceid != 0}
          <th> {echo phrase="ACCOUNT"}: </th>
          <td> {dbo_echo dbo="payment_dbo" field="accountname"} </td>
        {else}
          <th> {echo phrase="ORDER_ID"}: </th>
          <td> {dbo_echo dbo="payment_dbo" field="orderid"} </td>
        {/if}
      </tr>
      {if $invoiceid !=0}
        <tr>
          <th> {echo phrase="INVOICE"}: </th>
          <td> #{dbo_echo dbo="payment_dbo" field="invoiceid"} </td>
        </tr>
      {/if}
      <tr>
        <th> {echo phrase="TYPE"}: </th>
        <td> {dbo_echo dbo="payment_dbo" field="type"} </td>
      </tr>
      <tr>
        <th> {echo phrase="MODULE"}: </th>
        <td> {dbo_echo dbo="payment_dbo" field="module"} </td>
      </tr>
      <tr>
        <th> {form_description field="amount"} </th>
        <td> {form_element dbo="payment_dbo" field="amount" size="7"} </td>
      </tr>
      <tr>
        <th> {form_description field="status"} </th>
        <td> {form_element dbo="payment_dbo" field="status"} </td>
      </tr>
      <tr>
        <th> {form_description field="statusmessage"} </th>
        <td> {form_element dbo="payment_dbo" field="statusmessage"} </td>
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element dbo="payment_dbo" field="date"} </td>
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