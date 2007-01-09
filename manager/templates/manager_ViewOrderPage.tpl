{form name="order"}
  <div class="action">
    <p class="header">Actions</p>
    {form_element field="execute"} 
    {form_element field="delete"}
  </div>

  <h2>{echo phrase="ORDER"} #{dbo_echo dbo="orderdbo" field="id"}</h2>

  <div class="properties">
    <table style="width: 35em">
      <tr>
        <th> {echo phrase="ORDER_ID"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="id"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ORDER_DATE"}: </th>
        <td> {dbo_echo|datetime dbo="orderdbo" field="datecreated"} </td>
      </tr>
      <tr>
        <th> {echo phrase="REMOTE_IP_ADDRESS"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="remoteipstring"} </td>
      </tr>
      <tr>
        <th> {echo phrase="SUB_TOTAL"}: </th>
        <td> {dbo_echo|currency dbo="orderdbo" field="subtotal"} </td>
      </tr>
      <tr>
        <th> {echo phrase="TAXES"}: </th>
        <td> {dbo_echo|currency dbo="orderdbo" field="taxtotal"} </td>
      </tr>
      <tr>
        <th> {echo phrase="TOTAL"}: </th>
        <td> {dbo_echo|currency dbo="orderdbo" field="total"} </td>
      </tr>
      <tr>
        <th> [CUSTOMER_NOTE]: </th>
        <td> <textarea rows="6" cols="40" readonly="true">{dbo_echo dbo="orderdbo" field="note"}</textarea> </td>
      </tr>
    </table>
  </div>

  {dbo_assign dbo="orderdbo" field="accounttype" var="accounttype"}
  {if $accounttype == "New Account"}

    <h2> {echo phrase="CONTACT_INFORMATION"} </h2>
 
    <div class="form">
      <table style="width: 35em">
        <tr>
          <th> {form_description field="businessname"} </th>
          <td> {form_element dbo="orderdbo" field="businessname" size="40"} </td>
        </tr>
        <tr>
          <th> {form_description field="contactname"} </th>
          <td> {form_element dbo="orderdbo" field="contactname" size="30"} </td>
        </tr>
        <tr>
          <th> {form_description field="contactemail"} </th>
          <td> {form_element dbo="orderdbo" field="contactemail" size="30"} </td>
        </tr>
        <tr>
          <th> {form_description field="address1"} </th>
          <td> {form_element dbo="orderdbo" field="address1" size="40"} </th>
        </tr>
        <tr>
          <th> {form_description field="address2"} </th>
          <td> {form_element dbo="orderdbo" field="address2" size="40"} </td>
        </tr>
        <tr>
          <th> {form_description field="city"} </th>
          <td> {form_element dbo="orderdbo" field="city" size="30"} </td>
        </tr>
        <tr>
          <th> {form_description field="state"} </th>
          <td> {form_element dbo="orderdbo" field="state" size="20"} </td>
        </tr>
        <tr>
          <th> {form_description field="postalcode"} </th>
          <td> {form_element dbo="orderdbo" field="postalcode" size="10"} </td>
        </tr>
        <tr>
          <th> {form_description field="country"} </th>
          <td> {form_element dbo="orderdbo" field="country"} </td>
        </tr>
        <tr>
          <th> {form_description field="phone"} </th>
          <td> {form_element dbo="orderdbo" field="phone" size="15"} </th>
         </tr>
        <tr>
          <th> {form_description field="mobilephone"} </th>
          <td> {form_element dbo="orderdbo" field="mobilephone" size="15"} </td>
        </tr>
        <tr>
          <th> {form_description field="fax"} </th>
          <td> {form_element dbo="orderdbo" field="fax" size="15"} </td>
        </tr>
      </table>
    </div>

    <h2> {echo phrase="ACCOUNT_INFORMATION"} </h2>
     <div class="properties">
      <table style="width: 35em">
        <tr>
          <th> {form_description field="username"} </th>
          <td> {form_element dbo="orderdbo" field="username" size="10"} </a>
        </tr>
        <tr>
          <th> {form_description field="password"} </th>
          <td> 
            {form_element field="password" size="10"} <br/>
            {echo phrase="ONLY_SUPPLY_A_PASSWORD"} 
          </td>
        </tr>
      </table>
     </div>

  {else}

    <h2> {echo phrase="ACCOUNT_INFORMATION"} </h2>
     <div class="form">
      <table style="width: 35em">
        <tr>
          <th> {echo phrase="ACCOUNT"}: </th>
          <td> <a href="manager_content.php?page=accounts_view_account&id={dbo_echo dbo="accountdbo" field="id"}">{dbo_echo dbo="accountdbo" field="accountname"}</a>
        </tr>
        <tr>
          <th> {echo phrase="BALANCE"}: </th>
          <td> {dbo_echo|currency dbo="accountdbo" field="balance"} </td>
        </tr>
      </table>
     </div>

  {/if}

  <h2> {echo phrase="ORDER_ITEMS"} </h2>
  <div class="table">
    {form_table field="items"}

      {form_table_column columnid="" header="[ACCEPT]"}
        <center> 
          {form_table_checkbox option=$items.orderitemid}
        </center>
      {/form_table_column}

      {form_table_column columnid="description" header="[ITEM]"}
        {$items.description}
      {/form_table_column}

      {form_table_column columnid="term" header="[TERM]"}
        {$items.term}
      {/form_table_column}

      {form_table_column columnid="setupfee" header="[SETUP_PRICE]"}
        {$items.setupfee|currency}
      {/form_table_column}

      {form_table_column columnid="price" header="[RECURRING_PRICE]"}
        {$items.price|currency}
      {/form_table_column}

      {form_table_footer}
        {form_element field="save"}
      {/form_table_footer}

    {/form_table}
  </div>

  <h2> {echo phrase="PAYMENTS"} </h2>
  <div class="table">
    {form_table field="payments"}

      {form_table_column columnid="id" header="[ID]"}
        <a href="manager_content.php?page=edit_payment&payment={$payments.id}">{$payments.id}</a>
      {/form_table_column}

      {form_table_column columnid="date" header="[DATE_RECEIVED]"}
        {$payments.date|datetime:date}
      {/form_table_column}

      {form_table_column columnid="amount" header="[AMOUNT]"}
        {$payments.amount|currency}
      {/form_table_column}

      {form_table_column columnid="type" header="[PAYMENT_TYPE]"}
        {$payments.type}
      {/form_table_column}

      {form_table_column columnid="module" header="[MODULE]"}
        {$payments.module}
      {/form_table_column}

      {form_table_column columnid="status" header="[PAYMENT_STATUS]"}
        {$payments.status}
      {/form_table_column}
    
    {/form_table}
  </div>
{/form}