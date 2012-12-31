<div class="manager_content">
{form name="edit_account"}
<div class="form">

  <table>
    <thead>
      <tr>
        <th colspan="2"> [ACCOUNT] ({echo phrase="ID"}: {dbo_echo dbo="account_dbo" field="id"}) </th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
      <tr>
        <th> {form_description field="type"} </th>
        <td> {form_element dbo="account_dbo" field="type" option="Business Account"} </td>
      </tr>
      <tr>
        <th/>
        <td> {form_element dbo="account_dbo" field="type" option="Non-Profit Account"} </td>
      </tr>
      <tr>
        <th/>
        <td> 
          &nbsp; &nbsp; &nbsp; {form_description field="businessname"} <br/>
          &nbsp; &nbsp; &nbsp; {form_element dbo="account_dbo" field="businessname" size="60"}
        </td>
      </tr>
      <tr>
        <th/>
        <td> {form_element dbo="account_dbo" field="type" option="Individual Account"} </td>
      </tr>
      <tr>
        <th> {form_description field="status"} </th>
        <td> {form_element dbo="account_dbo" field="status"} </td>
      </tr>
    </tbody>
  </table>

  <table>
    <thead>
      <tr>
        <th colspan="2"> [BILLING_INFORMATION] </th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
      <tr>
        <th> {form_description field="billingstatus"} </th>
        <td> {form_element dbo="account_dbo" field="billingstatus"} </td>
      </tr>
      <tr>
        <th> {form_description field="billingday"} </th>
        <td> {form_element dbo="account_dbo" field="billingday" size="2"} </td>
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
          {form_element field="cancel"}
        </td>
        <td class="right">
          {form_element field="save"}
        </td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th> {form_description field="contactname"} </th>
        <td> {form_element dbo="account_dbo" field="contactname" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="contactemail"} </th>
        <td> {form_element dbo="account_dbo" field="contactemail" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="address1"} </th>
        <td> {form_element dbo="account_dbo" field="address1" size="40"} </th>
      </tr>
      <tr>
        <th> {form_description field="address2"} </th>
        <td> {form_element dbo="account_dbo" field="address2" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="city"} </th>
        <td> {form_element dbo="account_dbo" field="city" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="state"} </th>
        <td> {form_element dbo="account_dbo" field="state" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="postalcode"} </th>
        <td> {form_element dbo="account_dbo" field="postalcode" size="10"} </td>
      </tr>
      <tr>
        <th> {form_description field="country"} </th>
        <td> {form_element dbo="account_dbo" field="country"} </td>
      </tr>
      <tr>
        <th> {form_description field="phone"} </th>
        <td> {form_element dbo="account_dbo" field="phone" size="15"} </th>
      </tr>
      <tr>
        <th> {form_description field="mobilephone"} </th>
        <td> {form_element dbo="account_dbo" field="mobilephone" size="15"} </td>
      </tr>
      <tr>
        <th> {form_description field="fax"} </th>
        <td> {form_element dbo="account_dbo" field="fax" size="15"} </td>
      </tr>
    </tbody>
  </table>
</div class="form">
{/form}
</div>
