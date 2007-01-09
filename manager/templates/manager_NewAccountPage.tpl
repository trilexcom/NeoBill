{form name="new_account"}
<div class="form">

  <h2> {echo phrase="ACCOUNT_INFORMATION"} </h2>
  <table style="width: 70%">
    <tr>
      <th> {form_description field="type"} </th>
      <td> {form_element field="type" option="Business Account"} </td>
    </tr>
    <tr>
      <th/>
      <td> 
        &nbsp; &nbsp; &nbsp; {form_description field="businessname"} <br/>
        &nbsp; &nbsp; &nbsp; {form_element field="businessname" size="30"}
      </td>
    </tr>
    <tr>
      <th/>
      <td> {form_element field="type" option="Individual Account"} </td>
    </tr>
    <tr>
      <th> {form_description field="status"} </th>
      <td> {form_element field="status"} </td>
    </tr>
    <tr>
      <th> {form_description field="username"} </th>
      <td> {form_element field="username"} </td>
    </tr>
    <tr>
      <th> {form_description field="password"} </th>
      <td> {form_element field="password"} </td>
    </tr>
  </table>

  <h2> {echo phrase="BILLING_INFORMATION"} </h2>
  <table style="width: 70%">
    <tr>
      <th> {form_description field="billingstatus"} </th>
      <td> {form_element field="billingstatus"} </td>
    </tr>
    <tr>
      <th> {form_description field="billingday"} </th>
      <td> {form_element field="billingday" size="2"} </td>
    </tr>
  </table>

  <h2> {echo phrase="CONTACT_INFORMATION"} </h2>
  <table style="width: 70%">
    <tr>
      <th> {form_description field="contactname"} </th>
      <td> {form_element field="contactname" size="30"} </td>
    </tr>
    <tr>
      <th> {form_description field="contactemail"} </th>
      <td> {form_element field="contactemail" size="30"} </td>
    </tr>
    <tr>
      <th> {form_description field="address1"} </th>
      <td> {form_element field="address1" size="40"} </th>
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
      <th> {form_description field="postalcode"} </th>
      <td> {form_element field="postalcode" size="10"} </td>
    </tr>
    <tr>
      <th> {form_description field="country"} </th>
      <td> {form_element field="country"} </td>
    </tr>
    <tr>
      <th> {form_description field="phone"} </th>
      <td> {form_element field="phone" size="15"} </th>
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
      <th colspan="2">
        {form_element field="continue"}
        {form_element field="cancel"}
      </th>
    </tr>
  </table>
</div class="form">
{/form}
