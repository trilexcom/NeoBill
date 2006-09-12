<h2> {echo phrase="REGISTER_NEW_DOMAIN"} </h2>

{form name="register_domain_confirm"}
  <div class="properties">
    <p> {echo phrase="REGISTER_DOMAIN_CONFIRM"} </p>
    <table>
      <tr>
        <th> {echo phrase="ACCOUNT_NAME"}: </th>
        <td> {dbo_echo dbo="dspdbo" field="accountname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="DOMAIN_NAME"}: </th>
        <td> {dbo_echo dbo="dspdbo" field="fulldomainname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="REGISTRATION_TERMS"}: </th>
        <td> {dbo_echo dbo="dspdbo" field="termint"} year(s) </td>
      </tr>
      <tr>
        <th> {echo phrase="PRICE"}: </th>
        <td> {dbo_echo|currency dbo="dspdbo" field="price"} </td>
      </tr>
      <tr>
        <th> {echo phrase="NAME_SERVERS"}: </th>
        <td>
          {foreach from=$nameservers item=ns}
            {$ns}<br/>
          {/foreach}
        </td>
      </tr>
      <tr>
        <th> {echo phrase="NAME"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="contactname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="COMPANY"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="businessname"} </td>
      </tr>
      <tr>
        <th> {echo phrase="EMAIL"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="contactemail"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ADDRESS"}: </th>
        <td> 
          {dbo_echo dbo="accountdbo" field="address1"}<br>
          {dbo_echo dbo="accountdbo" field="address2"}
        </td>
      </tr>
      <tr>
        <th> {echo phrase="CITY"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="city"} </td>
      </tr>
      <tr>
        <th> {echo phrase="STATE"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="state"} </td>
      </tr>
      <tr>
        <th> {echo phrase="COUNTRY"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="country"} </td>
      </tr>
      <tr>
        <th> {echo phrase="PHONE"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="phone"} </td>
      </tr>
      <tr>
        <th> {echo phrase="FAX"}: </th>
        <td> {dbo_echo dbo="accountdbo" field="fax"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </td>
      </tr>
    </table>
  </div>
{/form}
