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
          <th> {form_description field="country"} </th>
          <td> {form_element dbo="orderdbo" field="country" size="20"} </td>
        </tr>
        <tr>
          <th> {form_description field="postalcode"} </th>
          <td> {form_element dbo="orderdbo" field="postalcode" size="10"} </td>
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
    {dbo_table dbo_class="OrderItemDBO"
               name="orderitemdbo_table"
               method_name="populateItemTable"
               title="[ORDER_ITEMS]"}

      {dbo_table_column header="[ACCEPT]"}
        {dbo_assign dbo="orderitemdbo_table" field="orderitemid" var="itemid"}
        {dbo_assign dbo="orderitemdbo_table" field="status" var="status"}
        <center>
          {if $status == "Rejected"}
            {form_element field="accepted" value="$itemid"}
          {else}
            {form_element field="accepted" value="$itemid" checked="true"}
          {/if}
        </center>
      {/dbo_table_column}

      {dbo_table_column header="[ITEM]"}
        {dbo_echo dbo="orderitemdbo_table" field="description"}
      {/dbo_table_column}

      {dbo_table_column header="[TERM]"}
        {dbo_echo dbo="orderitemdbo_table" field="term"}
      {/dbo_table_column}

      {dbo_table_column header="[SETUP_PRICE]"}
        {dbo_echo|currency dbo="orderitemdbo_table" field="setupfee"}
      {/dbo_table_column}

      {dbo_table_column header="[RECURRING_PRICE]"}
        {dbo_echo|currency dbo="orderitemdbo_table" field="price"}
      {/dbo_table_column}

    {/dbo_table}

    {form_element field="save"}
  </div>

  <h2> {echo phrase="PAYMENTS"} </h2>

  <div class="table">
    {dbo_table dbo_class="PaymentDBO" 
               name="paymentdbo_table" 
               method_name="populatePaymentTable"
               title="[PAYMENTS]"}

      {dbo_table_column header="[ID]" sort_field="id"}
        <a href="manager_content.php?page=edit_payment&id={dbo_echo dbo="paymentdbo_table" field="id"}">{dbo_echo dbo="paymentdbo_table" field="id"}</a>
      {/dbo_table_column}

      {dbo_table_column header="[DATE_RECEIVED]" sort_field="date"}
        {dbo_echo|datetime:date dbo="paymentdbo_table" field="date"}
      {/dbo_table_column}

      {dbo_table_column header="[AMOUNT]" sort_field="amount"}
        {dbo_echo|currency dbo="paymentdbo_table" field="amount"}
      {/dbo_table_column}

      {dbo_table_column header="[PAYMENT_TYPE]" sort_field="type"}
        {dbo_echo dbo="paymentdbo_table" field="type"}
      {/dbo_table_column}

      {dbo_table_column header="[MODULE]" sort_field="module"}
        {dbo_echo dbo="paymentdbo_table" field="module"}
      {/dbo_table_column}

      {dbo_table_column header="[PAYMENT_STATUS]" sort_field="status"}
        {dbo_echo dbo="paymentdbo_table" field="status"}
      {/dbo_table_column}

    {/dbo_table}

{/form}