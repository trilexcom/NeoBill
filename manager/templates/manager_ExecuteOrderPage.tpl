{form name="execute_order"}

  <h2> {echo phrase="ACCOUNT_INFORMATION"} </h2>
  <div class="form">
    <table style="width: 40em">
      <tr>
        <th> {form_description field="type"} </th>
        <td> {form_element field="type"} </td>
      </tr>
      <tr>
        <th> {form_description field="status"} </th>
        <td> {form_element field="status"} </td>
      </tr>
      <tr>
        <th> {echo phrase="USERNAME"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="username"} </td>
      </tr>
    </table>
  </div>

  <h2> {echo phrase="BILLING_INFORMATION"} </h2>
  <div class="form">
    <table style="width: 40em">
      <tr>
        <th> {form_description field="billingstatus"} </th>
        <td> {form_element field="billingstatus"} </td>
      </tr>
      <tr>
        <th> {form_description field="billingday"} </th>
        <td> {form_element field="billingday"} </td>
      </tr>
    </table>  
  </div>

  <h2> {echo phrase="CONTACT_INFORMATION"} </h2>
  <div class="properties">
    <table style="width: 40em"> 
      <tr>
        <th> {echo phrase="BUSINESS_NAME"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="businessname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="CONTACT_NAME"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="contactname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="CONTACT_EMAIL"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="contactemail"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ADDRESS"}: </th>
        <td>
          {dbo_echo dbo="orderdbo" field="address1"} <br/>
          {dbo_echo dbo="orderdbo" field="address2"} <br/>
        </td>
      </tr>
      <tr> 
        <th> {echo phrase="CITY"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="city"} </td>
      </tr>
      <tr>
        <th> {echo phrase="STATE"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="state"} </td>
      </tr>
      <tr>
        <th> {echo phrase="COUNTRY"}: </th>
        <td> {dbo_echo|country dbo="orderdbo" field="country"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ZIP_CODE"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="postalcode"} </td>
      </tr>
      <tr>
        <th> {echo phrase="PHONE"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="phone"} </td>
      </tr>
      <tr>
        <th> {echo phrase="MOBILE_PHONE"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="mobilephone"} </td>
      </tr>
      <tr>
        <th> {echo phrase="FAX"}: </th>
        <td> {dbo_echo dbo="orderdbo" field="fax"} </td>
      </tr>
    </table>
  </div>

  <h2> {echo phrase="ORDER_ITEMS"} </h2>
  <div class="table">
    {form_table field="items"}
  
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

    {/form_table}

    {form_element field="continue"}
    {form_element field="cancel"}
  </div>

{/form}
