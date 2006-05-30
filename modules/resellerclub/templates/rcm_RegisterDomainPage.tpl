<h2> {echo phrase="REGISTER"} {dbo_echo dbo="dspdbo" field="fulldomainname"} </h2>
{form name="rcm_customer"}
  <div class="form">
    <p> {echo phrase="SPECIFY_RESELLER_CLUB_ACCOUNT"}: </p>
    <table style="width: 90%">
      <tr>
        <th> {form_description field="customer"} </th>
        <td> {form_element field="customer"} </td>
      </tr>
      <tr>
        <th> {form_description field="username"} </th>
        <td> {form_element field="username" size="20"} </td>
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

{form name="rcm_customer_new"}
  <div class="form">
    <p> {echo phrase="CREATE_RESELLER_CLUB_ACCOUNT"}: </p>
    <table style="width: 90%">
      <tr>
        <th> {form_description field="username"} </th>
        <td> {form_element field="username" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="password"} </th>
        <td> {form_element field="password" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="contactname"} </th>
        <td> {form_element field="contactname" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="businessname"} </th>
        <td> {form_element field="businessname" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="address1"} </th>
        <td> {form_element field="address1" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="address2"} </th>
        <td> {form_element field="address2" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="city"} </th>
        <td> {form_element field="city" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="state"} </th>
        <td> {form_element field="state" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="country"} </th>
        <td> {form_element field="country" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="postalcode"} </th>
        <td> {form_element field="postalcode" size="10"} </td>
      </tr>
      <tr>
        <th> {form_description field="phone"} </th>
        <td> {form_element field="phone" size="15"} </td>
      </tr>
      <tr>
        <th> {form_description field="mobilephone"} </th>
        <td> {form_element field="mobilephone" size="15"} </td>
      </tr>
      <tr>
        <th> {form_description field="fax"} </th>
        <td> {form_element field="fax" size="15"} </td>
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
