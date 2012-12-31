<div class="manager_content">
{form name="new_account"}
<div class="form">

  <table>
    <thead>
      <tr>
        <th colspan="2"> [ACCOUNT_INFORMATION] </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th> {form_description field="type"} </th>
        <td> {form_element field="type"} </td>
      </tr>                  <tr>            <th>{form_description field="businessname"}</th>                  <td> {form_element field="businessname" size="60"} </td>      </tr>            
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
    </tbody>
  </table>

  <table>
    <thead>
      <tr>
        <th colspan="2"> [BILLING_INFORMATION] </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th> {form_description field="billingstatus"} </th>
        <td> {form_element field="billingstatus"} </td>
      </tr>
      <tr>
        <th> {form_description field="billingday"} </th>
        <td> {form_element field="billingday" size="2"} </td>
      </tr>
    </tbody>
  </table>

  <table>
    <thead>
      <tr>
        <th colspan="2"> [CONTACT_INFORMATION] </th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td class="left">
          {form_element field="continue"}
        </td>
        <td class="right">
          {form_element field="cancel"}
        </td>
      </tr>
    </tfoot>
    <tbody>
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
    </tbody>
  </table>
</div class="form">
{/form}
</div>
