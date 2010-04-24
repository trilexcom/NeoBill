<p class="message"> 
  {echo phrase="ACCOUNT_CONFIRM"}
</p>
{form name="new_account_confirm"}
  <h2> {echo phrase="CREATE_ACCOUNT"} </h2>
  <div class="properties">
    <table style="width: 70%">
      <tr>
        <th> {echo phrase="ACCOUNT_NAME"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="accountname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ACCOUNT_TYPE"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="type"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ACCOUNT_STATUS"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="status"} </td>
      </tr>
      <tr>
        <th> [USERNAME]: </th>
        <td> {dbo_echo dbo="user_dbo" field="username"} </td>
      </tr>
      <tr>
        <th> {echo phrase="BILLING_STATUS"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="billingstatus"} </td>
      </tr>
      <tr>
        <th> {echo phrase="BILLING_DAY"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="billingday"} </td>
      </tr>
      <tr>
        <th> {echo phrase="CONTACT_NAME"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="contactname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="CONTACT_EMAIL"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="contactemail"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ADDRESS"}: </th>
        <td>
          {dbo_echo dbo="new_account_dbo" field="address1"} <br/>
          {dbo_echo dbo="new_account_dbo" field="address2"} <br/>
        </td>
      </tr>
      <tr> 
        <th> {echo phrase="CITY"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="city"} </td>
      </tr>
      <tr>
        <th> {echo phrase="STATE"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="state"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ZIP_POSTAL_CODE"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="postalcode"} </td>
      </tr>
      <tr>
        <th> {echo phrase="COUNTRY"}: </th>
        <td> {dbo_echo|country dbo="new_account_dbo" field="country"} </td>
      </tr>
      <tr>
        <th> {echo phrase="PHONE"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="phone"} </td>
      </tr>
      <tr>
        <th> {echo phrase="MOBILE_PHONE"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="mobilephone"} </td>
      </tr>
      <tr>
        <th> {echo phrase="FAX"}: </th>
        <td> {dbo_echo dbo="new_account_dbo" field="fax"} </td>
      </tr>
      <tr class="footer">
        <th class="footer"> 
          {form_element field="continue"}
          {form_element field="cancel"}
        </th>
        <td/>
      </tr>
    </table>
  </div
{/form}
